<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class OrderImage extends Model {
    protected $fillable = ['order_id','image_path','description'];
    public function order() { return $this->belongsTo(Order::class); }
}