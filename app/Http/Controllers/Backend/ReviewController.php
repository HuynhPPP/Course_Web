<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseLecture;
use App\Models\Review;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function StoreReview(Request $request)
    {
        $course = $request->course_id;
        $instructor = $request->instructor_id;

        $request->validate([
            'comment' => 'required',
        ]);

        Review::insert([
            'course_id' => $course,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->rate,
            'instructor_id' => $instructor,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Review will Approve By Admin successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);

    }

    public function AdminPendingReview()
    {
        $review = Review::where('status',0)->orderBy('id','DESC')->get();

        return view('admin.backend.review.pending_review',compact('review'));
    }

    public function UpdateReviewStatus(Request $request)
    {
        $reviewId = $request->input('review_Id');
        $isChecked = $request->input('is_checked',0);

        $user = Review::find($reviewId);
            if ($user) {
            $user->status = $isChecked;
            $user->save();
        }
        return response()->json(['message' => 'Review Status Updated Successfully']);
    }

    public function AdminActiveReview()
    {
        $review = Review::where('status',1)->orderBy('id','DESC')->get();

        return view('admin.backend.review.active_review',compact('review'));
    }

    public function InstructorAllReview()
    {
        $id = Auth::user()->id;
        $review = Review::where('instructor_id',$id)
                        ->where('status',1)
                        ->orderBy('id','DESC')
                        ->get();

        return view('instructor.review.all_review',compact('review'));               
    }
}
