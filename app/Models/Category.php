<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function menus() 
    {
        return $this->belongsToMany(Menu::class);
    }
}
