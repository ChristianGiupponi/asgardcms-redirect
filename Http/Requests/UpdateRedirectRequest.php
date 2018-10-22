<?php

namespace Modules\Redirect\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateRedirectRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'from' => 'required|url|max:255',
            'to' => 'required|url|different:from|max:255',
            'type' => 'required|in:301,302',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
