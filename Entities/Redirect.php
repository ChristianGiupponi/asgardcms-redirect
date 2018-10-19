<?php

namespace Modules\Redirect\Entities;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $table = 'redirect__redirects';
    protected $fillable = [
        'from',
        'to',
        'type',
    ];
}
