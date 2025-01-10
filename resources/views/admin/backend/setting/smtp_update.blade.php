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
                    <li class="breadcrumb-item active" aria-current="page">Smtp Setting</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Smtp Setting</h5>
                <form id="AddCategoryForm" action="{{ route('update.stmp') }}" method="post" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $smtp->id }}">

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Mailler</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="mailer"
                            placeholder="First Name"
                            value="{{ $smtp->mailer }}"
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Host</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="host"
                            placeholder="First Name"
                            value="{{ $smtp->host }}"
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Port</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="port"
                            placeholder="First Name"
                            value="{{ $smtp->port }}"
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Username</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="username"
                            placeholder="First Name"
                            value="{{ $smtp->username }}"
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Password</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="password"
                            placeholder="First Name"
                            value="{{ $smtp->password }}"
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Encryption</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="encryption"
                            placeholder="First Name"
                            value="{{ $smtp->encryption }}"
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">From_address</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="from_address"
                            placeholder="First Name"
                            value="{{ $smtp->from_address }}"
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


@endsection