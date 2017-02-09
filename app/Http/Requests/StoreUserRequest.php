<?php

namespace App\Http\Requests;

use App\Traits\Response;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    use Response;
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
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|regex:/^[\w-]*$/',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|alpha',
            'vibrate' => 'required|between:0,1'
        ];
    }

    public function response(array $array)
    {
        return $this->respondWithUserError($array);
    }
}
