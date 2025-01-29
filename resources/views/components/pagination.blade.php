@props(['model'])
<div class="pagination d-flex justify-content-between">
    <nav aria-label="">
        <ul class="pagination">
            @foreach($model->links as $link)
                <li class="page-item {{$link->active ? 'active' : ''}}">
                    <a class="page-link" href="{{$link->url}}">{!! $link->label  !!}</a>
                </li>
            @endforeach
        </ul>
    </nav>
    @if($model->total > 5)
        <div class="d-flex align-items-center gap-2 dropdown-pagination">
            <label for="perPage" class="me-2 mb-0 fw-bold">Records:</label>
            <select name="perPage" id="" class="form-control form-select-sm w-auto" onchange="updatePerPage(this.value)">
                <option value="5" @selected(request('perPage') == 5)>5</option>
                <option value="10" @selected(request('perPage') == 10)>10</option>
                <option value="20" @selected(request('perPage') == 20)>20</option>
                <option value="50" @selected(request('perPage') == 50)>50</option>
                <option value="100" @selected(request('perPage') == 100)>100</option>
            </select>
            <div>
                <span>/</span>
                <span class="fw-bold">
                    {{$model->total ?? 0}}
                </span>
            </div>
        </div>
    @endif
</div>


@push('custom-scripts')
    <script>
        function updatePerPage(perPage){
            const url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            url.searchParams.set('page', 1);
            window.location.href = url.toString();
        }
    </script>
@endpush
