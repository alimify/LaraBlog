<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Post;
use App\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
      return view('admin.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();

      return view('admin.post.create',compact('tags','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|max:100',
            'body' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif,bmp'
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->title);

        if(isset($image))
        {
            if(!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }
            $imageName = $slug.'-'.Carbon::now()->toDateString().'-'.uniqid().'.'.$image->getClientOriginalExtension();
            $postImage = Image::make($image)->
                         resize(1600,1099)->
                         save('tmp/file.'.$image->getClientOriginalExtension());
            Storage::disk('public')->put('post/'.$imageName,$postImage);

        } else
            {
            $imageName = 'default.png';
        }
        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->body = $request->body;
        $post->image = $imageName;
        $post->is_approved = true;
        $post->status = $request->publish ? true : false;
        $post->save();
        $post->tags()->attach($request->tags);
        $post->categories()->attach($request->categories);
        Toastr::success('Post Successfully Added','Success');
     return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        $categories = Category::all();
        $postTags = $post->tags()->allRelatedIds()->toArray();
        $postCategories = $post->categories()->allRelatedIds()->toArray();

       return view('admin.post.edit',compact('post','tags','categories','postTags','postCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $this->validate($request,[
            'title' => 'required|max:100',
            'body' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'image' => 'mimes:jpg,jpeg,png,gif,bmp'
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->title);

        if(isset($image)){
            if(!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }
            $imageName = $slug.'-'.Carbon::now()->toDateString().'-'.uniqid().'.'.$image->getClientOriginalExtension();
            $postImage = Image::make($image)->
                         resize(1600,1099)->
                         save('tmp/file.'.$image->getClientOriginalExtension());

            Storage::disk('public')->put('post/'.$imageName,$postImage);

            if(Storage::disk('public')->exists('post/'.$post->image))
            {
                Storage::disk('public')->delete('post/'.$post->image);
            }

        }else
            {
            $imageName = $post->image;
        }
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->body = $request->body;
        $post->image = $imageName;
        $post->is_approved = true;
        $post->status = $request->publish ? true : false;
        $post->save();
        $post->tags()->sync($request->tags);
        $post->categories()->sync($request->categories);

        Toastr::success('Post Successfully Added','Success');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(Storage::disk('public')->exists('post/'.$post->image))
        {
            Storage::disk('public')->delete('post/'.$post->image);
        }
        $post->categories()->detach();
        $post->tags()->detach();

        $post->delete();

        Toastr::success('Post Delete Successfully','Success');

        return redirect()->back();
    }
}
