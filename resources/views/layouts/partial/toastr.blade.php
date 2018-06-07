<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

    @if ($errors->any())
        <script>
    @foreach ($errors->all() as $error)

    toastr.error('{{ $error }}');
            @endforeach
        </script>
@endif

{!! Toastr::message() !!}