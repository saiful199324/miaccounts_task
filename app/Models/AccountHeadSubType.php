<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHeadSubType extends Model
{
    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];
}
