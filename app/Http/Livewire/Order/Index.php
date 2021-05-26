<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use App\Models\OrderProduct;
use Livewire\Component;

class Index extends Component
{
    public $orders;
    public $selected_order;
    public $order_products = [];
    public $viewOrderProductModal;

    public function render()
    {
        $this->orders = Order::all();
        return view('livewire.order.index');
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
    }

    public function collected()
    {
        $this->selected_order->status = 3;
        $this->selected_order->save();
    }

}
