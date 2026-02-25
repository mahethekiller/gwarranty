<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'warranty_registration_id',
        'product_type_id',
        'variant_id',
        'variant',
        'product_name_design',
        'product_category',
        'no_of_boxes',
        'quantity',
        'area_sqft',
        'handover_certificate',
        'invoice_number',
        'invoice_date',
        'uom',
        'site_address',
        'product_thickness',
        'status',
        'admin_remarks'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'no_of_boxes' => 'integer',
        'quantity' => 'integer',
        'area_sqft' => 'decimal:2'
    ];

    // Relationships
    public function warrantyRegistration()
    {
        return $this->belongsTo(WarrantyRegistrationNew::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductTypeVariant::class);
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

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeModify($query)
    {
        return $query->where('status', 'modify');
    }

    public function scopeEditable($query)
    {
        return $query->where('status', 'modify');
    }

    // Status helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isModify()
    {
        return $this->status === 'modify';
    }

    public function isEditable()
    {
        return $this->isModify();
    }

    // Get status badge HTML
    public function getStatusBadgeAttribute()
    {
        $badgeClasses = [
            'pending' => 'bg-warning',
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            'modify' => 'bg-primary'
        ];

        $statusLabels = [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'modify' => 'Modify Required'
        ];

        return '<span class="badge ' . ($badgeClasses[$this->status] ?? 'bg-secondary') . '">' .
               ($statusLabels[$this->status] ?? ucfirst($this->status)) . '</span>';
    }
}
