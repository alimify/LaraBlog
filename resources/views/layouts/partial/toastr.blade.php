<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script>
    @if ($errors->any())
    @foreach ($errors->all() as $error)

    toastr.error('{{ $error }}');
@endforeach
@endif
</script>
{!! Toastr::message() !!}