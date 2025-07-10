@php
    $alertTypes = ['success', 'danger', 'warning', 'info'];
@endphp

@foreach($alertTypes as $alertType)
    @if (session()->has($alertType))
        <div class="alert alert-{{ $alertType }} alert-dismissible fade show" role="alert">
            {{ session($alertType) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endforeach
