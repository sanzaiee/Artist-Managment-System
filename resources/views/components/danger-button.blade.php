<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger btn-sm text-uppercase d-inline-flex align-items-center fw-semibold border-0 rounded px-4 py-2']) }}>
    {{ $slot }}
</button>
