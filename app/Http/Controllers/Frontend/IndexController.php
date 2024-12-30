<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;



class IndexController extends Controller
{
    public function CourseDetails($id, $slug)
    {
        $course = Course::find($id);
        $goals = Course_goal::where('course_id',$id)->orderBy('id','DESC')->get();
        $instructor_id = $course->instructor_id;

        $instructorCourses = Course::where('instructor_id',$instructor_id)
                                    ->orderBy('id','DESC')->get();

        $categories = Category::latest()->get();
        $category_id = $course->category_id;
        $relatedCourses = Course::where('category_id',$category_id)
                                ->where('id','!=',$id)
                                ->orderBy('id','DESC')
                                ->limit(3)
                                ->get();
        
        return view('frontend.course.course_details',
        compact('course','goals','instructorCourses','categories','relatedCourses'));
    }

    public function CategoryCourse($id, $slug)
    {
        $courses = Course::where('category_id',$id)->where('status','1')->get();
        $category = Category::where('id',$id)->first();
        $categories = Category::latest()->get();

        return view('frontend.category.category_all',
        compact('courses','category','categories'));
    }
}
