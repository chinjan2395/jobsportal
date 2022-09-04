<?php

namespace App\Http\Requests;

class ReferralFormRequest extends Request
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
        switch ($this->method()) {
            case 'PUT':
            case 'POST':
            {
                $id = (int)$this->input('id', 0);
                return [
                    "company_id" => "required",
                ];
            }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'company_id.required' => 'Please select company.',
        ];
    }

}
