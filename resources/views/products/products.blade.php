@extends("layouts.app")

@section('title') Users list @endsection

@section('index-admin-list')
    {{ Breadcrumbs::render('list-user') }}
@endsection

@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

@section('loader')
    <div class="whole-page-overlay" id="whole_page_loader">
        <img class="center-loader" src="{{ asset('public/images/loader.svg') }}" alt="" width="50" height="50">
    </div>
@endsection

<div class="container">
    <div class="row" style="margin-top:-20px;">
        <div class="col-md-6">
            <nav class="navecation" style="margin-left:-40px;">
                <ul id="navi" style="margin-top:40px;">
                    <li><a class="menu {{ request()->is('products*') ? 'current' : '' }}"
                            href="{{ route('products.index') }}">All ({{ $count }})</a></li>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-md-6 text-right">
            <a class="btn btn-primary" href="javascript:void(0)" style="margin-top:25px;" id="createNewProduct"> Create
                New
                Product</a> <!-- javascript:void(0) -->
            <a href="{{ route('categories.index') }}" style="margin-top:25px;" class="btn btn-primary">List of
                Categories</a>
        </div>
    </div>
    <hr>
    <div class="panel-body table-responsive" style="overflow:hidden;">
        <table class="table table-bordered table-hover data-table dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Stok</th>
                    <th>Photo</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="ajaxModelForCreate" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeadingForCreate"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Product was added successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="dataProductElementForCreate" name="dataProductElementForCreate" class="form-horizontal">
                    <input type="hidden" name="product_idForCreate" id="product_idForCreate">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Product Code</label>
                            <input value="{{ old('code') }}"
                                class="form-control {{ $errors->first('code') ? 'is-invalid' : '' }}"
                                placeholder="Product code" type="text" name="code" id="code" />
                            <span class="text-danger" id="codeError"></span>
                            <div class="invalid-feedback">
                                {{ $errors->first('code') }}
                            </div>
                            <br>
                        </div>
                        <div class="col-md-8">
                            <label for="name">Product Name</label>
                            <input value="{{ old('name') }}"
                                class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                                placeholder="Product name" type="text" name="name" id="name" />
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="roles">Category</label><br>
                            <select style="width:100%;" placeholder="Select Categories" name="categories[]" multiple
                                id="categories"
                                class="categories form-control {{ $errors->first('categories') ? 'is-invalid' : '' }}"></select>
                            <div class="invalid-feedback">
                                {{ $errors->first('categories') }}
                            </div>
                            <br>
                        </div>
                    </div> <!-- row-->
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="name">Stok</label>
                            <input value="{{ old('stok') }}"
                                class="form-control {{ $errors->first('stok') ? 'is-invalid' : '' }}" placeholder=""
                                type="text" name="stok" id="stok" />
                            <div class="invalid-feedback">
                                {{ $errors->first('stok') }}
                            </div>
                        </div>
                        <div class="col-md-10">
                            <label for="name">Photo</label>
                            <input id="photo" name="photo" type="file" multiple
                                class="form-control {{ $errors->first('photo') ? 'is-invalid' : '' }}"
                                data-iconName="fa fa-upload" data-overwrite-initial="false">
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 text-right modal-footer" style="margin-top:15px;">
                <button type="submit" class="btn btn-primary" id="saveBtnForCreate" value="create">Save
                    changes
                </button>
            </div>
        </div> <!-- modal content-->
    </div>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Product was updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="dataProductElement" name="dataProductElement" class="form-horizontal">
                    <input type="hidden" name="product_id" id="product_id">
                </div>
            </div>
            <div class="col-sm-12 text-right modal-footer" style="margin-top:15px;">
                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save
                    changes
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('crud-js')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<!-- sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
    rel="stylesheet">
<link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
<!-- Tokenfield -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"
    integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ=="
    crossorigin="anonymous" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css"
    integrity="sha512-YWDtZYKUekuPMIzojX205b/D7yCj/ZM82P4hkqc9ZctHtQjvq3ei11EvAmqxQoyrIFBd9Uhfn/X6nJ1Nnp+F7A=="
    crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"
    integrity="sha512-A2ag+feOqri5SJxJ54oIIFj9/JuhZqiNNwyNLiAvQIyxJQT5JvZzn17vAb4BkP0a210NWz1DlsnLuRKZdouBnw=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
    integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
    crossorigin="anonymous"></script>
