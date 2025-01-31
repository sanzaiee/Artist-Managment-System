<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="text-primary fw-bold mb-0">Log List</h4>
                <p class="text-muted small mb-0">Preview log information</p>
            </div>

            <div class="d-flex align-items-center">

                <nav aria-label="breadcrumb" class="me-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" aria-current="page">
                            <form onsubmit="return confirm('Are you sure?')"
                                    action="{{ route('activity.destroy') }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete All Logs</button>
                            </form>
                        </li>
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
                            <th>Created On</th>
                            <th>Event</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $index => $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td> {{ $item->created_at->format('M d Y, H:i s') }}</td>
                                <td>{{ $item->event}}</td>
                                <td>{{ $item }}</td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>
