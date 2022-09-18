<?php

namespace App\Http\Requests;


class EmployeeFormRequest extends Request
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
                $unique_id = ($id > 0) ? ',' . $id : '';
                $password = ($id > 0) ? "" : "required";
                $logo = ($id > 0) ? "" : "required";
                return [
                    "id" => "",
                    "name" => "required",
                    "email" => "required",
                    "password" => $password,
                    "industry_id" => "required",
//                    "description" => "required",
//                    "website" => "required|url",
                    "phone" => "required",
//                    "logo" => $logo,
                    "country_id" => "required",
                    "state_id" => "required",
                    "city_id" => "required",
                    "is_active" => "required",
                    "is_employee" => "required",
                    "belongs_to" => "required",
                ];
            }
            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'industry_id.required' => 'Please select Industry',
            'description.required' => 'Details required',
            'phone.required' => 'Phone number required',
            'logo.required' => 'Employee photo is required',
            'country_id.required' => 'Please select country',
            'state_id.required' => 'Please select state',
            'city_id.required' => 'Please select city',
            'is_active.required' => 'Is this Company Acive?',
            'is_employee.required' => 'Is this Employee?',
            'belongs_to.required' => 'Company is required',
        ];
    }

}
