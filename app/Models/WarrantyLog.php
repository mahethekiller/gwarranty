<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyLog extends Model
{
    protected $fillable = [
        'warranty_id',
        'field',
        'old_value',
        'new_value',
        'updated_by',
        'product_type',
    ];

    public function warranty()
    {
        return $this->belongsTo(WarrantyRegistration::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_type', 'id')->select('id', 'name');
    }
}
