<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'app_id' => 'required|exists:apps,id',
            'guard_name' => 'required|string|max:255',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (Role::roleExists($this->name, $this->app_id, $this->guard_name)) {
                $validator->errors()->add('name', "A role `{$this->name}` already exists for guard `{$this->guard_name}`.");
            }
        });
    }
}
