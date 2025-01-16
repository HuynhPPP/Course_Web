<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Course;
use App\Models\Course_goal;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Question;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\OrderConfirm;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function AdminPendingOrder()
    {
        $payments = Payment::where('status','pending')->orderBy('id','DESC')->get();

        return view('admin.backend.orders.pending_orders',compact('payments'));
    }

    public function AdminOrderDetails($payment_id)
    {
        $payment = Payment::where('id',$payment_id)->first();
        $orderItem = Order::where('payment_id',$payment_id)->orderBy('id','DESC')->get();

        return view('admin.backend.orders.order_details',compact('payment','orderItem'));
    }

    public function PendingToConfirm($payment_id)
    {
        Payment::find($payment_id)->update(['status' => 'confirm']);

        $notification = array(
            'message' => 'Order Confirm Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('admin.confirm.order')->with($notification);
    }

    public function AdminConfirmOrder()
    {
        $payments = Payment::where('status','confirm')->orderBy('id','DESC')->get();

        return view('admin.backend.orders.confirm_orders',compact('payments'));
    }

    public function InstructorAllOrder()
    {
        $id = Auth::user()->id;
        $latestOrderItem = Order::where('instructor_id',$id)
                                ->select('payment_id',\DB::raw('MAX(id) as max_id'))
                                ->groupBy('payment_id');
        $orderItem = Order::joinSub($latestOrderItem,'latest_order',
                            function($join) {
                                $join->on('orders.id', '=', 'latest_order.max_id');})
                            ->orderBy('latest_order.max_id', 'DESC')->get();

        return view('instructor.orders.all_orders',compact('orderItem'));
    }

    public function InstructorOrderDetails($payment_id)
    {
        $payment = Payment::where('id',$payment_id)->first();
        $orderItem = Order::where('payment_id',$payment_id)->orderBy('id','DESC')->get();

        return view('instructor.orders.order_details',compact('payment','orderItem'));
    }

    public function InstructorOrderInvoice($payment_id)
    {
        $payment = Payment::where('id',$payment_id)->first();
        $orderItem = Order::where('payment_id',$payment_id)->orderBy('id','DESC')->get();

        $pdf = Pdf::loadView('instructor.orders.order_pdf', 
        compact('payment','orderItem'))
              ->setPaper('a4')
              ->setOption([
                'temDir' => public_path(),
                'chroot' => public_path(),
            ]);
        return $pdf->download('invoice.pdf');
    }

    public function MyCourse()
    {
        $id = Auth::user()->id;
        $latestOrder = Order::where('user_id',$id)
                                ->select('course_id',\DB::raw('MAX(id) as max_id'))
                                ->groupBy('course_id');
        $myCourse = Order::joinSub($latestOrder,'latest_order',
                            function($join) {
                                $join->on('orders.id', '=', 'latest_order.max_id');})
                            ->orderBy('latest_order.max_id', 'DESC')->get();

        return view('frontend.myCourse.my_all_course',compact('myCourse'));
    }

    public function CourseView($course_id){
        $id = Auth::user()->id;

        $course = Order::where('course_id',$course_id)->where('user_id',$id)->first();
        $section = CourseSection::where('course_id',$course_id)->orderBy('id','asc')->get();

        $all_question = Question::latest()->where('parent_id',null)->get();
        $all_question_answer = Question::latest()->get();

        return view('frontend.myCourse.course_view',
        compact('course','section','all_question','all_question_answer'));


    }
}
