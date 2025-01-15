@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Order Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                            <div class="card-body">
                                <h5 class="d-flex align-items-center mb-4">Payment Details</h5>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $payment->name }}
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $payment->email }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $payment->phone }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $payment->address }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Payment Type</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $payment->payment_type }}
                                    </div>
                                </div>

                            </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Total Amount</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        ${{ $payment->total_amount }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Invoice Number</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $payment->invoice_no }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Order Date</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $payment->order_date }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Status</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @if ($payment->status == 'pending')
                                            <a href="{{ route('pending-confirm',$payment->id) }}" 
                                               class="btn btn-block btn-success" 
                                               id="confirm"
                                            >Pending Order</a>
                                        @elseif ($payment->status == 'confirm')
                                            <a href="" class="btn btn-block btn-success">Confirm Order</a>  
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card radius-10 mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr style="font-weight: 600;">
                                            <td class="col-md-1">
                                                <label for="">Image</label>
                                            </td>
                                            <td class="col-md-2">
                                                <label for="">Course Name</label>
                                            </td>
                                            <td class="col-md-2">
                                                <label for="">Category</label>
                                            </td>
                                            <td class="col-md-2">
                                                <label for="">Instructor</label>
                                            </td>
                                            <td class="col-md-2">
                                                <label for="">Price</label>
                                            </td>
                                        </tr>

                                        @php
                                            $total_price = 0;   
                                        @endphp

                                        @foreach ($orderItem as $item)
                                        <tr>
                                            <td class="col-md-1">
                                                <label>
                                                    <img src="{{ asset($item->course->course_image) }}" 
                                                         alt="" 
                                                         style="width:50px; height:50px">
                                                </label>
                                            </td>

                                            <td class="col-md-2">
                                                <label>
                                                    {{ $item->course->course_name }}
                                                </label>
                                            </td>

                                            <td class="col-md-2">
                                                <label>
                                                    {{ $item->course->category->category_name }}
                                                </label>
                                            </td>

                                            <td class="col-md-2">
                                                <label>
                                                    {{ $item->instructor->name }}
                                                </label>
                                            </td>

                                            <td class="col-md-2">
                                                <label>
                                                    ${{ $item->price }}
                                                </label>
                                            </td>
                                        </tr>

                                        @php
                                            $total_price += $item->price;
                                        @endphp

                                        @endforeach

                                        <tr>
                                            <td colspan="4"></td>
                                            <td class="col-md-3">
                                                <strong>Total Price: ${{ $total_price }}</strong>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection