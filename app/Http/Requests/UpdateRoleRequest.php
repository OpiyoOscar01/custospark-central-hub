<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;

class UpdateRoleRequest extends FormRequest
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
            $roleId = $this->route('role')->id;

            $exists = Role::where('name', $this->name)
                ->where('app_id', $this->app_id)
                ->where('guard_name', $this->guard_name)
                ->where('id', '!=', $roleId)
                ->exists();

            if ($exists) {
                $validator->errors()->add('name', "A role `{$this->name}` already exists for guard `{$this->guard_name}`.");
            }
        });
    }
}

