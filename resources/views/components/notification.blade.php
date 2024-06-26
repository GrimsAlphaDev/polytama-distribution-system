@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade" role="alert" id="notification">
    <h4 class="alert-heading" id="notification-message">Terjadi Kesalahan</h4>
    <hr>
    <p class="mb-0">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
        id="notification-close"></button>
</div>
@endif


@if(session('success'))
<div class="alert alert-success alert-dismissible fade" role="alert" id="notification">
    <h4 class="alert-heading" id="notification-message">{{ session('success') }}</h4>
    <hr>
    <p class="mb-0">
        {{ session('description') }}
    </p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
        id="notification-close"></button>
</div>
@endif 