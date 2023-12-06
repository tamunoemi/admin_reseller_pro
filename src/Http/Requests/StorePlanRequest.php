<?php

namespace Teckipro\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Closure;

class StorePlanRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
         'name'=>[
            'required',
            'unique:plans',
            'max:255',
         function (string $attribute, mixed $value, Closure $fail) {
            if (!preg_match('/^\S*$/u', $value)) {
                $fail("The {$attribute} is invalid.Spacing not allowed");
            }
        }
        ],
         'name_alias'=>'required',
         'role_ids'=>'required',
         'price'=>'required',
         'description'=>'required',
         'coupon'=>'nullable',
         'discount'=>'nullable',
         'trial_period_days'=>'nullable',
         'interval'=>'required',
         'interval_count'=>'required',
         'monthly_limit'=>'required|integer',
         'bulk_limit'=>'required|integer',
         'visible'=> 'nullable',
         'highlight'=>'nullable',
         'user_can_resell'=>'nullable',
         'jvzoo_id'=> 'nullable',
         'warriorplus_id'=> 'nullable',
         'appsumo_id'=> 'nullable',
         'clickbank_id'=> 'nullable',
         'paddle_id'=>'nullable',
         'stripe_id'=>'nullable'
        ];
    }


    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array<string, string>
 */
public function messages(): array
{
    return [
        'name.required' => 'Enter a name for the plan',
        'price.required' => 'Price is required',
        'description.required' => 'A short header descriptive text for this plan is required',
        'validity.required' => 'Validity is required',
    ];
}

}
