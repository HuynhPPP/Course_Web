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
                        <li class="breadcrumb-item active" aria-current="page">Add Admin</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Add Admin</h5>
                    <form id="AddSubCategoryForm" action="{{ route('store.admin') }}" method="post" class="row g-3"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group col-md-6">
                            <label for="input1" class="form-label">Admin User Name</label>
                            <input type="text" class="form-control" name="username">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="input1" class="form-label">Admin Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="input1" class="form-label">Admin Email</label>
                            <input type="text" class="form-control" name="email">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="input1" class="form-label">Admin Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="input1" class="form-label">Admin Address</label>
                            <input type="text" class="form-control" name="address">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="input1" class="form-label">Admin Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="input1" class="form-label">Role Name</label>
                            <select name="roles" class="form-select mb-3" aria-label="Default select example">
                                <option selected="" disabled>Open this select menu</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option> 
                                @endforeach   
                            </select>
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

@endsection
