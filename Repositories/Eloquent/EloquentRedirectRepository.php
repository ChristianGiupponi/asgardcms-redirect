<?php

namespace Modules\Redirect\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Redirect\Repositories\RedirectRepository;

class EloquentRedirectRepository extends EloquentBaseRepository implements RedirectRepository
{
    public function where($column, $value, $compare = '=')
    {
        return $this->model->where($column, $compare, $value);
    }
}
