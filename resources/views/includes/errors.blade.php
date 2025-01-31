@if (Session::has('success'))
    <div class="alert alert-success" id="message-alert" role="alert">
        <i class="fa fa-check"></i>
        {{ Session::get('success') }}
    </div>
@endif

@if (Session::has('danger'))
    <div class="alert alert-danger" id="message-alert" role="alert">
        <i class="fa fa-check"></i>
        {{ Session::get('danger') }}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger" id="message-alert" role="alert">
        <i class="fa fa-check"></i>
        {{ Session::get('error') }}
    </div>
@endif

{{--@if ($errors->any())--}}
{{--    <div class="alert alert-danger" role="alert">--}}
{{--        <i class="fa fa-warning"></i>--}}
{{--        @foreach ($errors->all() as $error)--}}
{{--            <li>{{ $error }}</li>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--@endif--}}

@push('custom-scripts')
    {{-- <script>
        $("#message-alert").fadeTo(2000, 500).slideUp(500);
    </script> --}}
@endpush
