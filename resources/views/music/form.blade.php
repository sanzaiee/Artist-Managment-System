<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h4 class="text-primary fw-bold mb-0">Create Music</h4>
                    <p class="text-muted small mb-0">Manage and update information
                        of music</p>
                </div>
                @if($errors->count() > 0 ) @dump($errors) @endif
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb" class="me-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('music.index')}}" class="text-decoration-none text-primary">
                                    List
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>

                    <div>
                        <button class="btn btn-primary btn-sm me2">
                            <i class="bi bi-plus-circle me-1">Add Music</i>
                        </button>
                        <button class="btn btn-secondary btn-sm me2">
                            <i class="bi bi-cloud-arrow-down me-1">Export</i>
                        </button>
                    </div>
                </div>
            </div>
        @isset($music)
            <form action="{{ route('music.update',$music->id) }}" method="post" enctype="multipart/form-data">
            @method('put')
        @else
            <form action="{{ route('music.store') }}" method="post" enctype="multipart/form-data">
        @endisset
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <code>Please fill up all required fields</code>
                </div>

                <!-- Artist -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="artist_id" :value="__('Artist')" />
                        <select name="artist_id" id="artist_id" class="form-control">
                            <option value="">-- Please Select --</option>
                            @forelse($artists as $code => $artistName)
                                <option value="{{$code}}" @selected($code == (isset($artist) ? $artist->artist_id : old('artist_id')))>{{$artistName}}</option>
                            @empty
                                <option disabled> No options available</option>
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('artist_id')" class="mt-2" />
                    </div>
                </div>

                <!-- Name -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="(isset($music) ? $artist->title : old('title'))" autofocus autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                </div>

                <!-- Album Name -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="album_name" :value="__('Album Name')" />
                        <x-text-input id="album_name" class="block mt-1 w-full" type="text" name="album_name" :value="(isset($music) ? $artist->album_name : old('album_name'))" autofocus autocomplete="album_name" />
                        <x-input-error :messages="$errors->get('album_name')" class="mt-2" />
                    </div>
                </div>

                <!-- Gender -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="genre" :value="__('Genre')" />
                        <select name="genre" id="genre" class="form-control">
                            <option value="">-- Please Select --</option>
                            @forelse($genres as $code => $genre)
                                <option value="{{$code}}" @selected($code == (isset($artist) ? $music->genre : old('genre')))>{{$genre}}</option>
                            @empty
                                <option disabled> No options available</option>
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('genre')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Submit') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
