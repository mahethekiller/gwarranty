<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyRegistrationNew extends Model
{
    use HasFactory;

    protected $table = 'warranty_registrations_new';

    protected $fillable = [
        'user_id',
        'dealer_name',
        'dealer_state',
        'dealer_city',
        'invoice_number',
        'invoice_file_path',
        'status',
        'admin_remarks',
        'is_self_purchased',
        'invoice_date',
    ];

    protected $casts = [
        'is_self_purchased' => 'boolean',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
        'invoice_date'      => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'warranty_registration_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Accessors
    public function getInvoiceUrlAttribute()
    {
        return $this->invoice_file_path ? Storage::url($this->invoice_file_path) : null;
    }

    public function getIsEditableAttribute()
    {
        return $this->status === 'pending' || $this->status === 'modify';
    }

    // In WarrantyRegistration model
    public function getOverallStatusAttribute()
    {
        $productStatuses = $this->productDetails->pluck('status')->toArray();

        if (empty($productStatuses)) {
            return 'pending';
        }

        // If any product needs modification
        if (in_array('modify', $productStatuses)) {
            return 'modify';
        }

        // If any product is pending
        if (in_array('pending', $productStatuses)) {
            return 'pending';
        }

        // If all products are approved
        if (array_unique($productStatuses) === ['approved']) {
            return 'approved';
        }

        // If any product is approved (if we reach here, it means there's a mix of approved and rejected)
        if (in_array('approved', $productStatuses)) {
            return 'approved';
        }

        // If any product is rejected
        if (in_array('rejected', $productStatuses)) {
            return 'rejected';
        }

        return 'pending';
    }

    public function getCanBeEditedAttribute()
    {
        return $this->productDetails->where('status', 'modify')->count() > 0;
    }

    public function getModifiableProductsCountAttribute()
    {
        return $this->productDetails->where('status', 'modify')->count();
    }
}
