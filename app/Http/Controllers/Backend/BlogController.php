<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController extends Controller
{
    public function AllBlogCategory()
    {
        $category = BlogCategory::latest()->get();

        return view('admin.backend.blogCategory.blog_category',compact('category'));
    }

    public function StoreBlogCategory(Request $request)
    {
        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower((str_replace(' ','-',$request->category_name))),
        ]);

        $notification = array(
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function EditBlogCategory($id)
    {
        $categories = BlogCategory::find($id);

        return response()->json($categories);
    }

    public function UpdateBlogCategory(Request $request)
    {
        $cat_id = $request->cat_id;

        BlogCategory::find($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower((str_replace(' ','-',$request->category_name))),
        ]);

        $notification = array(
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function DeleteBlogCategory($id)
    {
        BlogCategory::find($id)->delete();

        $notification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    ///// All Blog Post Method /////
    public function BlogPost()
    {
       $post = BlogPost::latest()->get();

       return view('admin.backend.post.all_post',compact('post'));
    }

    public function AddBlogPost()
    {
        $blog_cat = BlogCategory::latest()->get();

        return view('admin.backend.post.add_post',compact('blog_cat'));
    }

    public function StoreBlogPost(Request $request)
    {
        $image = $request->file('post_image');

        // Tạo tên file duy nhất
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $save_path = public_path('upload/post/');
        $save_url = 'upload/post/'.$name_generate;

        $manager = new ImageManager(Driver::class);

        // Xử lý ảnh
        $manager->read($image->getPathname())
                ->resize(370, 247)
                ->save($save_path.$name_generate);
        
        BlogPost::insert ([
            'blogCategory_id' => $request->blogCategory_id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
            'long_descreption' => $request->long_descreption,
            'post_tags' => $request->post_tags,
            'post_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Blog Post Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('blog.post')->with($notification);
    }

    public function EditPost($id)
    {
        $blog_cat = BlogCategory::latest()->get();
        $post = BlogPost::find($id);

        return view('admin.backend.post.edit_post',compact('post','blog_cat'));
    }

    public function UpdateBlogPost(Request $request)
    {
        $post_id = $request->id;

        if ($request->file('post_image')) {
            $image = $request->file('post_image');

            // Tạo tên file duy nhất
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $save_path = public_path('upload/post/');
            $save_url = 'upload/post/'.$name_generate;

            $manager = new ImageManager(Driver::class);

            // Xử lý ảnh
            $manager->read($image->getPathname())
                    ->resize(370, 247)
                    ->save($save_path.$name_generate);
            
            BlogPost::find($post_id)->update([
                'blogCategory_id' => $request->blogCategory_id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                'long_descreption' => $request->long_descreption,
                'post_tags' => $request->post_tags,
                'post_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Blog Post Updated Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('blog.post')->with($notification);
        } else {
            BlogPost::find($post_id)->update([
                'blogCategory_id' => $request->blogCategory_id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)),
                'long_descreption' => $request->long_descreption,
                'post_tags' => $request->post_tags,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Blog Post Updated Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('blog.post')->with($notification);
        }
    }

    public function DeletePost($id) 
    {
        $item = BlogPost::find($id);
        $img = $item->post_image;
        unlink($img);

        BlogPost::find($id)->delete();
        
        // $notification = array(
        //     'message' => 'Blog Post Deleted Successfully',
        //     'alert-type' => 'success'
        // );
        return redirect()->back();
    }

    public function BlogDetails($slug)
    {
        $blog = BlogPost::where('post_slug',$slug)->first();
        $tag = $blog->post_tags;
        $tags_all = explode(',',$tag);
        $blog_category = BlogCategory::latest()->get();
        $post = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_details',compact('blog',
            'tags_all','blog_category','post'));
    }

    public function BlogCategoryLists($id)
    {
        $blog = BlogPost::where('blogCategory_id',$id)->get();
        $blog_category = BlogCategory::latest()->get();
        $breadcum_category = BlogCategory::where('id',$id)->first();
        $post = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_cat_list',
        compact('blog','breadcum_category','blog_category','post'));
    }

    public function BlogLists()
    {
        $blog = BlogPost::latest()->paginate(2);
        $blog_category = BlogCategory::latest()->get();
        $post = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_list',
        compact('blog','blog_category','post'));
    }
}
