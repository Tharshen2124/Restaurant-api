<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MenuResource;
use App\Http\Resources\V1\MenuCollection;
use App\Http\Requests\V1\StoreMenuRequest;
use App\Http\Requests\V1\UpdateMenuRequest;

class MenuController extends Controller
{
    //Display a listing of the resource.
    public function index() {
        return new MenuCollection(Menu::paginate());
    }

    //Store a newly created resource in storage.
    public function store(StoreMenuRequest $request) {
        return new MenuResource(Menu::create($request->all()));
    }

    //Display the specified resource.
    public function show(Menu $menu){
        return new MenuResource($menu);
    }
    
    //Update the specified resource in storage.
    public function update(UpdateMenuRequest $request, Menu $menu) {
        $menu->update($request->all());
    }
    
    //Remove the specified resource from storage.
    public function destroy(Menu $menu) {
        $id = $menu->id;
        $menu->delete();

        return Menu::find($id) === null ? ["message" => "menu item deleted successfully!"] : ["message" => "menu item deletion was unsuccessful"];
    }
}
