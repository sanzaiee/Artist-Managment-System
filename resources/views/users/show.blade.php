<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="text-primary fw-bold mb-0">Artist - {{ucfirst($artist->name)}}</h4>
            </div>

            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb" class="me-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('artists.index')}}" class="text-decoration-none text-primary">
                                List
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">View</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card shadow-lg border-0 p-3">
            <div class="row m-2">
                <div class="col-md-3">
                    <img src="{{asset('/images/profile.svg')}}" class="img-fluid rounded" alt="profile" width="100%">
                </div>
                <div class="col-md-9">
                    <div class="music-title text-uppercase fw-bold">{{$artist->name}}
                        <h6 class="text-muted">Birth Date <span class="text-primary">{{$artist->dob}}</span></h6>
                    </div>
                    <div class="music-body mt-3">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Gender:</strong>
                                <span class="text-secondary">{{ getGenderValue($artist->gender) }}</span>
                            </li>
                            <li class="mb-2">
                                <strong>Address:</strong>
                                <span class="text-secondary">{{ ucfirst($artist->address ?? '')}}</span>
                            </li>
                            <li class="mb-2">
                                <strong>First Released Year:</strong>
                                <span class="text-secondary">{{ ucfirst($artist->first_released_year ?? '')}}</span>
                            </li>
                            <li class="mb-2">
                                <strong>No of albums released:</strong>
                                <span class="text-secondary">{{ ucfirst($artist->no_of_albums_released ?? '')}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
