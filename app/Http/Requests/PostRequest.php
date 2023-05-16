<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'post.prefecture_id' => 'required',
            'post.place' => 'required|string',
            'post.star' => 'required',
            'post.title' => 'max:20',
            'post.body' => 'required|max:200',
        ];
    }
    
    public function messages()
    {
        return [
            'post.prefecture_id.required' => '選択してください',
            'post.place.required' => 'スポットを入力してください',
            'post.star.required' => '選択してください',
            'post.body.required' => '本文を入力してください',
            'post.body.max' => '200字以内で入力してください',
            ];
    }
}
