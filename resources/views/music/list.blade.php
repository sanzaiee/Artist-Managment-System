<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="text-primary fw-bold mb-0">Music List</h4>
                <p class="text-muted small mb-0">Manage and update your music information</p>
            </div>

            <form action="{{ route('music.index') }}" method="get">
                <div class="d-flex justify-items-center">
                        <input name="search" class="form-control me-1" placeholder="search by title...">
                        <button class="btn btn-sm btn-primary me-1"><i>Search</i></button>
                        <a class="btn btn-sm btn-danger" href="{{route('music.index')}}">
                            <i>Refresh</i>
                        </a>
                </div>
            </form>

            <div class="d-flex align-items-center">

                <nav aria-label="breadcrumb" class="me-3">
                    <ol class="breadcrumb mb-0">
                        @can('create',$musicInstance)
                            <li class="breadcrumb-item">
                                <a href="{{route('music.create')}}" class="text-decoration-none text-primary">
                                    Create
                                </a>
                            </li>
                        @endcan
                        <li class="breadcrumb-item active" aria-current="page">List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row m-2">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Artist</th>
                            <th>Title</th>
                            <th>Album Name</th>
                            <th>Genre</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($music->data as $mus)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$mus->artist_name}}</td>
                                <td>{{$mus->title}}</td>
                                <td>{{$mus->album_name ?? ''}}</td>
                                <td>{{ getGenreValue($mus->genre) }}</td>
                                <td>{{ getDateFormat($mus->created_at) }}</td>

                                <td class="d-flex justify-content-start align-item-center">
                                    <a href="{{route('music.show',$mus->id)}}" class="btn btn-secondary btn-sm text-white me-2">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    @can('update',new \App\Models\Music())
                                        <a href="{{route('music.edit',$mus->id)}}" class="btn btn-info btn-sm text-white me-2">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete',new \App\Models\Music())
                                        <form onsubmit="return confirm('Are you sure?')"
                                              action="{{ route('music.destroy', $mus->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm waves-effect">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan

                                </td>

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
