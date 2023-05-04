<?php

namespace App\Http\Requests;

use App\Models\Curriculum;
use App\Models\CurriculumRevision;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRevisionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $curriculum = CurriculumRevision::find($this->id);
        // if (!$curriculum) {
        //     return false;
        // }

        // if ($curriculum->user_id != $this->user()->id) {
        //     return false;
        // }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'subjects' => ['sometimes', 'required'],
            'version' => ['sometimes', 'required'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'metadata' => json_encode($this->subjects),
        ]);
    }
}
