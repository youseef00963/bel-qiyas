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