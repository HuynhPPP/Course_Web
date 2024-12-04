<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function AllCategory() 
    {
        $category = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('category'));
    }

    public function AddCategory() 
    {
        $category = Category::latest()->get();
        return view('admin.backend.category.add_category', compact('category'));
    }

    public function StoreCategory(Request $request) 
    {
        $image = $request->file('image');

        // Tạo tên file duy nhất
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $save_path = public_path('upload/category/');
        $save_url = 'upload/category/'.$name_generate;

        $manager = new ImageManager(Driver::class);

        // Xử lý ảnh
        $manager->read($image->getPathname())
                ->resize(370, 246)
                ->save($save_path.$name_generate);
        
        Category::insert ([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.category')->with($notification);
    }
}
