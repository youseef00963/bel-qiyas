<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Client extends Model {
    protected $fillable = ['full_name','height','width','sleeve_length','sleeve_width','chest_circumference','waist_circumference','notes'];
    public function orders() { return $this->hasMany(Order::class); }
}