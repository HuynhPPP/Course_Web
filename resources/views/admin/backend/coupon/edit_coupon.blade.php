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
                    <li class="breadcrumb-item active" aria-current="page">Edit Coupon</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Edit Coupon</h5>
                <form id="AddCategoryForm" action="{{ route('admin.update.coupon') }}" method="post" class="row g-3" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $coupons->id }}">

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Coupon Name</label>
                        <input type="text" 
                            class="form-control" 
                            name="coupon_name"
                            value="{{ $coupons->coupon_name }}"
                        >
                    </div>


                    <div class="form-group col-md-6">
                        <label for="input2" class="form-label">Coupon Discount</label>
                        <input type="text" 
                            class="form-control" 
                            name="coupon_discount"
                            value="{{ $coupons->coupon_discount }}"
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input2" class="form-label">Coupon Validity Date</label>
                        <input type="date" 
                            class="form-control" 
                            name="coupon_validity"
                            min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                            value="{{ $coupons->coupon_validity }}"
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