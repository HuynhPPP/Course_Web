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
                    <li class="breadcrumb-item active" aria-current="page">Report</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-body p-4">

                <div class="row">
                    <div class="col-md-4">
                        <form id="AddCategoryForm" action="{{ route('search.by.date') }}" method="post" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="input1" class="form-label">Searh By Date</label>
                                <input type="date" 
                                    class="form-control" 
                                    name="date"
                                >
                            </div>
        
                            
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <form id="AddCategoryForm" action="{{ route('search.by.month') }}" method="post" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="input1" class="form-label">Searh By Month</label>
                                <select name="month" class="form-select" aria-label="Select Month">
                                    <option selected disabled>Choose a month</option>
                                    <option value="January">January</option>
                                    <option value="January">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                                
                            </div>

                            <div class="form-group col-md-12">
                                <label for="input1" class="form-label">Searh By Year</label>
                                <select name="year_name" class="form-select" aria-label="Default select example">
									<option selected="">Open this select menu</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
								</select>
                            </div>
        
                            
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <form id="AddCategoryForm" action="{{ route('search.by.year') }}" method="post" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="input1" class="form-label">Searh By Year</label>
                                <select name="year" class="form-select" aria-label="Default select example">
									<option selected="">Open this select menu</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
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
    </div>

</div>

@endsection