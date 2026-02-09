<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'fields', 'sort_order', 'is_active'];

    protected $casts = [
        'fields' => 'array',
        'is_active' => 'boolean'
    ];

    public function variants()
    {
        return $this->hasMany(ProductTypeVariant::class);
    }
}
