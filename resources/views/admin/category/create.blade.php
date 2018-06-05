@extends('layouts.backend.app')

@section('title','Create Category')

@push('css')

@endpush


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    Create Category
                    <small>Crate new category here</small>
                </h2>
            </div>

            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Create Category
                            </h2>
                        </div>
                        <div class="body">
                            <form action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <label for="email_address">Name</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input name="name" type="text" id="name" class="form-control" placeholder="Enter tag name">
                                    </div>
                                </div>
                                <label for="email_address">Image</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input name="image" type="file" id="image" class="form-control">
                                    </div>
                                </div>
                                <a href="{{route('admin.category.index')}}" class="btn btn-warning btn-lg m-t-15 waves-effect">Back</a>
                                <button type="submit" class="btn btn-primary btn-lg m-t-15 waves-effect">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->

        </div>
    </section>
@endsection


@push('scripts')

    <!-- Custom Js -->
    <script src="{{asset('assets/backend/js/admin.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{asset('assets/backend/js/demo.js')}}"></script>

@endpush