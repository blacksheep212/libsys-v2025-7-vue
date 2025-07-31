<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'admin_permissions' => 'array',
        ];
    }
}
