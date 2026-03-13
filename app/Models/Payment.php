<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
    protected $fillable = ['order_id','amount','paid_at','notes'];
    public function order() { return $this->belongsTo(Order::class); }
}