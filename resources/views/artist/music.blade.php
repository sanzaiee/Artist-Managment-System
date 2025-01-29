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
                <table class="table table-strip">
                    <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Title</th>
                        <th>Album Name</th>
                        <th>Genre</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($music->data as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->title}}</td>
                            <td>{{$item->album_name ?? ''}}</td>
                            <td>{{\App\Models\Music::GENRE[$item->genre] ?? ''}}</td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>

                <div class="pagination d-flex justify-content-between">
                    <nav aria-label="">
                        <ul class="pagination">
                            @foreach($music->links as $link)
                                <li class="page-item {{$link->active ? 'active' : ''}}">
                                    <a class="page-link" href="{{$link->url}}">{!! $link->label  !!}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                    @if($music->total > 5)
                        <div class="d-flex align-items-center gap-2">
                            <label for="perPage" class="me-2 mb-0 fw-bold">Records:</label>
                            <select name="perPage" id="" class="form-control form-select-sm w-auto" onchange="updatePerPage(this.value)">
                                <option value="10" @selected(request('perPage') == 5)>5</option>
                                <option value="10" @selected(request('perPage') == 10)>10</option>
                                <option value="20" @selected(request('perPage') == 20)>20</option>
                                <option value="50" @selected(request('perPage') == 50)>50</option>
                                <option value="100" @selected(request('perPage') == 100)>100</option>
                            </select>
                            <div>
                                <span>/</span>
                                <span class="fw-bold">
                                    {{$artists->total ?? 0}}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
