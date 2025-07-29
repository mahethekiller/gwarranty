<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchEmail extends Model
{
    protected $fillable = [
        'zone_name',
        'state',
        'city',
        'branch_name',
        'commercial_email',
    ];
}
