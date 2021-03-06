@extends('layouts.backend.app')

@section('title','Categories')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    <a class="btn btn-primary btn-lg m-l-15 waves-effect" href="{{route('admin.category.create')}}">Crate new</a>

                </h2>
            </div>

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                            All Categories
                                <span class="btn bg-info bg-blue">{{$categories->count()}}</span>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Total Posts</th>
                                        <th>Created AT</th>
                                        <th>Updated AT</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Total Posts</th>
                                        <th>Created AT</th>
                                        <th>Updated AT</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>

                                 @foreach($categories as $key => $category)
                                     <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$category->name}}</td>
                                         <td><img src="{{asset('storage/category/slider/'.$category->image)}}" width="100px"></td>
                                        <td>{{$category->posts->count()}}</td>
                                         <td>{{$category->created_at}}</td>
                                        <td>{{$category->updated_at}}</td>
                                        <td>
                                            <a href="{{route('admin.category.edit',$category->id)}}"><i class="material-icons">mode_edit</i></a> \
                                            <a href="javascript:void(0)" onclick="deleteIt({{$category->id}})"><i class="material-icons">delete</i></a>
                                        </td>
                                     </tr>
                                 @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </section>

@endsection


@push('scripts')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <!-- Custom Js -->
    <script src="{{asset('assets/backend/js/admin.js')}}"></script>
    <script src="{{asset('assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>

    <!-- Demo Js -->
    <script src="{{asset('assets/backend/js/demo.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
function deleteIt(id)   {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this category",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                let deleteForm = document.createElement('form'),
                    currentURL = `{{route('admin.category.destroy','deleteid')}}`,
                    deleteURL = currentURL.replace('deleteid',id),
                    csrfInput = document.createElement('input'),
                    methodInput = document.createElement('input')
                deleteForm.style.display = 'none';
                deleteForm.method = 'POST'
                deleteForm.action = deleteURL
                csrfInput.name = `_token`
                csrfInput.value = `{{csrf_token()}}`
                methodInput.name = `_method`
                methodInput.value = `DELETE`
                deleteForm.appendChild(csrfInput)
                deleteForm.appendChild(methodInput)
                document.body.appendChild(deleteForm)
                deleteForm.submit()



            } else {
                swal("Your category is safe!");
            }
        });

}

    </script>


@endpush