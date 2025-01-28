<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="mb-4">
                    <h4 class="text-primary fw-bold mb-3">Create Artist</h4>
                    <p class="text-muted small mb-2">
                        Please make sure that the uploaded file is either in <strong> xls</strong> or <strong>xlsx </strong> format. To help you get started, you can
                        download the sample file using the below link.
                    </p>
                    <a href="{{asset('sample.xlsx')}}" class="btn btn-info btn-sm me2">
                        Download Sample File
                    </a>
                </div>

                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb" class="me-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('artists.index')}}" class="text-decoration-none text-primary">
                                    List
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>

        <form action="{{route('artists.import')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-center justify-content-end mb-4">
                <div class="form-group">
                    <label for="import" class="fw-bold">Import Artist</label>
                    <input type="file" accept="xlsx" name="excel_file" id="import" class="form-control">
                    <x-input-error :messages="$errors->get('excel_file')" class="mt-2" />
                </div>
                <button class="btn btn-secondary btn-sm mt-4">
                    <i> {{ __('Import') }} </i>
                </button>
            </div>
        </form>

        @isset($artist)
            <form action="{{ route('artists.update',$artist->id) }}" method="post" enctype="multipart/form-data">
            @method('put')
        @else
            <form action="{{ route('artists.store') }}" method="post" enctype="multipart/form-data">
        @endisset
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <code> Please fill up all required fields </code>
                </div>
                <!-- Name -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="(isset($artist) ? $artist->name : old('name'))" autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>

                <!-- DOB -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="dob" :value="__('Date Of Birth')" />
                        <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="(isset($artist) ? $artist->dob : old('dob'))" autofocus autocomplete="dob" />
                        <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                    </div>
                </div>

                <!-- Gender -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="gender" :value="__('Gender')" />
                        <select name="gender" id="gender" class="form-control">
                            <option value="">-- Please Select --</option>
                            @forelse($gender_types as $code => $gender)
                                <option value="{{$code}}" @selected($code == (isset($artist) ? $artist->gender : old('gender')))>{{$gender}}</option>
                            @empty
                                <option disabled> No options available</option>
                            @endforelse
                        </select>
{{--                        <x-select id="gender" class="block mt-1 w-full" name="gender" :value="(isset($artist) ? $artist->gender : old('gender'))" :secondary_model="$gender_types" autofocus autocomplete="gender" />--}}
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                </div>




                <!-- Address -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="address" :value="__('Address')" />
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="(isset($artist) ? $artist->address : old('address'))" autofocus autocomplete="address" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>

                <!-- First Release Year -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="first_release_year" :value="__('First Release Year')" />
                        <x-text-input id="first_release_year" class="block mt-1 w-full" type="number" name="first_release_year" :value="(isset($artist) ? $artist->first_release_year : old('first_release_year'))" autofocus autocomplete="first_release_year" />
                        <x-input-error :messages="$errors->get('first_release_year')" class="mt-2" />
                    </div>
                </div>

                <!-- No of albums released -->
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <x-input-label for="no_of_albums_released" :value="__('No Of Albums Released')" />
                        <x-text-input id="no_of_albums_released" class="block mt-1 w-full" type="number" name="no_of_albums_released" :value="(isset($artist) ? $artist->no_of_albums_released : old('no_of_albums_released'))" autofocus autocomplete="no_of_albums_released" />
                        <x-input-error :messages="$errors->get('no_of_albums_released')" class="mt-2" />
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
