<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RetirementNeedsRequest extends Request
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
        return [
            'annual_income' => 'required',
            'annual_ss_benefit' => 'required',
            'annual_employer_benefit' => 'required',
            'additional_annual_income_required' => 'required',
            'desired_retirement_age' => 'required',
            'retirment_age_factor' => 'required',
            'retirment_goal' => 'required',
            'employee_retirment_savings' => 'required',
            'personal_retirment_savings' => 'required',
            'investements_value' => 'required',
            'retirement_savings_and_investments' => 'required',
            'retirment_years_age' => 'required',
            'retirment_years_factor' => 'required',
            'future_value_of_savings_and_investments' => 'required',
            'entered_retirment_goal' => 'required',
            'entered_future_value_of_savings_and_investments' => 'required',
            'additional_savings_needed_for_retirement' => 'required',
            'entered_desired_retirement_age' => 'required',
            'addition_annual_savings_required' => 'required',
        ];
    }
}
