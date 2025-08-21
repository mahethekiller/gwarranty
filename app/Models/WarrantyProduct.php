<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'warranty_registration_id',
        'product_type',
        'qty_purchased',
        'application_type',
        'handover_certificate',
        'remarks',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_issuance' => 'date',
        'invoice_date'     => 'date',
        'handover_certificate_date' => 'date',
        'products_json' => 'array',
        'products_jsonFloor' => 'array',
    ];
    /**
     * A warranty product belongs to a registration.
     */
    public function registration()
    {
        return $this->belongsTo(WarrantyRegistration::class, 'warranty_registration_id');
    }



    /**
     * A warranty product belongs to a product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_type', 'id');
    }
}
