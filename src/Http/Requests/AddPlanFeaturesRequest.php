<?php

namespace Teckipro\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPlanFeaturesRequest extends FormRequest
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
         'code'=>'required|unique:plan_features|max:255',
         'value'=>'nullable',
         'id'=>'required'
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
        'code.required' => 'Feature cannot be empty.',
        'code.unique' => 'This feature already exists. Duplicate not allowed.',
    ];
}

}
