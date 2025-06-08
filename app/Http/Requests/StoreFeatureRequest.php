<?php
// app/Http/Requests/FeatureRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeatureRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

        public function rules()
        {
            $featureId = $this->route('feature')?->id;

            return [
                'app_id' => 'required|exists:apps,id',
                'name' => 'required|string|max:255',
                'min_plan_level' => 'required|numeric|min:0',
                'code' => 'required|string|max:255|unique:features,code,' . $featureId . ',id,app_id,' . $this->input('app_id'),
                'description' => 'nullable|string',
                'value' => 'required|string|max:255',
            ];
        }


    public function messages()
    {
        return [
            'app_id.required' => 'The associated app is required.',
            'app_id.exists' => 'The selected app does not exist.',
            'code.unique' => 'This feature code already exists for the selected app.',
        ];
    }

    public function attributes()
    {
        return [
            'app_id' => 'App',
            'name' => 'Feature Name',
            'code' => 'Feature Code',
            'description' => 'Feature Description',
        ];
    }
}
