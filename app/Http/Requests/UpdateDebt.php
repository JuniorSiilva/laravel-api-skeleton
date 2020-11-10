<?php

namespace App\Http\Requests;

use App\Enums\AttachmentExtension;

class UpdateDebt extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => ['required', 'string', 'max:50'],
            'buy_date' => ['required', 'date', 'date_format:"Y-m-d"'],
            'card.id' => ['nullable', 'integer', 'exists:cards,id,owner_id,' . current_user_id()],
            'tags' => ['required', 'array', 'min:1'],
            'tags.*.id' => ['required', 'integer', 'exists:tags,id,owner_id,' . current_user_id()],
            'attachments' => ['nullable', 'array'],
            'attachments.*.file' => ['required', 'file', 'mimes:' . AttachmentExtension::availableMimeTypes()],
            'attachments.*.description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
