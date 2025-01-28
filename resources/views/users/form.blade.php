<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        @isset($user)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h4 class="text-primary fw-bold mb-0">Edit User</h4>
                    <p class="text-muted small mb-0">Manage and update information
                        of {{$user->first_name ." ". $user->last_name }}</p>
                </div>

                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb" class="me-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('users.index')}}" class="text-decoration-none text-primary">
                                    List
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <livewire:registration :create="true" :user="$user"/>
        @else
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h4 class="text-primary fw-bold mb-0">User Create</h4>
                    <p class="text-muted small mb-0">Manage and update your user information</p>
                </div>

                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb" class="me-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('users.index')}}" class="text-decoration-none text-primary">
                                    List
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <livewire:registration :create="true"/>
        @endisset

    </div>
</x-guest-layout>
