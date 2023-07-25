<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    public $table = 'menus';

    protected $guarded = [];

    public function orderitems() 
    {
        return $this->hasMany(Orderitem::class);
    }

    public function categories() 
    {
        return $this->belongsToMany(Category::class);
    }
}
