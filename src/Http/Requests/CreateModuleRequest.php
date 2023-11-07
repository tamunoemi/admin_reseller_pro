<?php

namespace Teckipro\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateModuleRequest extends FormRequest
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
         'module_name'=>'required|unique:modules|max:255',
         'route'=>'required|string',
         'add_ons_id'=>'nullable|numeric',
         'extra_text'=> 'nullable',
         'limit_enabled'=>'nullable',
         'bulk_limit_enabled'=> 'nullable'
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
        'module_name.required' => 'Enter a name for the module',
        'route.required' => 'Enter route path'
    ];
}

}
