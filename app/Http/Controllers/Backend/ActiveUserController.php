<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ActiveUserController extends Controller
{
    public function AllUser()
    {
        $users = User::where('role','user')->latest()->get();

        return view('admin.backend.user.all_user',compact('users'));
    }

    public function AllInstructor()
    {
        $users = User::where('role','instructor')->latest()->get();

        return view('admin.backend.user.all_instructor',compact('users'));
    }

    public function UpdateUserStatus(Request $request)
    {
        $userId = $request->input('user_id');
        $isChecked = $request->input('is_checked',0);

        $user = User::find($userId);
            if ($user) {
            $user->status = $isChecked;
            $user->save();
        }
        return response()->json(['message' => 'User Status Updated Successfully']);
    }
}
