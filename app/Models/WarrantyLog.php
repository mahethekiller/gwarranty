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
}
