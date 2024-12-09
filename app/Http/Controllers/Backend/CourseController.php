<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CourseController extends Controller
{
    public function AllCourse()
    {
        $id = Auth::user()->id;
        $courses = Course::where('instructor_id',$id)->orderBy('id','desc')->get();
        return view('instructor.courses.all_course',compact('courses'));
    }

    public function AddCourse()
    {
        $categories = Category::latest()->get();
        return view('instructor.courses.add_course', compact('categories'));
    }

    public function GetSubcategory($category_id)
    {
        $subcategory = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();
        return json_encode($subcategory);
    }

    public function StoreCourse(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4|max:10000',
        ]);

        $image = $request->file('course_image');

        // Tạo tên file duy nhất
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $save_path = public_path('upload/course/thambnail/');
        $save_img = 'upload/course/thambnail/'.$name_generate;

        $manager = new ImageManager(Driver::class);

        // Xử lý ảnh
        $manager->read($image->getPathname())
                ->resize(370, 246)
                ->save($save_path.$name_generate);

        $video = $request->file('video');

        // Tạo tên file duy nhất
        $videoName = time().'.'.$video->getClientOriginalExtension();
        $video->move(public_path('upload/course/video/'),$videoName);
        $save_video = 'upload/course/video/'.$videoName;

        $course_id = Course::insertGetId([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'instructor_id' => Auth::user()->id,
            'course_image' => $save_img,
            'course_title' => $request->course_title,
            'course_name' => $request->course_name,
            'course_name_slug' => strtolower(str_replace(' ', '-', $request->course_name)),
            'description' => $request->description,
            'video' => $save_video,
            'label' => $request->label,
            'duration' => $request->duration,
            'resources' => $request->resources,
            'certificate' => $request->certificate,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'prerequisites' => $request->prerequisites,
            'bestseller' => $request->bestseller,
            'featured' => $request->featured,
            'highestrated' => $request->highestrated,
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);

        // Course Goals Add Form
        $goals = Count($request->course_goals);
        if ($goals != NULL) {
            for ($i=0; $i < $goals; $i++) { 
                $goal_count = new Course_goal();
                $goal_count->course_id = $course_id;
                $goal_count->goal_name = $request->course_goals[$i];
                $goal_count->save();
            }
        }
        // End Course Goals Add Form

        $notification = array(
            'message' => 'Course Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.course')->with($notification);
       
    }
}
