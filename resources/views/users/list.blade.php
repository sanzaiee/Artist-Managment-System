<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="text-primary fw-bold mb-0">User List</h4>
                <p class="text-muted small mb-0">Manage and update your user information</p>
            </div>

            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb" class="me-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('users.create')}}" class="text-decoration-none text-primary">
                                Create
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">List</li>
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
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users->data as $user)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$user->first_name .' '. $user->last_name}}</td>
                                <td>{{$user->role_type}}</td>
                                <td>{{$user->email ?? ''}}</td>
                                <td>{{$user->phone ?? ''}}</td>
                                <td class="d-flex justify-content-start align-item-center">
                                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-info btn-sm text-white me-2 waves-effect">
                                        EDIT
                                    </a>
                                    <form onsubmit="return confirm('Are you sure?')"
                                          action="{{ route('users.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm waves-effect">
                                            DELETE
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                        @endforelse
                    </tbody>

                </table>
                <div class="pagination d-flex justify-content-between">
                    <nav aria-label="">
                        <ul class="pagination">
                            @foreach($users->links as $link)
                                <li class="page-item {{$link->active ? 'active' : ''}}">
                                    <a class="page-link" href="{{$link->url}}">{!! $link->label  !!}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                    @if($users->total > 5)
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
                                    {{$users->total ?? 0}}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
    </div>
</x-guest-layout>
