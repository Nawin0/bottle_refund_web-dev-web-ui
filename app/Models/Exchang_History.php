<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchang_History extends Model
{
    use HasFactory;

    protected $table = 'exchange_history';

    public $timestamps = false;

    public function member(){
        return $this->belongsTo(Member::class, 'phone_no', 'phone_no');
    }

    public function addr(){
        return $this->belongsTo(Address::class, 'address', 'id');
    }

    public function rewarditem(){
        return $this->belongsTo(RewardItem::class,'product_code', 'product_code');
    }

    protected $fillable = [
        'phone_no',
        'product_code',
        'product_reward',
        'point',
        'image64',
        'quantity',
        'address',
        'status',
    ];
}
