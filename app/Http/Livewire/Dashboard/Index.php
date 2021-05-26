<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public $pending_orders;

    public $orders;
    public $products;

    public $viewOrderProductModal;
    public $order_products = [];
    public $selected_order;

    public function mount()
    {
        $this->pending_orders = Order::where('status', 1)->orderBy('created_at', 'desc')->get();
        $this->orders = Order::all();
        $this->products = Product::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.dashboard.index');
    }

    public function viewProducts($order_id)
    {
        $this->selected_order = Order::find($order_id);
        $this->order_products = OrderProduct::where('order_id', $order_id)->get();
        $this->viewOrderProductModal = true;
    }

    public function ready()
    {
        $this->selected_order->status = 2;
        $this->selected_order->save();
        $this->pending_orders = Order::where('status', 1)->orderBy('created_at', 'desc')->get();
    }

    public function collected()
    {
        $this->selected_order->status = 3;
        $this->selected_order->save();
        $this->pending_orders = Order::where('status', 1)->orderBy('created_at', 'desc')->get();
    }
}
