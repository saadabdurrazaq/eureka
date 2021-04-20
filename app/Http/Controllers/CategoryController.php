<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use PDF;
use App\Exports\CategoryExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use DataTables;

class CategoryController extends Controller
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
        $countTrash = \App\Category::onlyTrashed()->count();
        $count = \App\Category::count();

        if ($request->ajax()) {
            $data = \App\Category::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editCategory" id="editCategory">Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-warning btn-sm deleteCategory">Trash</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('categories.categories')->with(array('count' => $count, 'countTrash' => $countTrash));
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
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $convertString = json_encode($request->get('name')); //object to json string conversion
        $dataString = json_decode($convertString); // json string to array
        $names = explode(",", $dataString);

        foreach ($names as $name) {
            \App\Category::insert([
                'name'    => $name
            ]);
        }

        return response()->json(['success' => 'Category added successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \App\Category::find($id);

        $html = '<div class="row">
        <div class="col-md-6">
            <label for="name">Name</label>
            <input value="' . $user->name . '" class="form-control"
                placeholder="Full Name" type="text" name="name" id="nameForEdit" />
    </div> <!-- row-->';

        return response()->json(['html' => $html, 'user' => $user]);
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $input = $request->all();

        $user = \App\Category::find($id);
        $user->update($input);

        return response()->json(['success' => 'Category updated successfully']);
    }

    /**
     * Remove the specified resource from storage. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Category::find($id)->delete();

        return response()->json(['success' => 'Category trashed successfully.']);
    }

    public function destroyMultiple(Request $request)
    {
        $get_ids = $request->ids;
        $ids = explode(',', $get_ids);
        $users = \App\Category::whereIn('id', $ids);
        $users->delete();

        DB::table("social_facebook_accounts")->whereIn('user_id', $ids)->delete();
        DB::table("social_google_accounts")->whereIn('user_id', $ids)->delete();

        return response()->json(['success' => "Users successfully moved to trash."]);
    }

    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');

        $categories = DB::table('categories')->where("name", "LIKE", "%$keyword%")->get();

        return $categories;
    }

    public function trash(Request $request)
    {
        $filterKeyword = $request->get('keyword');
        $status = $request->get('status');

        $count = \App\Category::count();
        $activeStatus = \App\Category::where('status', "ACTIVE")->count();
        $inactiveStatus = \App\Category::where('status', "INACTIVE")->count();
        $countTrash = \App\Category::onlyTrashed()->count();

        $count = \App\Category::count();
        $items = $request->items ?? 5;
        $page    = $request->has('name') ? $request->get('name') : 1;
        $showingTotal  = $page * $items;
        $admins = \App\Category::paginate($items);
        $showingStarted = $admins->currentPage();

        $showData = "Showing $showingStarted to $showingTotal of $countTrash";

        if ($status) {
            $data = \App\Category::where('status', $status)->paginate($items);
        } else {
            $data = \App\Category::onlyTrashed()->paginate($items);
        }

        if ($filterKeyword) {
            if ($status) {
                $data = \App\Category::onlyTrashed()->where('name', 'LIKE', "%$filterKeyword%")->orWhere('email', 'LIKE', "%$filterKeyword%")->where('status', $status)->paginate($items);
            } else {
                $data = \App\Category::onlyTrashed()->where('name', 'LIKE', "%$filterKeyword%")->orWhere('email', 'LIKE', "%$filterKeyword%")->paginate($items);
            }
        }

        return view('users.trash', compact('data'))->with(array('showData' => $showData, 'count' => $count, 'activeStatus' => $activeStatus, 'inactiveStatus' => $inactiveStatus, 'countTrash' => $countTrash))->withItems($items); //admin mengacu ke table admin di phpmyadmin
    }

    public function restore($id)
    {
        $category = \App\Category::withTrashed()->findOrFail($id);

        if ($category->trashed()) {
            $category->restore();
        } else {
            return redirect()->route('users.trash')->with('status', 'User is not in trash');
        }

        return redirect()->route('users.trash')->with('status', 'User successfully restored');
    }

    public function restoreMultiple(Request $request)
    {
        $get_ids = $request->ids;
        $ids = explode(',', $get_ids);
        $users = \App\Category::whereIn('id', $ids);
        $users->restore();

        return response()->json(['success' => "Users successfully restored"]);
    }

    public function deletePermanent($id)
    {
        $category = \App\Category::withTrashed()->findOrFail($id);

        if (!$category->trashed()) {
            return redirect()->route('users.trash')->with('status', 'Can not delete permanent user');
        } else {
            $category->forceDelete();
            DB::table("social_facebook_accounts")->where('user_id', $id)->delete(); //agar user yang sudah dihapus dan mencoba kembali login dengan facebook, tampil halaman error
            DB::table("social_google_accounts")->where('user_id', $id)->delete();
            return redirect()->route('users.trash')->with('status', 'User permanently deleted');
        }
    }

    public function deleteMultiple(Request $request)
    {
        $get_ids = $request->ids;
        $ids = explode(',', $get_ids);
        $users = \App\Category::whereIn('id', $ids);
        $users->forceDelete();

        DB::table("social_facebook_accounts")->whereIn('user_id', $ids)->delete();
        DB::table("social_google_accounts")->whereIn('user_id', $ids)->delete();

        return response()->json(['success' => "Users successfully permanently deleted"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Category::find($id);
        return view('users.show', compact('user'));
    }

    public function downloadPDF()
    {
        $user = \App\Category::all();
        $pdf = PDF::loadview('categories.pdf', ['user' => $user]);
        return $pdf->stream();
    }

    public function downloadExcel()
    {
        return Excel::download(new CategoryExport, 'list-users.xlsx');
    }

    public function downloadWord()
    {
        $user = \App\Category::all();
        $headers = array(
            "Content-type"        => "text/html",
            "Content-Disposition" => "attachment;Filename=list-users.doc"
        );
        $content =  view('categories.pdf', ['user' => $user])->render();
        return \Response::make($content, 200, $headers);
    }
}
