<?php

namespace App\Http\Livewire\Branch;

use Livewire\Component;
use App\Models\Branch;

class Index extends Component
{
    public bool $createBranchModal;
    public bool $editBranchModal;
    public bool $deleteBranchModal;

    public $name;
    public $branches;

    public $selected_branch;

    protected $rules = [
        'selected_branch.name' => ['required'],
    ];

    public function render()
    {
        $this->branches = Branch::all();
        return view('livewire.branch.index');
    }

    public function create()
    {
        $this->createBranchModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => ['required'],
        ]);

        $branch = new Branch();
        $branch->name = $this->name;
        if ($branch->save()) {
            $this->name = '';
            $this->createBranchModal = false;
        }
    }

    public function editBranch($branch_id)
    {
        $this->selected_branch = Branch::find($branch_id);
        $this->editBranchModal = true;
    }

    public function update()
    {
        $this->validate();
        $this->selected_branch->save();
        $this->editBranchModal = false;
    }

    public function deleteBranch($branch_id)
    {
        $this->selected_branch = Branch::find($branch_id);
        $this->deleteBranchModal = true;
    }

    public function proceedToDelete()
    {
        $this->selected_branch->delete();
        $this->deleteBranchModal = false;
    }
}
