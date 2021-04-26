<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use PDF;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Redirect;
use Illuminate\Validation\Rule;
use DataTables;

class ProductController extends Controller
{
    public $request;

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    function __construct(Request $request)
    {
        $this->middleware('permission:View Users|Create Users|Edit User|Show User|Trash Users|Restore Users|Delete Users|Activate Users|Deactivate Users', ['only' => ['index', 'active', 'inactive', 'trash', 'show']]);
        $this->middleware('permission:Create Users', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit User', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Trash Users', ['only' => ['destroy', 'destroyMultiple']]);
        $this->middleware('permission:Delete Users', ['only' => ['deletePermanent', 'deleteMultiple']]);
        $this->middleware('permission:Activate Users', ['only' => ['activate', 'activateMultiple']]);
        $this->middleware('permission:Deactivate Users', ['only' => ['deactivate', 'deactivateMultiple']]);
        $this->middleware('permission:Restore Users', ['only' => ['restore', 'restoreMultiple']]);

        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countTrash = \App\Product::onlyTrashed()->count();
        $count = \App\Product::count();

        if ($request->ajax()) {
            $data = \App\Product::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct" id="editProduct">Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->addColumn('categories', function ($product) {
                    if ($product->category) {
                        $elements = [];
                        foreach ($product->category as $v) {
                            $elements[] = $v->name;
                        }
                        $res = implode(', ', $elements);
                        return $res;
                    }
                })
                ->addColumn('stok', function ($product) {
                    if ($product->stok) {
                        return $product->stok->jumlah_barang;
                    }
                })
                ->addColumn('photo', function ($product) {
                    $pict = [];
                    foreach (json_decode($product->product_photo) as $picture) {
                        $pict[] = '<img src="/reference/eureka/storage/app/' . $picture->path . '" style="height:120px; width:105px; margin-bottom:10px;"/>';
                    }
                    $pict = implode(', ', $pict);
                    return $pict;
                })
                ->rawColumns(['action', 'categories', 'stok', 'photo'])
                ->make(true);
        }

        return view('products.products')->with(array('count' => $count, 'countTrash' => $countTrash));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'categories' => 'required',
            'stok' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // Save data to table product
        $productName = $request->get('name');
        $productCode = $request->get('code');
        $productStok = $request->get('stok');
        $categoriesId = $request->get('categories');

        $categoryId = explode(",", $categoriesId);

        $checkProductCode = \App\Product::where('product_code', '=', $request->get('code'))->first();

        if ($checkProductCode === null) {

            /*if ($request->file('images')) { // single image
                //insert new file
                $destinationPath = 'public/product_images/'; // upload path
                $product_photo = $request->file('images')->store($destinationPath);
            }*/

            if ($request->TotalImages > 0) {

                for ($x = 0; $x < $request->TotalImages; $x++) {

                    if ($request->hasFile('images' . $x)) {
                        $file = $request->file('images' . $x);

                        $path = $file->store('public/product_images/');
                        $name = $file->getClientOriginalName();

                        $product_photo[$x]['name'] = $name;
                        $product_photo[$x]['path'] = $path;
                    }
                }

                $productId = DB::table('products')->insertGetId(
                    [
                        'name' => $productName,
                        'product_code' => $productCode,
                        'product_photo' =>  json_encode($product_photo)
                    ]
                );

                $idStok = DB::table('stok')->insertGetId(
                    [
                        'jumlah_barang' => $productStok
                    ]
                );

                $stokId = \App\Stok::withTrashed()->findOrFail($idStok);
                $theProductId = \App\Product::withTrashed()->findOrFail($productId);

                // Save relationship data between product and categories
                $theProductId->category()->attach($categoryId);

                // Save relationship data between stok and product
                $stokId->product()->associate($theProductId)->save();
            } else {
                $imageValidator = \Validator::make($request->all(), [
                    'images' => 'required|file|mimes:jpeg,png,jpg,gif,svg',
                ]);
                return response()->json(['errors' => $imageValidator->errors()->all()]);
            }
        } else {
            $rules = [
                'code' => 'required',
            ];

            $customMessages = [
                'required' => 'The code product must be unique.'
            ];

            return response()->json(['errors' => $request->validate($rules, $customMessages)]);
        }

        return response()->json(['success' => 'Product added successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = \App\Product::find($id);

        $html =
            '<div class="row">
           <div class="col-md-4">
              <label for="name">Product Code</label>
              <input value="' . $product->product_code . '" class="form-control"
                  placeholder="Product Code" type="text" name="code" id="codeForEdit" readonly/>
              <br>
           </div>
           <div class="col-md-8">
                            <label for="name">Product Name</label>
                            <input value="' . $product->name . '"
                                class="form-control"
                                placeholder="Product name" type="text" name="nameForEdit" id="nameForEdit" />
                            <br>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <label for="roles">Category</label><br> 
            <select style="width:100%;" placeholder="Select Categories" name="categoriesForEdit[]" multiple
                id="categoriesForEdit"
                class="categoriesForEdit form-control"></select>
            <br>
        </div>
        </div> <!-- row-->
        <br> 
        <div class="row">
                        <div class="col-md-2">
                            <label for="name">Stok</label>
                            <input value="' . $product->stok->jumlah_barang . '"
                                class="form-control stokForEdit" placeholder=""
                                type="text" name="stokForEdit" id="stokForEdit" />
                        </div>
                        <div class="col-md-10">
                            <label for="name">Photo</label>
                            <input id="photo" name="photo" type="file" multiple
                                class="form-control"
                                data-iconName="fa fa-upload" data-overwrite-initial="false">
                            <br>
                        </div>
        </div>
        <!-- row-->';

        return response()->json(['html' => $html, 'product' => $product->category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = \App\Product::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'nameForEdit' => 'required',
            'categoriesForEdit' => 'required',
            'stokForEdit' => 'required|numeric',
            //'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $productName = $request->get('nameForEdit');
        $categories = $request->get('categoriesForEdit');
        $jumlahBarang = $request->get('stokForEdit');

        $user->name = $productName;
        $user->save();

        $theProductId = \App\Product::withTrashed()->findOrFail($id);

        // Assign categories
        $theProductId->category()->sync($categories);

        // Update stok
        $stokBarang = \App\Stok::with('product')
            ->WhereHas('product', function ($q) use ($id) {
                $q->where('id', $id);
            });
        $stokBarang->update(['jumlah_barang' => $jumlahBarang]);

        return response()->json(['success' => 'Product updated successfully']);
    }

    public function deletePermanent($id)
    {
        $theProductId = \App\Product::findOrFail($id);

        // Delete categories relation
        $theProductId->category()->detach();

        // Delete relation of stok
        $stokBarang = \App\Stok::with('product')
            ->WhereHas('product', function ($q) use ($id) {
                $q->where('id', $id);
            });
        $stokBarang->forceDelete();

        $theProductId->forceDelete();

        return response()->json(['success' => 'Product deleted successfully.']);
    }

    public function downloadPDF()
    {
        $products = \App\Product::all();
        $pdf = PDF::loadview('products.pdf', ['products' => $products]);
        return $pdf->stream();
    }

    public function downloadExcel()
    {
        return Excel::download(new ProductsExport, 'list-products.xlsx');
    }

    public function downloadWord()
    {
        $user = \App\Product::all();
        $headers = array(
            "Content-type"        => "text/html",
            "Content-Disposition" => "attachment;Filename=list-users.doc"
        );
        $content =  view('products.pdf', ['user' => $user])->render();
        return \Response::make($content, 200, $headers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Product::find($id);
        return view('users.show', compact('user'));
    }
}
