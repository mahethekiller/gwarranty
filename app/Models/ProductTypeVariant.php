<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTypeVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_type_id',
        'variant_name',
        'warranty_period',
        'usage_type',
        'additional_data',
        'is_active'
    ];

    protected $casts = [
        'additional_data' => 'array',
        'is_active' => 'boolean'
    ];

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}
