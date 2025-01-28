@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'form-control']) }}>
    <option value="">-- Select Gender --</option>
    @foreach(\App\Models\User::GENDERS as $code =>  $gender)
        <option value="{{$code}}">{{$gender}}</option>
    @endforeach
</select>
