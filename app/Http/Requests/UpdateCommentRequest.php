<?php

namespace App\Http\Requests;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $id = $this->user()->id;
        $comment = Comment::find($this->id);

        if (!$comment) {
            return false;
        }
        return $this->user()->tokenCan('can_comment') && $id == $comment->user_id;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'body' => ['required'],
        ];
    }

    // public function prepareForValidation()
    // {
    // }
}
