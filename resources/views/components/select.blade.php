@props(['disabled' => false, 'secondary_model' => []])
<select @disabled($disabled) {{ $attributes->merge(['class' => 'form-control']) }}>
    <option value="">-- Please Select --</option>
    @forelse($secondary_model as $value =>  $data)
        <option value="{{$value}}">{{$data}}</option>
    @empty
        <option disabled> No options available</option>
    @endforelse
</select>
