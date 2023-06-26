<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'description' => 'sometimes|required|string|unique:subjects,description',
            'syllabus' => 'sometimes|required|file|mimes:pdf',
            'lec_units' => 'required|integer|min:1|max:5',
            'lab_units' => 'required|integer|min:1|max:5',
            'total_units' => 'required|integer|max:5',
            'hrs_per_week' => 'required|integer|min:1|max:5',
        ];
    }

    public function messages()
    {
        return [
            'total_units.max' => 'sum of lecture and lab units must not exceed 5 units',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->subjectCode) {
            $this->merge([
                'subject_code' => $this->subjectCode
            ]);
        }
    }
}
