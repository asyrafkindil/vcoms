<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['price', 'quantity']);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getStatusDescription()
    {
        switch ($this->status) {
            case 1:
                return 'Pending';
            case 2:
                return 'Ready to Pickup';
            case 3:
                return 'Collected by customer';
            default:
                return '';
        }
    }
}
