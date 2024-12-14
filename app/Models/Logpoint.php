<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logpoint extends Model
{
    use HasFactory;

    protected $table = 'log_points';

    public $timestamps = false;

    public function member(){
        return $this->belongsTo(Member::class, 'phone_no', 'phone_no');
    }

    protected $fillable = [
        'phone_no',
        'barcode',
        'point',
    ];
}
