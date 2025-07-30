<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyRemark extends Model
{
    protected $fillable = [
        'warranty_registration_id',
        'remark',
        'created_by',
    ];

    public function warrantyRegistration()
    {
        return $this->belongsTo(WarrantyRegistration::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
