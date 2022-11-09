<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $admin_id = $this->id;

        return [
            'role_id' => 'required|integer|exists:roles,id',
            'email' => 'required|string|email|unique:admins,email,' . $admin_id,
            'name' => 'required|string|min:3|max:45',
        ];
    }
    public function messages()
    {
        return [
            'role_id.required' => __('admin.Please_select_role'),
            'email.required' => __('admin.Please_enter_your_email_address'),
            'email.email' => __('admin.email_email'),
            'email.unique' => __('admin.email_unique'),
            'name.required' => __('admin.Please_enter_your_full_name'),
            'name.string' => __('admin.name_string'),
            'name.min' => __('admin.name_min'),
            'name.max' => __('admin.name_max'),


        ];
    }
}
