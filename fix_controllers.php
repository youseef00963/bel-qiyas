<?php

// ===== Models =====
file_put_contents('app/Models/Client.php', <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Client extends Model {
    protected $fillable = ['full_name','height','width','sleeve_length','sleeve_width','chest_circumference','waist_circumference','notes'];
    public function orders() { return $this->hasMany(Order::class); }
}
EOT);
echo "✓ Client.php\n";

file_put_contents('app/Models/Order.php', <<<'EOT'
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
EOT);
echo "✓ Order.php\n";

file_put_contents('app/Models/Payment.php', <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
    protected $fillable = ['order_id','amount','paid_at','notes'];
    public function order() { return $this->belongsTo(Order::class); }
}
EOT);
echo "✓ Payment.php\n";

file_put_contents('app/Models/OrderImage.php', <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class OrderImage extends Model {
    protected $fillable = ['order_id','image_path','description'];
    public function order() { return $this->belongsTo(Order::class); }
}
EOT);
echo "✓ OrderImage.php\n";

// ===== Controllers =====
file_put_contents('app/Http/Controllers/AuthController.php', <<<'EOT'
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Order;
class AuthController extends Controller {
    public function showLogin() {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }
    public function login(Request $request) {
        $credentials = $request->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::attempt($credentials, $request->remember)) return redirect()->route('dashboard');
        return back()->withErrors(['email'=>'البريد الإلكتروني أو كلمة المرور غلط']);
    }
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
    public function dashboard() {
        $totalDebt = Order::selectRaw('SUM(total_amount - paid_amount) as debt')->value('debt') ?? 0;
        $priorityClients = Client::whereHas('orders', function($q) {
            $q->whereNull('delivery_date')->orWhere('delivery_date','>=',now());
        })->with(['orders'=>function($q){ $q->orderBy('delivery_date'); }])
        ->get()->sortBy(fn($c)=>optional($c->orders->first())->delivery_date);
        return view('dashboard', compact('totalDebt','priorityClients'));
    }
}
EOT);
echo "✓ AuthController.php\n";

file_put_contents('app/Http/Controllers/ClientController.php', <<<'EOT'
<?php
namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;
class ClientController extends Controller {
    public function index() {
        $clients = Client::latest()->get();
        return view('clients.index', compact('clients'));
    }
    public function create() {
        return view('clients.create');
    }
    public function store(Request $request) {
        $data = $request->validate([
            'full_name'=>'required|string','height'=>'nullable|numeric',
            'width'=>'nullable|numeric','sleeve_length'=>'nullable|numeric',
            'sleeve_width'=>'nullable|numeric','chest_circumference'=>'nullable|numeric',
            'waist_circumference'=>'nullable|numeric','notes'=>'nullable|string',
        ]);
        $client = Client::create($data);
        return redirect()->route('clients.show', $client);
    }
    public function show(Client $client) {
        $client->load(['orders.payments','orders.images']);
        return view('clients.show', compact('client'));
    }
    public function update(Request $request, Client $client) {
        $data = $request->validate([
            'full_name'=>'required|string','height'=>'nullable|numeric',
            'width'=>'nullable|numeric','sleeve_length'=>'nullable|numeric',
            'sleeve_width'=>'nullable|numeric','chest_circumference'=>'nullable|numeric',
            'waist_circumference'=>'nullable|numeric','notes'=>'nullable|string',
        ]);
        $client->update($data);
        return back()->with('success','تم التحديث بنجاح');
    }
}
EOT);
echo "✓ ClientController.php\n";

file_put_contents('app/Http/Controllers/OrderController.php', <<<'EOT'
<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderImage;
use Illuminate\Http\Request;
class OrderController extends Controller {
    public function store(Request $request) {
        $data = $request->validate([
            'client_id'=>'required|exists:clients,id','description'=>'nullable|string',
            'total_amount'=>'nullable|numeric','received_date'=>'nullable|date',
            'delivery_date'=>'nullable|date',
        ]);
        Order::create($data);
        return back()->with('success','تم إضافة الطلب');
    }
    public function update(Request $request, Order $order) {
        $data = $request->validate([
            'description'=>'nullable|string','total_amount'=>'nullable|numeric',
            'received_date'=>'nullable|date','delivery_date'=>'nullable|date',
        ]);
        $order->update($data);
        return back()->with('success','تم التحديث');
    }
    public function uploadImage(Request $request, Order $order) {
        $request->validate(['image'=>'required|image|max:5120','description'=>'nullable|string']);
        $path = $request->file('image')->store('orders','public');
        OrderImage::create(['order_id'=>$order->id,'image_path'=>$path,'description'=>$request->description]);
        return back()->with('success','تم رفع الصورة');
    }
}
EOT);
echo "✓ OrderController.php\n";

file_put_contents('app/Http/Controllers/PaymentController.php', <<<'EOT'
<?php
namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
class PaymentController extends Controller {
    public function index(Request $request) {
        $clients = Client::all();
        $selectedClient = null;
        $orders = collect();
        if ($request->client_id) {
            $selectedClient = Client::findOrFail($request->client_id);
            $orders = $selectedClient->orders()->with('payments')->get();
        }
        return view('payments.index', compact('clients','selectedClient','orders'));
    }
    public function store(Request $request) {
        $data = $request->validate(['order_id'=>'required|exists:orders,id','amount'=>'required|numeric|min:1','notes'=>'nullable|string']);
        Payment::create($data);
        $order = Order::findOrFail($data['order_id']);
        $order->paid_amount += $data['amount'];
        $order->save();
        return back()->with('success','تم تسجيل الدفعة');
    }
}
EOT);
echo "✓ PaymentController.php\n";

echo "\n✅ تم إصلاح كل الـ Models والـ Controllers!\n";

$files = [
    'app/Models/Client.php',
    'app/Models/Order.php',
    'app/Models/Payment.php',
    'app/Models/OrderImage.php',
    'app/Http/Controllers/AuthController.php',
    'app/Http/Controllers/ClientController.php',
    'app/Http/Controllers/OrderController.php',
    'app/Http/Controllers/PaymentController.php',
];
foreach ($files as $f) {
    echo "  " . filesize($f) . " bytes → " . $f . "\n";
}