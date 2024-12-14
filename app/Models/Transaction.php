<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'barcode', 'barcode');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'phone_no', 'phone_no');
    }

    protected  $fillable = [
        'machine_id',
        'phone_no',
        'barcode',
        'time_taken',
        'time_sync',
        'image64',
        'flag',
    ];
}
