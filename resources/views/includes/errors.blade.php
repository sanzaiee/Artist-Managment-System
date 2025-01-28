@if ($errors->any())
    <div class="text-danger small">
        @foreach ($errors->all() as $message)
            <p>{{ $message }}</p>
        @endforeach
    </div>
@endif
