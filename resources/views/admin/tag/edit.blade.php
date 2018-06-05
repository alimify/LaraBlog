@extends('layouts.backend.app')

@section('title','Create Tag')

@push('css')

@endpush


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    Edit Tags
                    <small>Edit new tags here</small>
                </h2>
            </div>

            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Tag
                            </h2>
                        </div>
                        <div class="body">
                            <form action="{{route('admin.tag.update',$tag->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <label for="email_address">Name</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input name="name" type="text" id="name" class="form-control" value="{{$tag->name}}">
                                    </div>
                                </div>
                                <a href="{{route('admin.tag.index')}}" class="btn btn-warning btn-lg m-t-15 waves-effect">Back</a>
                                <button type="submit" class="btn btn-primary btn-lg m-t-15 waves-effect">EDIT</button>
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