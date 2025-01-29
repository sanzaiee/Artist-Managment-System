<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="text-primary fw-bold mb-0">Artist List</h4>
                <p class="text-muted small mb-0">Manage and update your artist information</p>
            </div>

            <form action="{{ route('artists.index') }}" method="get">
                <div class="d-flex justify-items-center">
                    <input name="search" class="form-control me-1" placeholder="search by name...">
                    <button class="btn btn-sm btn-primary me-1"><i>Search</i></button>
                    <a class="btn btn-sm btn-danger" href="{{route('artists.index')}}">
                        <i>Refresh</i>
                    </a>
                </div>
            </form>

            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb" class="me-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('artists.create')}}" class="text-decoration-none text-primary">
                                Create
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">List</li>
                    </ol>
                </nav>

                <div>
                    <a href="{{ route('artists.index',['export' => true, 'search' => request('search'), 'page' =>request('page'), 'perPage' =>request('perPage')]) }}" class="btn btn-secondary btn-sm me2">
                        <i>Export</i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-strip">
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Date Of Birth</th>
                            @can('action',$artistInstance)
                                <th>Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($artists->data as $artist)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$artist->name}}</td>
                                <td>{{$artist->address ?? ''}}</td>
                                <td>{{$artist->dob ?? ''}}</td>

                                @can('action',$artistInstance)
                                    <td class="d-flex justify-content-start align-item-center">
                                        <a href="{{route('artists.music',$artist->id)}}" class="btn btn-primary btn-sm text-white me-2">
                                            MUSICS
                                        </a>

                                        <a href="{{route('artists.edit',$artist->id)}}" class="btn btn-info btn-sm text-white me-2">
                                            EDIT
                                        </a>

                                        <form onsubmit="return confirm('Are you sure?')"
                                              action="{{ route('artists.destroy', $artist->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm waves-effect">
                                                DELETE
                                            </button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                        @endforelse
                    </tbody>

                </table>

                <x-pagination :model="$artists" />
            </div>
        </div>
    </div>


</x-guest-layout>
