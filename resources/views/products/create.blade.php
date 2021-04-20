@extends("layouts.app")

@section('title') Create New User @endsection

@section('list-admin-create')
    {{ Breadcrumbs::render('list-user-create') }}
@endsection

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card card-secondary">
        <div class="card-header">
            <h3 class="card-title">Create New Jobs</h3>
        </div>
        <div class="card-body">
            <!-- enctype="multipart/form-data" karena kita akan mengunggah (mengupload) file dari form -->
            <form action="{{ route('products.store') }}" method="POST" id="formKirim" files="true"
                enctype="multipart/form-data">
                @csrf
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
                    <div class="col-sm-12 text-right" style="margin-top:10px;">
                        <input class="btn btn-primary" type="submit" id="button" value="Save" />
                    </div>
                </div>
            </form>
            <!--</form>-->
        </div> <!-- card body -->
        <div class="card-footer">
            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about the
            plugin.
        </div>
    </div>
@endsection
@section('crud-js')
    <!--terkait dengan kode@yield('crud-js') di app.blade.php-->
    <script>
        $('.alert-success').fadeIn().delay(700).fadeOut();

    </script>
@endsection
@section('footer-scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <script>
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

    </script>
@endsection
