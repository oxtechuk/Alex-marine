<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_number',
        'user_id',
        'branch_id',
        'customer_name',
        'company_name',
        'email',
        'phone',
        'status',
        'total_estimated',
        'notes',
        'admin_notes',
        'pdf_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public static function generateQuoteNumber(): string
    {
        $year = date('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;

        return sprintf('RFQ-%s-%04d', $year, $count);
    }
}
