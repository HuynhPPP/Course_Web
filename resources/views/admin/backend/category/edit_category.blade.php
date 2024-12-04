@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Edit Category</h5>
                <form id="AddCategoryForm" action="{{ route('update.category') }}" method="post" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $category->id }}">

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Category Name</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="category_name"
                            placeholder="First Name"
                            value="{{ $category->category_name }}"
                        >
                    </div>

                    <div class="col-md-6">

                    </div>

                    <div class="form-group col-md-6">
                        <label for="input2" class="form-label">Category Image</label>
                        <input type="file" 
                            class="form-control" 
                            id="image"
                            name="image"
                        >
                    </div>

                    <div class="col-md-6">
                        <img src="{{ asset($category->image) }}" 
                             alt="Admin" 
                             id="showImage"
                             class="rounded-circle p-1 bg-primary" 
                             width="80"
                        >
                    </div>
                    
                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection