<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $post_id = $this->id;

        return [
            'title' => 'required|string|unique:posts,title,' . $post_id,
            'image' => 'required_if:type,==,create',
            'date' => 'required|date',
        ];
    }

}
