<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Coupon;
use App\Models\Course;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function AdminAllCoupon()
    {
        $coupons = Coupon::latest()->get();

        return view('admin.backend.coupon.all_coupon',compact('coupons'));
    }

    public function AdminAddCoupon()
    {
        return view('admin.backend.coupon.add_coupon');
    }

    public function AdminStoreCoupon(Request $request)
    {
        Coupon::insert([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Coupon Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.all.coupon')->with($notification);
    }

    public function AdminEditCoupon($id)
    {
        $coupons = Coupon::find($id);

        return view('admin.backend.coupon.edit_coupon',compact('coupons'));
    }

    public function AdminUpdateCoupon(Request $request)
    {
        $coupon_id = $request->id;

        Coupon::find($coupon_id)->update([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Coupon Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.all.coupon')->with($notification);
    }

    public function AdminDeleteCoupon($id)
    {
        Coupon::find($id)->delete();

        $notification = array(
            'message' => 'Coupon Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.all.coupon')->with($notification);
    }

    ////// Instructor All Coupon //////

    public function InstructorAllCoupon()
    {
        $id = Auth::user()->id;
        $coupons = Coupon::where('instructor_id',$id)->latest()->get();

        return view('instructor.coupon.coupon_all',compact('coupons'));
    }

    public function InstructorAddCoupon()
    {
        $id = Auth::user()->id;
        $courses = Course::where('instructor_id',$id)->get();

        return view('instructor.coupon.coupon_add',compact('courses'));
    }

    public function InstructorStoreCoupon(Request $request)
    {
        Coupon::insert([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'instructor_id' => Auth::user()->id,
            'course_id' => $request->course_id,
            'created_at' => Carbon::now(),
        ]); 

        $notification = array(
            'message' => 'Coupon Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('instructor.all.coupon')->with($notification);
    }

    public function InstructorEditCoupon($id)
    {
        $coupon = Coupon::find($id);
        $instructor_id = Auth::user()->id;
        $courses = Course::where('instructor_id',$instructor_id)->get();

        return view('instructor.coupon.coupon_edit',compact('coupon','courses'));
    }

    public function InstructorUpdateCoupon(Request $request)
    {
        $coupon_id = $request->coupon_id;

        Coupon::find($coupon_id)->update([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'instructor_id' => Auth::user()->id,
            'course_id' => $request->course_id,
            'created_at' => Carbon::now(),
        ]); 

        $notification = array(
            'message' => 'Coupon Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('instructor.all.coupon')->with($notification);
    }

    public function InstructorDeleteCoupon($id)
    {
        Coupon::find($id)->delete();

        $notification = array(
            'message' => 'Coupon Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
}
