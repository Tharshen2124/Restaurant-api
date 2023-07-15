<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MenuResource;
use App\Http\Resources\V1\MenuCollection;
use App\Http\Requests\V1\StoreMenuRequest;
use App\Http\Requests\V1\UpdateMenuRequest;

class MenuController extends Controller
{
    //Display a listing of the resource.
    public function index() 
    {
        return new MenuCollection(Menu::all());
    }

    // Store a newly created resource in storage.
    public function store(StoreMenuRequest $request) 
    {
        $request->validated();
        $image_path = $request->file('image')->store('image', 'public');

        $reqCategories = explode(",", $request->categories);
        
        $menu = Menu::create([
            'menu_item' => $request->menu_item,
            'type' => $request->type,
            'image' => $image_path,
            'price' => $request->price
        ]);

        foreach(Category::all() as $category) 
        {
            foreach($reqCategories as $reqCategory)
            {
                if($reqCategory === $category->category_name) 
                {
                    $category->menus()->attach($menu->id);
                    break;
                }
            }
        }

        $menu = Menu::where('id', $menu->id)->with('categories')->firstorfail();
    
        return new MenuResource($menu);
    }

    //Display the specified resource.
    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }
    
    //Update the specified resource in storage.
    public function update(UpdateMenuRequest $request, Menu $menu) 
    {
        $data = $request->validated();
        $image_path = $request->file('image')->store('image', 'public');
        
        $menu->update([
            'menu_item' => $request->menu_item,
            'type' => $request->type,
            'image' => $image_path,
            'price' => $request->price
        ]);

        return new MenuResource($menu);
    }
    
    //Remove the specified resource from storage.
    public function destroy(Menu $menu) 
    {
        $id = $menu->id;
        $menu->delete();

        return Menu::find($id) === null ? ["message" => "menu item deleted successfully!"] : ["message" => "menu item deletion was unsuccessful"];
    }
}
