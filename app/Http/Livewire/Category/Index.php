<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Livewire\Component;

class Index extends Component
{
    public bool $createCategoryModal;
    public bool $editCategoryModal;
    public bool $deleteCategoryModal;

    public $name;
    public $categories;

    public $selected_category;

    protected $rules = [
        'selected_category.name' => ['required'],
    ];

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.category.index');
    }

    public function create()
    {
        $this->createCategoryModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => ['required'],
        ]);

        $category = new Category();
        $category->name = $this->name;
        if ($category->save()) {
            $this->createCategoryModal = false;
            $this->name = '';
        }
    }

    public function editCategory($category_id)
    {
        $this->selected_category = Category::find($category_id);
        $this->editCategoryModal = true;
    }

    public function update()
    {
        $this->validate();
        $this->selected_category->save();
        $this->editCategoryModal = false;
    }

    public function deleteCategory($category_id)
    {
        $this->selected_category = Category::find($category_id);
        $this->deleteCategoryModal = true;
    }

    public function proceedToDelete()
    {
        $this->selected_category->delete();
        $this->deleteCategoryModal = false;
    }
}
