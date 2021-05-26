<?php

namespace App\Http\Livewire\Product;

use App\Models\Category;
use App\Models\OrderProduct;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public bool $createProductModal;
    public bool $editProductModal;
    public bool $deleteProductModal;
    public bool $alertModal;

    public $message;

    public $name;
    public $description;
    public $price;
    public $file;
    public $category_id;

    public $productToEdit;
    public $products;
    public $categories;

    public function rules()
    {
        return [
            'productToEdit.name' => ['required'],
            'productToEdit.description' => ['nullable'],
            'productToEdit.price' => ['required', 'numeric'],
            'productToEdit.category_id' => ['required', 'integer'],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $this->categories = Category::all();
        $this->products = Product::all();
        return view('livewire.product.index');
    }

    public function create()
    {
        $this->createProductModal = true;
    }

    public function edit($product_id)
    {
        $this->productToEdit = Product::find($product_id);
        $this->editProductModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => ['required'],
            'description' => ['nullable'],
            'price' => ['required', 'numeric'],
            'category_id' => ['required', 'integer'],
            'file' => ['nullable', 'image', 'max:4096', 'mimes:jpeg,png'],
        ]);

        $file_path = '';
        if ($this->file) {
            $file_path = $this->file->storePublicly('products', 'public');
        }

        $product = new Product();
        $product->name = $this->name;
        $product->description = $this->description;
        $product->price = $this->price;
        $product->photo_path = $file_path;
        $product->category_id = $this->category_id;

        if ($product->save()) {
            $this->createProductModal = false;
            $this->name = '';
            $this->description = '';
            $this->price = '';
            $this->file = '';
            $this->category_id = '';
        }
    }

    public function update()
    {
        $this->validate([
            'productToEdit.name' => ['required'],
            'productToEdit.description' => ['nullable'],
            'productToEdit.price' => ['required', 'numeric'],
            'productToEdit.category_id' => ['required', 'integer'],
            'file' => ['nullable', 'image', 'max:4096', 'mimes:jpeg,png'],
        ]);

        if ($this->file) {
            $file_path = $this->file->storePublicly('products', 'public');
            $this->productToEdit->photo_path = $file_path;
        }

        if ($this->productToEdit->save()) {
            $this->editProductModal = false;
            $this->productToEdit = null;
            $this->file = '';
        }
    }

    public function deleteProduct($product_id)
    {
        $this->productToEdit = Product::find($product_id);
        $order_count = OrderProduct::where('product_id', $product_id)->count();
        if ($order_count > 0) {
            $this->alertModal = true;
            $this->message = 'Product you want to delete is used in customer order database. To properly delete the product you need to clear the order first. This is to avoid any data losses.';
        } else {
            $this->deleteProductModal = true;
        }
    }

    public function proceedToDelete()
    {
        $this->productToEdit->delete();
        $this->deleteProductModal = false;
    }
}
