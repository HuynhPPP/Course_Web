<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;

class AdminController extends Controller
{
    public function AdminDashboard() 
    {
        return view('admin.index');
    }

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function AdminLogin() 
    {
        return view('admin.admin_login');
    }

    public function AdminProfile() 
    {
        $id = Auth::user()->id;
        $profileDate = User::find($id);
        return view('admin.admin_profile_view',compact('profileDate'));
    }

    public function AdminProfileStore(Request $request) 
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        
        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function AdminChangePassword() 
    {
        $id = Auth::user()->id;
        $profileDate = User::find($id);

        return view('admin.admin_change_password',compact('profileDate'));
    }

    public function AdminPasswordUpdate(Request $request) 
    {
        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'new_password_confirmation' => 'same:new_password',
        ]);

        if (!Hash::check($request->old_password, auth::user()->password)) {
            $notification = array(
                'message' => 'Old Password Does not Match !',
                'alert-type' => 'error',
            );
            return back()->with($notification);
        }

        // Update The New Password
        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success',
        );
        return back()->with($notification);
    }

    public function BecomeInstructor()
    {
        return view('frontend.instructor.register_instructor');
    }

    public function InstructorRegister(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','unique:users'],           
            'password' => ['required'],           
        ]);

        User::insert([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'instructor',
            'status' => '0', 
        ]);

        $notification = array(
            'message' => 'Instructor Registed Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('instructor.login')->with($notification);
    }

    public function AdminAllCourse()
    {
        $courses = Course::latest()->get();

        return view('admin.backend.courses.all_course',compact('courses'));
    }

    public function UpdateCouseStatus(Request $request)
    {
        $courseId = $request->input('course_id');
        $isChecked = $request->input('is_checked',0);

        $course = Course::find($courseId);
            if ($course) {
            $course->status = $isChecked;
            $course->save();
        }
        return response()->json(['message' => 'Course Status Updated Successfully']);
    }

    public function AdminCourseDetails($id)
    {
        $course = Course::find($id);

        return view('admin.backend.courses.course_details',compact('course'));
    }
}
