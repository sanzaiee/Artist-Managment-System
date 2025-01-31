<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h4 class="text-primary fw-bold mb-0">@isset($music) Update @else Create @endisset Music</h4>
                <p class="text-muted small mb-0">Manage and update information of music</p>
            </div>

            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb" class="me-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('music.index')}}" class="text-decoration-none text-primary">
                                List
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@isset($music) Update @else Create @endisset</li>
                    </ol>
                </nav>
            </div>
        </div>

        <form action="{{isset($music) ? route('music.update',$music->id) : route('music.store') }}" id="form-select" method="post" enctype="multipart/form-data">
            @isset($music)
                @method('put')
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
                                <option value="{{$code}}" @selected($code == old('artist_id',isset($music) ? $music->artist_id : ''))>{{$artistName}}</option>
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
                        <x-input-label for="title" :value="__('Title')" /><code>*</code>
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title',isset($music) ? $music->title : '')" autofocus autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                </div>

                <!-- Album Name -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="album_name" :value="__('Album Name')" /><code>*</code>
                        <x-text-input id="album_name" class="block mt-1 w-full" type="text" name="album_name" :value="old('album_name',isset($music) ? $music->album_name : '')" autofocus autocomplete="album_name" />
                        <x-input-error :messages="$errors->get('album_name')" class="mt-2" />
                    </div>
                </div>

                <!-- Gender -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="genre" :value="__('Genre')" /><code>*</code>
                        <select name="genre" id="genre" class="form-control">
                            <option value="">-- Please Select --</option>
                            @forelse($genres as $code => $genre)
                                <option value="{{$code}}" @selected($code == old('genre',isset($music) ? $music->genre : ''))>{{$genre}}</option>
                            @empty
                                <option disabled> No options available</option>
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('genre')" class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4" id="submitButton">
                        {{ __('Submit') }}
                    </x-primary-button>
                   <x-loader />
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
