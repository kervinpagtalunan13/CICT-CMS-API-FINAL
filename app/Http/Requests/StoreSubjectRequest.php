<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return $this->user()->tokenCan('can_create_subject');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'subjectCode' => ['required', 'unique:subjects,subject_code'],
            'description' => ['required', 'unique:subjects,description'],
            'syllabus' => (!$this->is_elective) ? 'required|file|mimes:pdf' : '',
            'is_elective' => (!!$this->is_elective) ? 'required|unique:subjects' : '',
            'lec_units' => 'required|integer|min:1|max:5',
            'lab_units' => 'required|integer|min:1|max:5',
            'total_units' => 'required|integer|max:5',
            'hrs_per_week' => 'required|integer|min:1|max:5',
        ];

        // if ($this->hasFile('image')) {
        //     $rules['image'] = 'image|mimes:jpeg,png|max:2048';
        // }

        return $rules;
    }

    public function messages()
    {
        return [
            'total_units.max' => 'sum of lectures and lab units must not exceed 5 units',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'subject_code' => $this->subjectCode,
            'department_id' => $this->departmentId,
            'user_id' => $this->user()->id,
        ]);
    }
}