<!-- select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<script type="text/javascript">
    $('#categories').select2({
        placeholder: "Select categories",
        ajax: {
            url: '{{ url('searchcategories') }}',
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: item.name
                        }
                    })
                }
            }
        }
    });

    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('products.index') }}",
            dom: '<l<"toolbar">f>rtip',
            initComplete: function() {
                $("div.toolbar").html(
                    '<div style="float:left;margin-left:4px;"><select class="form-control select2bs4 trash_all" style="width:140px;height:32px;margin-left:10px;" data-select2-id="17" tabindex="-1" aria-hidden="true"><option selected="selected" data-select2-id="19">Bulk Actions</option><option data-select2-id="38" value="trashAll">Trash</option></select></div><div style="float:left;margin-left:20px;"><select onchange="window.location = this.options[this.selectedIndex].value" class="form-control select2bs4 download-doc" style="width:140px;height:32px;margin-left:10px;padding-bottom:5px"" data-select2-id="17" tabindex="-1" aria-hidden="true"><option selected="selected" data-select2-id="19" value="{{ route('products.index') }}">Download</option><option data-select2-id="38" value="{{ route('products.pdf') }}">PDF</option><option data-select2-id="39" value="{{ route('products.excel') }}">XLS</option><option data-select2-id="39" value="{{ route('products.word') }}">Doc</option></select></div>'
                );
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'product_code',
                    name: 'product_code'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'categories',
                    name: 'categories'
                },
                {
                    data: 'stok',
                    name: 'stok'
                },
                {
                    data: 'photo',
                    name: 'photo',
                    render: function(data, type, full, meta) {
                        return "<img src=\"/reference/eureka/storage/app/" + data +
                            "\" height=\"50\"/>";
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $("div.toolbar").css("float", "left");

        $('#createNewProduct').click(function() {
            $('#saveBtnForCreate').val("create-product");
            $('#product_idForCreate').val('');
            $('#modelHeadingForCreate').html("Create New Product");
            $('#ajaxModelForCreate').modal('show');
        });

        // Create product Ajax request.
        $('#saveBtnForCreate').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData();

            formData.append('photo', $('#photo')[0].files[0]); // for single item
            formData.append('name', $("input[name='name']").val());
            formData.append('code', $('#code').val());
            formData.append('categories', $('#categories').val());
            formData.append('stok', $('#stok').val());

            /*formData.append('_token', '{{ csrf_token() }}');
            let TotalImages = $('#photo')[0].files.length;
            let images = $('#photo')[0];
            for (let i = 0; i < TotalImages; i++) {
                formData.append('photo[]', images.files[i]);
            }
            formData.append('photo', TotalImages);*/

            $.ajax({
                url: "{{ route('products.store') }}",
                method: 'post',
                enctype: 'multipart/form-data',
                cache: false,
                data: formData,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                async: false,
                headers: {
                    'Content-Type': undefined,
                },
                xhr: function() {
                    myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                },
                success: function(result) {
                    if (result.errors) {
                        $('.alert-danger').html(
                            'An error in your input!'
                        );
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>' + value +
                                '</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function() {
                            $('.alert-success').hide();
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });

        $('body').on('click', '#editProduct', function(e) { // .editUser exist in usercontroller.php

            e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();

            id = $(this).data('id');

            $.ajax({
                url: "product/" + id + "/edit",
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#dataProductElement').html(data.html);
                    var categories = $('#dataProductElement').find(
                        ".categoriesForEdit");
                    $(categories).select2({
                        ajax: {
                            url: '{{ url('searchcategories') }}',
                            processResults: function(data) {
                                return {
                                    results: data.map(function(item) {
                                        return {
                                            id: item.id,
                                            text: item.name
                                        }
                                    })
                                }
                            }
                        }
                    });

                    var positions = data.product;

                    positions.forEach(function(product) {
                        var option = new Option(product.name, product.id, true,
                            true);
                        $(categories).append(option).trigger('change');
                    });

                    $('#saveBtn').val("create-product");
                    $('#product_id').val('');
                    $('#productForm').trigger("reset");
                    $('#modelHeading').html("Update Product");
                    $('#ajaxModel').modal('show');
                }
            });
        });

        // Update user Ajax request.
        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "products/" + id,
                method: 'PUT',
                data: {
                    nameForEdit: $('#nameForEdit').val(),
                    codeForEdit: $('#codeForEdit').val(),
                    categoriesForEdit: $('#categoriesForEdit').val(),
                    stokForEdit: $('#stokForEdit').val(),
                },
                success: function(result) {
                    if (result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>' + value +
                                '</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function() {
                            $('.alert-success').hide();
                            $('#ajaxModel').hide();
                            location.reload();
                        }, 2000);
                    }
                },
                error: function(response) {
                    $('#codeError').text(response.responseJSON.errors.code);
                }
            });
        });

        $('body').on('click', '.deleteProduct', function() {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "product/" + id + "/delete-permanent",
                        type: "DELETE",
                        error: function() {
                            alert('Something is wrong');
                        },
                        success: function(data) {
                            table.draw();
                            Swal.fire(
                                'Deleted!',
                                'Your record has been deleted.',
                                'success'
                            )
                        }
                    });
                } else {
                    Swal.fire("Cancelled", "Your data is safe :)", "error");
                }
            });

        });

        $("#photo").fileinput({
            theme: 'fa',
            uploadUrl: '{{ route('products.store') }}',
            uploadExtraData: function() {
                return {
                    _token: $("input[name='_token']").val(),
                };
            },
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            overwriteInitial: false,
            maxFileSize: 2000,
            maxFilesNum: 5,
            slugCallback: function(filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });


    }); // END

</script>
@endsection
