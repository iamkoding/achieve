<?php

namespace App\Http\Requests;

use App\Traits\Response;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordSettingRequest extends FormRequest
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
            'new_password' => 'required|regex:/^[\w-]*$/',
            'password' => 'required|regex:/^[\w-]*$/'
        ];
    }

    public function response(array $array)
    {
        return $this->respondWithUserError('The password format is incorrect');
    }
}
