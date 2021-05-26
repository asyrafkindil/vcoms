<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::orderBy('category_id')->get();
        return $products->toJson();
    }

    public function getCategories()
    {
        $categories = Category::orderBy('name')->get();
        return $categories->toJson();
    }

    public function getBranches()
    {
        $branches = Branch::orderBy('name')->get();
        return $branches->toJson();
    }

    public function orderConfirmed(Request $request)
    {
        $this->validate($request, [
            'total' => 'required',
            'carts' => 'required|json',
            'notes' => 'nullable|string',
            'branch_id' => 'required',
            'phone' => 'required|string'
        ]);

        $user = $request->user();
        $carts = json_decode($request->carts, true);

        if ($request->phone) {
            $user->phone = $request->phone;
            $user->save();
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->sub_total = 0;
        $order->tax = 0;
        $order->total = 0;
        $order->discount = 0;
        $order->grand_total = $request->total;
        $order->status = 1;
        $order->branch_id = $request->branch_id;
        $order->note = $request->notes;
        $order->phone = $request->phone;
        $order->save();

        foreach ($carts as $cart) {
            $order_product = new OrderProduct();
            $order_product->order_id = $order->id;
            $order_product->product_id = $cart['product_id'];
            $order_product->quantity = $cart['quantity'];
            $order_product->price = $cart['price'];
            $order_product->save();
        }

        return response()->json([
            'success' => 1,
        ]);
    }

    public function getOrderHistories(Request $request)
    {
        $user = $request->user();
        $orders = Order::with('products')->where('user_id', $user->id)->get();
        return $orders->toJson();
    }
}
