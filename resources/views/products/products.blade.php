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
            <a class="btn btn-primary" href="javascript:void(0)" data-modal="ajaxModelForCreate"
                style="margin-top:25px;" id="createNewProduct">
                Create
                New
                Product</a> <!--  href="javascript:void(0)" -->
            <a href="{{ route('categories.index') }}" style="margin-top:25px;" class="btn btn-primary">List of
                Categories</a>
        </div>
    </div>
    <hr>
    <div class="panel-body table-responsive">
        <table class="table table-bordered table-hover data-table dataTable" style="width:100%;">
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

<div class="modal hide fade" id="ajaxModelForCreate" aria-hidden="true" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeadingForCreate"></h4>
                <button type="button" class="close closeModalForCreate" data-dismiss="modal">&times;</button>
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
                        <div class="col-md-6">
                            <label for="name">Product Name</label>
                            <input value="{{ old('name') }}"
                                class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                                placeholder="Product name" type="text" name="name" id="name" />
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            <br>
                        </div>
                        <div class="col-md-2">
                            <label for="name">Stok</label>
                            <input value="{{ old('stok') }}"
                                class="form-control {{ $errors->first('stok') ? 'is-invalid' : '' }}" placeholder=""
                                type="text" name="stok" id="stok" />
                            <div class="invalid-feedback">
                                {{ $errors->first('stok') }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="roles">Category</label><br>
                            <select multiple style="width:100%;" placeholder="Select Categories" name="categories[]"
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
                        <div class="col-md-12">
                            <label for="name">Photo</label>
                            <div class="file-loading">
                                <input id="images" name="images[]" type="file" multiple>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="image_preview">

                        </div>
                    </div> <!-- row-->
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

<!-- ajax model for edit and update -->
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

<div class="modal fade" id="ajaxModelForPhoto" aria-hidden="true">
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
                <div id="dataPhotoElement" name="dataPhotoElement" class="form-horizontal">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('crud-js')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
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

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var sweet_loader =
            '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';

        // In custom.css, table header need to be adjusted to the body width when sidebar is collapsed. 
        var table = $('.data-table').DataTable({
            "lengthMenu": [5, 10, 20, 40],
            processing: true,
            "language": {
                "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            serverSide: true,
            responsive: true,
            ajax: "{{ route('products.index') }}",
            //scrollY: 200,
            scrollX: true,
            sScrollXInner: "100%",
            dom: '<l<"toolbar">f>rtip',
            initComplete: function() { // must be exist, because if this removed, no response after any submit
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
                        return data;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    "width": "20%",
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $(".dataTables_filter input, .dataTables_length select").css({
            "background-color": "#fff",
        });

        $(".table-responsive")
            .css({
                "padding-bottom": "30px",
            });

        $(".dataTables_wrapper .dataTables_scroll")
            .css({
                "margin-bottom": "10px",
            });

        function imgInputForCreate() {
            $("#images").fileinput({
                theme: 'fas',
                uploadUrl: '{{ route('products.store') }}',
                dropZoneEnabled: false,
                browseOnZoneClick: false,
                showUpload: false,
                fileActionSettings: {
                    showUpload: false,
                },
                previewSettings: {
                    image: {
                        width: "auto",
                        height: "auto",
                        'max-width': "100%",
                        'max-height': "100%"
                    },
                },
                uploadExtraData: function() {
                    return {
                        _token: $(
                                "input[name='_token']")
                            .val(),
                    };
                },
                allowedFileExtensions: ['jpg', 'jpeg',
                    'png', 'gif'
                ],
                overwriteInitial: false,
                maxFileSize: 2000,
                maxFilesNum: 5,
                slugCallback: function(filename) {
                    return filename.replace('(', '_')
                        .replace(']', '_');
                }
            });
        }

        $('#createNewProduct').on('click', function() {
            $('#saveBtnForCreate').val("create-product");
            $('#product_idForCreate').val('');
            $('#modelHeadingForCreate').html("Create New Product");
            var idModal = $(this).data("modal");
            $("#" + idModal).modal('show');
            imgInputForCreate();
        });

        $('.closeModalForCreate').on('click', function() {
            $('#images').fileinput('destroy');
        });

        $("#images").change(function() {
            $('#image_preview').html("");
            var total_file = document.getElementById("images").files.length;
            /*for (var i = 0; i < total_file; i++) {
                $('#image_preview').append(
                    "<div class='array-images' style='position:relative;float:left;margin-right:5px;'><button type='submit' style='position:absolute;top:0;left:0;top:2px;left:5px;margin-left:80px;' class='close' aria-label='Close'><span>&times;</span></button><img style='height:120px;width:105px;' src='" +
                    URL
                    .createObjectURL(event.target.files[i]) +
                    "'>");
            } */
        });

        $(document).on('click', '.close', function() {
            var input = $("#images");
            input.replaceWith(input.val('').clone(true));
            $(this).parent('div.array-images').fadeOut();
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

            //formData.append('images', $('#images')[0].files[0]); // for single item
            formData.append('name', $("input[name='name']").val());
            formData.append('code', $('#code').val());
            formData.append('categories', $('#categories').val());
            formData.append('stok', $('#stok').val());

            let TotalImages = $('#images')[0].files.length; //Total Images
            let images = $('#images')[0];
            for (let i = 0; i < TotalImages; i++) {
                formData.append('images' + i, images.files[i]);
            }
            formData.append('TotalImages', TotalImages);

            $.ajax({
                url: "{{ route('products.store') }}",
                method: 'post',
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                async: true,
                headers: {
                    'Content-Type': undefined,
                },
                xhr: function() {
                    myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                },
                beforeSend: function() {
                    swal.fire({
                        html: '<h5>Loading...</h5>',
                        showConfirmButton: false,
                        onRender: function() {
                            $('.swal2-content').prepend(
                                sweet_loader);
                        }
                    });
                },
                error: function() {
                    alert('Something is wrong');
                },
                success: function(result) {
                    if (result.errors) {
                        swal.close();
                        $('.alert-danger').show();
                        $('.alert-danger').html(
                            'An error in these fields! Make sure you input all fields, product code must be unique and no more than 5 images'
                        );
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>' + value +
                                '</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        // no reload page
                        table.draw();
                        $('.datatable').DataTable().ajax.reload();
                        $('#ajaxModelForCreate').removeData();
                        $('#code').val('');
                        $('#name').val('');
                        $('#stok').val('');
                        $('#categories').empty();
                        $("#images").fileinput('clear');
                        $('#images').fileinput('refresh');
                        $('#ajaxModelForCreate').hide();
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '0');
                        setInterval(function() { // remove cache image in index table
                            $(".datatable").dataTable().fnDraw();
                            $('.alert-success').hide();
                        }, 1000);

                        Swal.fire(
                            'Submitted!',
                            'Your record has been submitted.',
                            'success'
                        );
                    } //endif
                }
            }); //ajax
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
                beforeSend: function() {
                    swal.fire({
                        html: '<h5>Loading...</h5>',
                        showConfirmButton: false,
                        onRender: function() {
                            $('.swal2-content').prepend(
                                sweet_loader);
                        }
                    });
                },
                success: function(data) {
                    swal.close();
                    $('#dataProductElement').html(data.html);

                    // fill categories
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

                    // setting photo field
                    var photo = $('#dataProductElement').find(
                        "#photoForEdit");
                    $(photo).fileinput({
                        theme: 'fas',
                        uploadUrl: '{{ route('products.store') }}',
                        dropZoneEnabled: false,
                        browseOnZoneClick: false,
                        showUpload: false,
                        fileActionSettings: {
                            showUpload: false,
                        },
                        previewSettings: {
                            image: {
                                width: "auto",
                                height: "auto",
                                'max-width': "100%",
                                'max-height': "100%"
                            },
                        },
                        uploadExtraData: function() {
                            return {
                                _token: $("input[name='_token']").val(),
                            };
                        },
                        allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                        overwriteInitial: false, // prevent an error after submit
                        maxFileSize: 2000,
                        maxFilesNum: 5,
                        slugCallback: function(filename) {
                            return filename.replace('(', '_').replace(']', '_');
                        }
                    });

                    // Show and manipulate modal
                    $('#saveBtn').val("create-product");
                    $('#product_id').val('');
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

            var formDataEdit = new FormData();

            formDataEdit.append('nameForEdit', $("input[name='nameForEdit']")
                .val());
            formDataEdit.append('codeForEdit', $('#codeForEdit').val());
            formDataEdit.append('categoriesForEdit', $('#categoriesForEdit').val());
            formDataEdit.append('stokForEdit', $('#stokForEdit').val());

            let TotalImages = $('#photoForEdit')[0].files.length; //Total Images
            let images = $('#photoForEdit')[0];
            for (let i = 0; i < TotalImages; i++) {
                formDataEdit.append('images' + i, images.files[i]);
            }
            formDataEdit.append('TotalImages', TotalImages);

            formDataEdit.append('_method', 'PUT');

            $.ajax({
                url: "products/" + id,
                method: 'POST',
                data: formDataEdit,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                async: true,
                headers: {
                    'Content-Type': undefined,
                },
                xhr: function() {
                    myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                },
                beforeSend: function() {
                    swal.fire({
                        html: '<h5>Loading...</h5>',
                        showConfirmButton: false,
                        onRender: function() {
                            $('.swal2-content').prepend(
                                sweet_loader);
                        }
                    });
                },
                success: function(result) {
                    if (result.errors) {
                        swal.close();
                        $('.alert-danger').html(
                            'An error in your input fields. Make sure you input all fields, and total images no more than 5.'
                        );
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>' + value +
                                '</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        table.draw();
                        $('.datatable').DataTable().ajax.reload();
                        $('#ajaxModel').removeData();
                        $("#photoForEdit").fileinput('clear');
                        $('#photoForEdit').fileinput('refresh');
                        $('#images').fileinput('destroy');
                        $('#ajaxModel').hide();
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '0');
                        setInterval(function() {
                            $(".datatable").dataTable().fnDraw();
                            $('.alert-success').hide();
                        }, 1200);
                        Swal.fire(
                            'Submitted!',
                            'Your record has been submitted.',
                            'success'
                        );
                    }
                },
                error: function(response) {
                    $('#codeError').text(response.responseJSON.errors.code);
                    $('.alert-danger').html('An error in your input fields');
                    $.each(response.errors, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>' + value +
                            '</li></strong>');
                    });
                }
            });
        });

        $('body').on('click', '.showModalPhoto', function(e) {
            e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();

            src = $(this).find('img').attr('src');
            $('#dataPhotoElement').html(`<div class="row">
                                        <div class="col-md-4">
                                           <img src="${src}" style="height:500px;width:465px;margin-bottom:10px;top:0;right:0;"/>
                                        </div>
                                     </div>`);
            $('#modelHeading').html("Show Photo");
            $('#ajaxModelForPhoto').modal('show'); //show modal

        });

        $(document).on('click', '.close-forEdit', function() {
            var imgId = jQuery(this).attr("id");

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
                        url: "product/" + id + "/delete-image",
                        type: "DELETE",
                        data: {
                            closeForEdit: $('#' + imgId).val()
                        },
                        error: function() {
                            alert('Something is wrong');
                        },
                        success: function(data) {
                            table.draw();
                            $('.datatable').DataTable().ajax.reload();
                            $('#ajaxModelForCreate').removeData();
                            $("#photoForEdit").fileinput('clear');
                            $('#photoForEdit').fileinput('refresh');
                            // Prevent fileinput in create modal in order from being affected of edit modal
                            $('#images').fileinput('destroy');
                            setInterval(function() { // remove cache image in index table
                                $(".datatable").dataTable().fnDraw();
                            }, 2000);
                            Swal.fire(
                                'Deleted!',
                                'Your record has been deleted.',
                                'success'
                            )
                        }
                    });

                    var input = $("#photoForEdit");
                    input.replaceWith(input.val('').clone(true));
                    $(this).parent('div.array-images-forEdit').fadeOut();

                } else {
                    Swal.fire("Cancelled", "Your data is safe :)", "error");
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
                        beforeSend: function() {
                            swal.fire({
                                html: '<h5>Loading...</h5>',
                                showConfirmButton: false,
                                onRender: function() {
                                    $('.swal2-content').prepend(
                                        sweet_loader);
                                }
                            });
                        },
                        error: function() {
                            alert('Something is wrong');
                        },
                        success: function(data) {
                            // no reload page
                            table.draw();
                            setInterval(function() { // remove cache image in index table
                                $(".datatable").dataTable().fnDraw();
                            }, 2000);
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

        // trigger bootstrap file input for create in order to function normally
        imgInputForCreate();

    }); // END 

</script>
@endsection
