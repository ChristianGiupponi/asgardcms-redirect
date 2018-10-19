<?php

namespace Modules\Redirect\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateRedirectRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'from' => 'required|url',
            'to' => 'required|url|different:from',
            'type' => 'required|in:301,302',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
