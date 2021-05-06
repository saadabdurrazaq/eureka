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
                    <li><a class="menu {{ request()->is('categories*') ? 'current' : '' }}"
                            href="{{ route('categories.index') }}">All ({{ $count }})</a></li>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-md-6 text-right">
            <a class="btn btn-success" href="javascript:void(0)" style="margin-top:25px;" id="createNewCategory"> Create
                New
                Category</a>
        </div>
    </div>
    <hr>
    <div class="panel-body table-responsive" style="overflow:hidden;">
        <table class="table table-bordered table-hover data-table dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
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
                    <strong>Success!</strong>Category was added successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="dataCategoryElementForCreate" name="dataCategoryElementForCreate" class="form-horizontal">
                    <input type="hidden" name="category_idForCreate" id="category_idForCreate">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name">Name (for create category)</label>
                            <input value="{{ old('name') }}"
                                class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                                placeholder="Full Name" type="text" name="name" id="name" />
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            <small class="text-muted">End with a comma for single or multiple inputs. E.g: data1,
                                data2,</a></small>
                            <br>
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
                    <strong>Success!</strong>Category was updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="dataCategoryElement" name="dataCategoryElement" class="form-horizontal">
                    <input type="hidden" name="category_id" id="category_id">
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
    $('#name').tokenfield({
        showAutocompleteOnFocus: false
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
            fixedColumns: true,
            "lengthMenu": [50, 100, 500, 1000, 2000, 5000, 10000, 50000, 100000],
            "sPaginationType": "full_numbers",
            "oLanguage": {
                "oPaginate": {
                    "sFirst": "«", // This is the link to the first page
                    "sPrevious": "❮", // This is the link to the previous page
                    "sNext": "❯", // This is the link to the next page
                    "sLast": "»" // This is the link to the last page
                }
            },
            ajax: "{{ route('categories.index') }}",
            dom: '<l<"toolbar">f>rtip',
            initComplete: function() {
                $("div.toolbar").html(
                    '<div style="float:left;margin-left:4px;"><select class="form-control select2bs4 trash_all" style="width:140px;height:32px;margin-left:10px;" data-select2-id="17" tabindex="-1" aria-hidden="true"><option selected="selected" data-select2-id="19">Bulk Actions</option><option data-select2-id="38" value="trashAll">Trash</option></select></div><div style="float:left;margin-left:20px;"><select onchange="window.location = this.options[this.selectedIndex].value" class="form-control select2bs4 download-doc" style="width:140px;height:32px;margin-left:10px;padding-bottom:5px"" data-select2-id="17" tabindex="-1" aria-hidden="true"><option selected="selected" data-select2-id="19" value="{{ route('categories.index') }}">Download</option><option data-select2-id="38" value="{{ route('categories.pdf') }}">PDF</option><option data-select2-id="39" value="{{ route('categories.excel') }}">XLS</option><option data-select2-id="39" value="{{ route('categories.word') }}">Doc</option></select></div>'
                );
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
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

        $('#createNewCategory').click(function() {
            $('#saveBtnForCreate').val("create-product");
            $('#category_idForCreate').val('');
            $('#modelHeadingForCreate').html("Create New Category");
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
            $.ajax({
                url: "{{ route('categories.store') }}",
                method: 'post',
                data: {
                    name: $('#name').val(),
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
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });

        $('body').on('click', '#editCategory', function(e) { // .editUser exist in usercontroller.php

            e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();

            id = $(this).data('id');

            $.ajax({
                url: "category/" + id + "/edit",
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#dataCategoryElement').html(data.html);
                    $('#saveBtn').val("create-product");
                    $('#category_id').val('');
                    $('#productForm').trigger("reset");
                    $('#modelHeading').html("Update Category");
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
                url: "categories/" + id,
                method: 'PUT',
                data: {
                    name: $('#nameForEdit').val(),
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
                }
            });
        });

        $('body').on('click', '.deleteCategory', function() {
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
                        url: "category/" + id + "/destroy",
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


    }); // END

</script>
@endsection
