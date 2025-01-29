<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="text-primary fw-bold mb-0">Music [{{ucfirst($music->title)}}]</h4>
            </div>

            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb" class="me-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('music.index')}}" class="text-decoration-none text-primary">
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
                    <img src="{{asset('/images/feel.png')}}" class="img-fluid rounded" alt="music" width="100%">
                </div>
                <div class="col-md-9">
                    <div class="music-title text-uppercase fw-bold">{{$music->title}}
                        <h5 class="text-muted">By <span class="text-primary">{{$music->artist_name}}</span></h5>
                    </div>
                    <div class="music-body mt-3">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Album Name:</strong>
                                <span class="text-secondary">{{ ucfirst($music->album_name ?? '')}}</span>
                            </li>
                            <li>
                                <strong>Genre:</strong>
                                <span class="text-secondary">{{ getGenreValue($music->genre) }}</span>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
