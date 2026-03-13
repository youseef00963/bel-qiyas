<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
    protected $fillable = ['client_id','description','total_amount','paid_amount','received_date','delivery_date'];
    public function client() { return $this->belongsTo(Client::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function images() { return $this->hasMany(OrderImage::class); }
    public function getRemainingAttribute() { return $this->total_amount - $this->paid_amount; }
}