<?php

namespace App\Http\Requests\Music;

use Illuminate\Foundation\Http\FormRequest;

class MusicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'artist_id' => ['required','numeric'],
            'title' => ['required', 'string', 'max:255'],
            'album_name' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'in:rnb,country,classic,rock,jazz'],
        ];
    }
}
