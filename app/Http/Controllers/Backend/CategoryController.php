<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
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

    public function EditCategory($id)
    {
        $category = Category::find($id);
        return view('admin.backend.category.edit_category', compact('category'));
    }

    public function UpdateCategory(Request $request)
    {
        $category_id = $request->id;

        if ($request->file('image')) {
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
            
            Category::find($category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Category updated with image successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('all.category')->with($notification);
        } else {
            Category::find($category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),
            ]);

            $notification = array(
                'message' => 'Category updated without image successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('all.category')->with($notification);
        }
    }

    public function DeleteCategory($id) 
    {
        $item = Category::find($id);
        $img = $item->image;
        unlink($img);

        Category::find($id)->delete();
        
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    ////// All SubCategory Methods //////

    public function AllSubCategory()
    {
        $subcategory = SubCategory::latest()->get();
        return view('admin.backend.subcategory.all_subcategory', compact('subcategory'));
    }

    public function AddSubCategory() 
    {
        $category = Category::latest()->get();
        return view('admin.backend.subcategory.add_subcategory', compact('category'));
    }

    public function StoreSubCategory(Request $request) 
    {
        SubCategory::insert ([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ','-',$request->subcategory_name)),
        ]);

        $notification = array(
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.subcategory')->with($notification);
    }

    public function EditSubCategory($id)
    {
        $category = Category::latest()->get();
        $subcategory = SubCategory::find($id);
        return view('admin.backend.subcategory.edit_subcategory', 
        compact('category',
                     'subcategory'));
    }

    public function UpdateSubCategory(Request $request) 
    {
        $subcategory_id = $request->id;
        SubCategory::find($subcategory_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ','-',$request->subcategory_name)),
        ]);

        $notification = array(
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.subcategory')->with($notification);
    }

    public function DeleteSubCategory($id)
    {
        SubCategory::find($id)->delete();
        
        $notification = array(
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
