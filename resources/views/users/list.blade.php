<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="text-primary fw-bold mb-0">User List</h4>
                <p class="text-muted small mb-0">Manage and update your user information</p>
            </div>

            <form action="{{ route('users.index') }}" method="get">
                <div class="d-flex justify-items-center">
                    <input name="search" class="form-control me-1" placeholder="search by name...">
                    <button class="btn btn-sm btn-primary me-1"><i>Search</i></button>
                    <a class="btn btn-sm btn-danger" href="{{route('users.index')}}">
                        <i>Refresh</i>
                    </a>
                </div>
            </form>

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
                <table class="table table-striped table-bordered table-hover">
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
                                    <a href="{{route('users.show',$user->id)}}" class="btn btn-secondary btn-sm text-white me-2 waves-effect">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-info btn-sm text-white me-2 waves-effect">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form onsubmit="return confirm('Are you sure?')"
                                          action="{{ route('users.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm waves-effect">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                        @endforelse
                    </tbody>

                </table>
                <x-pagination :model="$users" />
            </div>
        </div>
    </div>
</x-guest-layout>
