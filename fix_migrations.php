<?php

file_put_contents('app/Models/Client.php', <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    protected $fillable = [
        'full_name','height','width','sleeve_length',
        'sleeve_width','chest_circumference','waist_circumference','notes'
    ];
    public function orders() {
        return $this->hasMany(Order::class);
    }
}
EOT);
echo "✓ Client.php\n";

file_put_contents('app/Models/Order.php', <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        'client_id','description','total_amount',
        'paid_amount','received_date','delivery_date'
    ];
    public function client() {
        return $this->belongsTo(Client::class);
    }
    public function payments() {
        return $this->hasMany(Payment::class);
    }
    public function images() {
        return $this->hasMany(OrderImage::class);
    }
    public function getRemainingAttribute() {
        return $this->total_amount - $this->paid_amount;
    }
}
EOT);
echo "✓ Order.php\n";

file_put_contents('app/Models/Payment.php', <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    protected $fillable = ['order_id','amount','paid_at','notes'];
    public function order() {
        return $this->belongsTo(Order::class);
    }
}
EOT);
echo "✓ Payment.php\n";

file_put_contents('app/Models/OrderImage.php', <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model {
    protected $fillable = ['order_id','image_path','description'];
    public function order() {
        return $this->belongsTo(Order::class);
    }
}
EOT);
echo "✓ OrderImage.php\n";

echo "\n✅ تم إصلاح كل الـ Models!\n";