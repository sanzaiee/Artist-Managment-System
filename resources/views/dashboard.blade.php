<x-guest-layout>
    <div class="card p-4 d-flex justify-items-center">
        <div class="row">
            <div class="col-md-4">
                <img src="{{asset('images/music.svg')}}" alt="feel music" width="100%">
            </div>
            <div class="col-md-8">
                <h2 class="font-semibold leading-tight text-decoration-underline p-5">
                    {{ __('Dashboard') }}
                </h2>
                <div class="title p-5">
                    <h4>Welcome, {{auth()->user()->full_name}}</h4>
                    <p>You are assigned role {{auth()->user()->getRoleName() ?? ''}}</p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
