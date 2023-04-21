<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/* use App\Http\Resources\MenuResource; */
use App\Http\Resources\V1\MenuResource;
use App\Http\Resources\V1\MenuCollection;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Menu $menu)
    {
        //
        return new MenuCollection(Menu::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
