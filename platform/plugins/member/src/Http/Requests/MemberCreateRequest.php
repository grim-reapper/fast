<?php

namespace Fast\Member\Http\Requests;

use Fast\Support\Http\Requests\Request;

class MemberCreateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:120|min:2',
            'email' => 'required|max:60|min:6|email|unique:members',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
