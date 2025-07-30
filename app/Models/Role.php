<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name', 'display_name'];

    public function getDisplayNameAttribute()
    {
        return $this->attributes['display_name'] ?? ucfirst(str_replace('_', ' ', $this->name));
    }
}
