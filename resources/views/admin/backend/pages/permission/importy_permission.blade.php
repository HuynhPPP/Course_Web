@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <a href="{{ route('export') }}" class="btn btn-warning">Download Xlsx</a>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Import Permission</h5>
                    <form id="AddSubCategoryForm" action="{{ route('import') }}" method="post" class="row g-3"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group col-md-6">
                            <label for="input1" class="form-label">Xlsx File Import</label>
                            <input type="file" class="form-control" name="import_file">
                        </div>


                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-4">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#AddSubCategoryForm').validate({
                rules: {
                    subcategory_name: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },

                },
                messages: {
                    subcategory_name: {
                        required: 'Please Enter SubCategory Name',
                    },
                    category_id: {
                        required: 'Please Select Category Name',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
