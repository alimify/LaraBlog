<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.category.create');
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
            'name' => 'required|max:50',
            'image' => 'mimes:bmp,png,jpg,jpeg,gif'
        ]);

        $slug = str_slug($request->name);
        $image = $request->file('image');

        if(isset($image)) {
            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }
            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }

            $imageName = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            $category = Image::make($image)->resize(1600,479)->save('tmp/file.'.$image->getClientOriginalExtension());
            Storage::disk('public')->put('category/'.$imageName,$category);

            $slider = Image::make($image)->resize(500,333)->save('tmp/file.'.$image->getClientOriginalExtension());
            Storage::disk('public')->put('category/slider/'.$imageName,$slider);


        }else{
            $imageName = 'default.png';
        }
        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imageName;
        $category->save();
        Toastr::success('New category successfully created..','Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return $request;

        $this->validate($request,[
            'name' => 'required|max:50',
            'image' => 'mimes:bmp,png,jpg,jpeg,gif'
        ]);

        $image = $request->file('image');
        $category = Category::find($id);
        $slug = str_slug($request->name);

        if(isset($image)) {
            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }
            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }

            $imageName = $slug.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            $categoryIM = Image::make($image)->resize(1600,479)->save('tmp/file.'.$image->getClientOriginalExtension());
            Storage::disk('public')->put('category/'.$imageName,$categoryIM);

            $sliderIM = Image::make($image)->resize(500,333)->save('tmp/file.'.$image->getClientOriginalExtension());
            Storage::disk('public')->put('category/slider/'.$imageName,$sliderIM);


            if(Storage::disk('public')->exists('category/'.$category->image)){
                Storage::disk('public')->delete('category/'.$category->image);
            }
            if(Storage::disk('public')->exists('category/slider/'.$category->image)){
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }



        }else{
            $imageName = $category->image;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imageName;
        $category->save();
        Toastr::success('Category successfully updated..','Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if(Storage::disk('public')->exists('category/'.$category->image)){
            Storage::disk('public')->delete('category/'.$category->image);
        }
        if(Storage::disk('public')->exists('category/slider/'.$category->image)){
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }
        $category->delete();
        Toastr::success('Category successfully deleted..','Success');
        return redirect()->back();
    }
}
