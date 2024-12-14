<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logcurrentpoints extends Model
{
    use HasFactory;

    protected $table = 'log_currentpoints';

    public function member(){
        return $this->belongsTo(Member::class, 'phone_no', 'phone_no');
    }

    protected  $fillable = [
        'id',
        'phone_no',
        'current_point',
        'admin_id',
    ];
}
