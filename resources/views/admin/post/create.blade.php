@extends('layouts.backend.app')

@section('title','Create New Post')

@push('css')
    <!-- Bootstrap Select Css -->
    <link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    Create New Post
                    <small>Crate new post here</small>
                </h2>
            </div>

            <form action="{{route('admin.post.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Create New Post
                            </h2>
                        </div>
                        <div class="body">
                                <label for="title">Title</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input name="title" type="text" id="title" class="form-control" placeholder="Enter Post Title">
                                    </div>
                                </div>
                            <label for="image">Featured Image</label>
                              <div class="form-group">
                                <div class="form-line">
                                    <input name="image" type="file" id="image" class="form-control">
                                </div>
                            </div>
                            <input type="checkbox" id="publish" class="filled-in" name="publish" value="1">
                            <label for="publish">Publish</label>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Categories & Tags
                            </h2>
                        </div>
                        <div class="body">
                                <p>
                                    <b>Categories</b>
                                </p>
                                <select name="categories[]" class="form-control show-tick" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                </select>
                            <p>
                                <b>Tags</b>
                            </p>
                            <select name="tags[]" class="form-control show-tick" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                    @endforeach
                            </select>
                            <a href="{{route('admin.post.index')}}" class="btn btn-warning btn-lg m-t-15 waves-effect">Back</a>
                            <button type="submit" class="btn btn-primary btn-lg m-t-15 waves-effect">Create</button>
                        </div>
                    </div>
                </div>

            </div>
            <!-- #END# Vertical Layout -->

                <!-- TinyMCE -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                 Body
                                </h2>
                            </div>
                            <div class="body">
                            <textarea id="tinymce" name="body">

                            </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# TinyMCE -->



            </form>

        </div>
    </section>
@endsection


@push('scripts')

    <!-- Select Plugin Js -->
    <script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

   <!--Editors -->
   <script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>
   <script src="{{asset('assets/backend/js/pages/forms/editors.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('assets/backend/js/admin.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{asset('assets/backend/js/demo.js')}}"></script>

@endpush