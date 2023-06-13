<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orderitem extends Model
{
    use HasFactory;

    // this might break something so in case, just remove it cause it wasnt needed for the 
    protected $guarded = [];
    
    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
