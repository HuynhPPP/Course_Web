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
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id)
    {
        $course = Course::find($id);

        // Check if the course already in the cart
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($id){
            return $cartItem->id == $id;
        });

        if ($cartItem->isNotEmpty()) {
            return response()->json(['error' => 'Course is already in your cart']);
        }

        if ($course->discount_price == null) {
            Cart::add([
                'id' => $id, 
                'name' => $request->course_name, 
                'qty' => 1, 
                'price' => $course->selling_price, 
                'weight' => 1, 
                'options' => [
                    'image' => $course->course_image,
                    'slug' => $request->course_name_slug,
                    'instructor' => $request->instructor,
                    ]
            ]);
        } else {
            Cart::add([
                'id' => $id, 
                'name' => $request->course_name, 
                'qty' => 1, 
                'price' => $course->discount_price, 
                'weight' => 1, 
                'options' => [
                    'image' => $course->course_image,
                    'slug' => $request->course_name_slug,
                    'instructor' => $request->instructor,
                    ]
            ]);
        }
        return response()->json(['success' => 'Successfully Added on Your Cart']);
    }

    public function CartData()
    {
        $carts = Cart::content();
        $cartTotal = Cart::total();
        $cartQty = Cart::count();

        return response()->json(array(
            'carts' => $carts,
            'cartTotal' => $cartTotal,
            'cartQty' => $cartQty,
        ));
    }

    public function AddMiniCart()
    {
        $carts = Cart::content();
        $cartTotal = Cart::total();
        $cartQty = Cart::count();

        return response()->json(array(
            'carts' => $carts,
            'cartTotal' => $cartTotal,
            'cartQty' => $cartQty,
        ));
    }

    public function RemoveMiniCart($rowId)
    {
        Cart::remove($rowId);
        return response()->json(['success' => 'Course Removed From Cart']);
    }

    public function MyCart()
    {
        return view('frontend.mycart.view_mycart');
    }

    public function GetCartCourse()
    {
        $carts = Cart::content();
        $cartTotal = Cart::total();
        $cartQty = Cart::count();

        return response()->json(array(
            'carts' => $carts,
            'cartTotal' => $cartTotal,
            'cartQty' => $cartQty,
        ));
    }

    public function CartRemove($rowId)
    {
        Cart::remove($rowId);
        return response()->json(['success' => 'Course Removed From Cart']);
    }
}