@if (session('alert-success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('alert-success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('alert-danger'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session('alert-danger') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('alert-warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ session('alert-warning') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
            <strong>
                <li>{{ $error }}</li>
            </strong>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
