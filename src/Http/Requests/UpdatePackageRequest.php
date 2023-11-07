<?php

namespace Teckipro\Admin\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Teckipro\Admin\Domains\Plans\Http\Controllers\PlanController;
use Teckipro\Admin\Models\LaunchSubscriptionModel;

class UpdatePackageRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ! ($this->user->isMasterAdmin() && ! $this->user()->isMasterAdmin());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' =>['required',
             Rule::in([PlanController::TYPE_LAUNCH, PlanController::TYPE_SAAS])],

            'plan_id'=>[
                         'required',
                         'exists:plans,id'
                         ],
            'expired_date'=>['required','date'],
            'launch_package_type'=>['required_if:type,'.PlanController::TYPE_LAUNCH.''],
            'amount'=>['required_if:launch_package_type,'.LaunchSubscriptionModel::TYPE_CUSTOM.'','integer'],
            'transactionId'=>['required_unless:launch_package_type,'.LaunchSubscriptionModel::TYPE_CUSTOM.'']

        ];
    }
}
