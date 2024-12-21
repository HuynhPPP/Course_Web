<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal;
use App\Models\CourseSection;
use App\Models\CourseLecture;
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

    public function EditCourse($id)
    {
        $course = Course::find($id);
        $goals = Course_goal::where('course_id',$id)->get();
        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        return view('instructor.courses.edit_course',
        compact('course','categories','subcategory','goals'));
    }

    public function UpdateCourse(Request $request)
    {
        $course_id = $request->course_id;

        Course::find($course_id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'instructor_id' => Auth::user()->id,
            'course_title' => $request->course_title,
            'course_name' => $request->course_name,
            'course_name_slug' => strtolower(str_replace(' ', '-', $request->course_name)),
            'description' => $request->description,
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
        ]);

        $notification = array(
            'message' => 'Course Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.course')->with($notification);
       
    }

    public function UpdateCourseImage(Request $request)
    {
        $course_id = $request->id;
        $old_image = $request->old_image;

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

        if (file_exists($old_image)) {
            unlink($old_image);
        }

        Course::find($course_id)->update([
            'course_image' => $save_img,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Course Image Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function UpdateCourseVideo(Request $request)
    {
        $course_id = $request->video_id;
        $old_video = $request->old_video;

        $video = $request->file('video');

        // Tạo tên file duy nhất
        $videoName = time().'.'.$video->getClientOriginalExtension();
        $video->move(public_path('upload/course/video/'),$videoName);
        $save_video = 'upload/course/video/'.$videoName;

        if (file_exists($old_video)) {
            unlink($old_video);
        }

        Course::find($course_id)->update([
            'video' => $save_video,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Course Video Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function UpdateCourseGoal(Request $request)
    {
        $course_id = $request->id;

        if ($request->course_goals == NULL) {
            return redirect()->back();
        } else {
            Course_goal::where('course_id', $course_id)->delete();

            $goals = Count($request->course_goals);

            for ($i=0; $i < $goals; $i++) { 
                $goal_count = new Course_goal();
                $goal_count->course_id = $course_id;
                $goal_count->goal_name = $request->course_goals[$i];
                $goal_count->save();
            }
        }

        $notification = array(
            'message' => 'Course Goals Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function DeleteCourse($id)
    {
        $course = Course::find($id);
        unlink($course->course_image);
        unlink($course->video);

        Course::find($id)->delete();

        $goalsData = Course_goal::where('course_id',$id)->get();
        foreach ($goalsData as $item) {
            $item->goal_name;
            Course_goal::where('course_id',$id)->delete();
        }

        $notification = array(
            'message' => 'Course Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function AddCourseLecture($id)
    {
        $course = Course::find($id);

        $section = CourseSection::where('course_id',$id)->latest()->get();

        return view('instructor.courses.section.add_course_lecture',
        compact('course','section'));
    }

    public function AddCourseSection(Request $request)
    {
        $course_id = $request->id;

        CourseSection::insert([
            'course_id' => $course_id,
            'section_title' => $request->section_title,
        ]);

        $notification = array(
            'message' => 'Course Section Added Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function SaveLecture(Request $request)
    {
        $lecture = new CourseLecture();
        $lecture->course_id = $request->course_id;
        $lecture->section_id = $request->section_id;
        $lecture->lecture_title = $request->lecture_title;
        $lecture->url = $request->lecture_url;
        $lecture->content = $request->content;
        $lecture->save();

        return response()->json(['success' => 'Lecture Saved Successfully']);

    }

    public function EditLecture($id)
    {
        $course_lecture = CourseLecture::find($id);
        return view('instructor.courses.lecture.edit_course_lecture',compact('course_lecture'));

    }

    public function UpdateCourseLecture(Request $request)
    {
        $lecture_id = $request->id;

        CourseLecture::find($lecture_id)->update([
            'lecture_title' => $request->lecture_title,
            'url' => $request->url,
            'content' => $request->content,

        ]);

        $notification = array(
            'message' => 'Course Lecture Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function DeleteLecture($id)
    {
        CourseLecture::find($id)->delete();

        $notification = array(
            'message' => 'Course Lecture Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function DeleteSection($id)
    {
        $lectures = CourseLecture::where('section_id', $id);
        if ($lectures->exists()) {
            $lectures->delete();
        }
        
        $section = CourseSection::find($id);
        if ($section) {
            $section->delete();

            $notification = array(
                'message' => 'Section and related lectures deleted successfully',
                'alert-type' => 'success',
            );
        } else {
            $notification = array(
                'message' => 'Section not found',
                'alert-type' => 'error',
            );
        }

        return redirect()->back()->with($notification);
        }
}
