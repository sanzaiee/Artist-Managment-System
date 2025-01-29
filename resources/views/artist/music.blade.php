<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="text-primary fw-bold mb-0">Music List</h4>
                <p class="text-muted small mb-0">
                    These are the list of music by <strong>{{$artist->name}}</strong>
                </p>
            </div>

            <form action="{{ route('artists.music',$artist->id) }}" method="get">
                <div class="d-flex justify-items-center">
                    <input name="search" class="form-control me-1" placeholder="search by title...">
                    <button class="btn btn-sm btn-primary me-1"><i>Search</i></button>
                    <a class="btn btn-sm btn-danger" href="{{ route('artists.music',$artist->id) }}">
                        <i>Refresh</i>
                    </a>
                </div>
            </form>

            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb" class="me-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('artists.index')}}" class="text-decoration-none text-primary">
                                Artist List
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Music</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Title</th>
                        <th>Album Name</th>
                        <th>Genre</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($music->data as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->title ?? ''}}</td>
                            <td>{{$item->album_name ?? ''}}</td>
                            <td>{{getGenreValue($item->genre)}}</td>
                            <td>{{ getDateFormat($item->created_at) }}</td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
                <x-pagination :model="$music" />
            </div>
        </div>
    </div>
</x-guest-layout>
