@extends('instructor.instructor_dashboard')
@section('instructor')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Course</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Edit Course</h5>
                <form id="myForm" action="{{ route('update.course') }}" method="post" class="row g-3" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="course_id" value="{{ $course->id }}">

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Course Name</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="course_name"
                            value="{{ $course->course_name }}"
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Course Title</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="course_title"
                            value="{{ $course->course_title }}"
                        >
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Course Category</label>
                        <select name="category_id" class="form-select mb-3" aria-label="Default select example">
                            <option selected="" disabled>Open this select menu</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}" 
                                        {{ $item->id == $course->category_id ? 'selected' : '' }}
                                >
                                    {{ $item->category_name }}
                                </option>
                            @endforeach           
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Course Subcategory</label>
                        <select name="subcategory_id" class="form-select mb-3" aria-label="Default select example">
                            <option selected="" disabled>Open this select menu</option>
                            @foreach ($subcategory as $item)
                                <option value="{{ $item->id }}"
                                        {{ $item->id == $course->subcategory_id ? 'selected' : '' }}
                                >
                                    {{ $item->subcategory_name }}
                                </option>
                            @endforeach         
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Certificate Available</label>
                        <select name="certificate" class="form-select mb-3" aria-label="Default select example">
                            <option selected="" disabled>Open this select menu</option>
                                <option value="Yes" {{ $course->certificate == 'Yes' ? 'selected' : '' }}>Yes</option>         
                                <option value="No" {{ $course->certificate == 'No' ? 'selected' : '' }}>No</option>         
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="input1" class="form-label">Course Label</label>
                        <select name="label" class="form-select mb-3" aria-label="Default select example">
                            <option selected="" disabled>Open this select menu</option>
                                <option value="Beginner" {{ $course->label == 'Beginner' ? 'selected' : '' }}>Beginner</option>         
                                <option value="Medium" {{ $course->label == 'Medium' ? 'selected' : '' }}>Medium</option>         
                                <option value="Advance" {{ $course->label == 'Advance' ? 'selected' : '' }}>Advance</option>         
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="input1" class="form-label">Course Price</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="selling_price"
                            value="{{ $course->selling_price }}"
                        >
                    </div>

                    <div class="form-group col-md-3">
                        <label for="input1" class="form-label">Discount Price</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="discount_price"
                            value="{{ $course->discount_price }}"
                        >
                    </div>

                    <div class="form-group col-md-3">
                        <label for="input1" class="form-label">Duration</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="duration"
                            value="{{ $course->duration }}"
                        >
                    </div>

                    <div class="form-group col-md-3">
                        <label for="input1" class="form-label">Resources</label>
                        <input type="text" 
                            class="form-control" 
                            id="input1" 
                            name="resources"
                            value="{{ $course->resources }}"
                        >
                    </div>

                    <div class="form-group col-md-12">
                        <label for="input1" class="form-label">Course Prerequisites</label>
                        <textarea class="form-control textarea" 
                            id="input11" 
                            name="prerequisites"
                            rows="3"
                            placeholder=""
                        >
                        {{ $course->prerequisites }}
                        </textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="input1" class="form-label">Course Description</label>
                        <textarea class="form-control textarea" 
                            id="myeditorinstance" 
                            name="description"
                        >
                        {!! $course->description !!}
                        </textarea>
                    </div>
                    
                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       value="1" 
                                       name="bestseller" 
                                       id="flexCheckDefault"
                                       {{ $course->bestseller == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="flexCheckDefault">BestSeller</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       value="1" 
                                       name="featured" 
                                       id="flexCheckDefault"
                                       {{ $course->featured == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="flexCheckDefault">Featured</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       value="1" 
                                       name="highestrated" 
                                       id="flexCheckDefault"
                                       {{ $course->highestrated == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="flexCheckDefault">Highestrated</label>
                            </div>
                        </div>
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

<!--========== Start course image update ==============-->
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('update.course.image') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $course->id }}">
                <input type="hidden" name="old_image" value="{{ $course->course_image }}">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="input2" class="form-label">Course Image</label>
                        <input type="file" 
                            class="form-control" 
                            id="image"
                            name="course_image"
                        >
                    </div>

                    <div class="col-md-6">
                        <img src="{{ asset($course->course_image) }}" 
                            alt="Admin" 
                            id="showImage"
                            class="rounded-circle p-1 bg-primary" 
                            width="100"
                        >
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--========== End course image update ==============-->


<!--========== Start course video update ==============-->
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('update.course.video') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="video_id" value="{{ $course->id }}">
                <input type="hidden" name="old_video" value="{{ $course->video }}">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="input2" class="form-label">Course Intro Video</label>
                        <input type="file" 
                            class="form-control" 
                            name="video"
                            accept="video/mp4, video/webm"
                        >
                    </div>

                    <div class="col-md-6">
                        <video width="300" height="130" controls>
                            <source src="{{ asset($course->video) }}" type="video/mp4">
                        </video>
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--========== End course video update ==============-->


<!--========== Start course goals update ==============-->
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('update.course.goal') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $course->id }}">
                @foreach ($goals as $item)                   
                    <!--   //////////// Goal Option /////////////// -->
                    <div class="row add_item">
                        <div class="whole_extra_item_delete" id="whole_extra_item_delete">
                            <div class="container mt-2">
                               <div class="row">
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                                <label for="goals" class="form-label"> Goals </label>
                                                <input type="text" 
                                                    name="course_goals[]" 
                                                    id="goals" 
                                                    class="form-control" 
                                                    value="{{ $item->goal_name }}"
                                                >
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3" style="padding-top: 30px;">
                                        <a class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i> Add More..</a>
                                        <span class="btn btn-danger btn-sm removeeventmore"><i class="fa fa-minus-circle">Remove</i></span>
                                    </div>
                               </div>
                            </div>
                        </div>
                    </div> <!---end row-->
                    <!--   //////////// End Goal Option /////////////// -->
                @endforeach

                <br>
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--========== End course goals update ==============-->




<!--========== Start of add multiple class with ajax ==============-->
<div style="visibility: hidden">
    <div class="whole_extra_item_add" id="whole_extra_item_add">
       <div class="whole_extra_item_delete" id="whole_extra_item_delete">
          <div class="container mt-2">
             <div class="row">
               
                
                <div class="form-group col-md-9">
                   <label for="goals">Goals</label>
                   <input type="text" name="course_goals[]" id="goals" class="form-control" placeholder="Goals  ">
                </div>
                <div class="form-group col-md-3" style="padding-top: 20px">
                   <span class="btn btn-success btn-sm addeventmore"><i class="fa fa-plus-circle">Add</i></span>
                   <span class="btn btn-danger btn-sm removeeventmore"><i class="fa fa-minus-circle">Remove</i></span>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>      
 
  
 <!----For Section-------->
 <script type="text/javascript">
    $(document).ready(function(){
       var counter = 0;
       $(document).on("click",".addeventmore",function(){
             var whole_extra_item_add = $("#whole_extra_item_add").html();
             $(this).closest(".add_item").append(whole_extra_item_add);
             counter++;
       });
       $(document).on("click",".removeeventmore",function(event){
             $(this).closest("#whole_extra_item_delete").remove();
             counter -= 1
       });
    });
 </script>
 <!--========== End of add multiple class with ajax ==============-->

<script type="text/javascript">
        
    $(document).ready(function(){
        $('select[name="category_id"]').on('change', function(){
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: "{{ url('/subcategory/ajax') }}/"+category_id,
                    type: "GET",
                    dataType:"json",
                    success:function(data){
                        $('select[name="subcategory_id"]').html('');
                        var d =$('select[name="subcategory_id"]').empty();
                        $.each(data, function(key, value){
                            $('select[name="subcategory_id"]').append('<option value="'+ value.id + '">' + value.subcategory_name + '</option>');
                        });
                    },

                });
            } else {
                alert('danger');
            }
        });
    });

</script>

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

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                course_name: {
                    required : true,
                }, 
                course_title: {
                    required : true,
                }, 
                
            },
            messages :{
                course_name: {
                    required : 'Please Enter Course Name',
                }, 
                course_title: {
                    required : 'Please Select Course Title',
                }, 
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>
@endsection