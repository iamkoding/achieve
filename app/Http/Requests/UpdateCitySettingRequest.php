<?php

namespace App\Http\Requests;

use App\Traits\Response;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCitySettingRequest extends FormRequest
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
            'city_id' => 'required|exists:cities,id'            
        ];
    }

    public function response(array $array)
    {
        return $this->respondWithUserError("City does not exist");
    }
}
