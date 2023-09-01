<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use App\Models\Orderitem;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\MenuResource;
use App\Http\Resources\V1\OrderResource;
use App\Http\Requests\V1\StoreMenuRequest;
use App\Http\Requests\V1\UpdateMenuRequest;

class MenuController extends Controller
{
    use HttpResponses;
 /*  $orderitems = $order->orderitems ?? null; */
    //Display a listing of the resource.
    public function index(Request $request) 
    {
        if(Auth::check()) {
            $order = Order::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->with('orderitems.menu')
                    ->firstorfail(); 
            $orderitems = $order->orderitems ?? null;
        } else {
            $orderitems = [];
        }

       return response()->json([
        'message' => 'success',
        'data' => MenuResource::collection(Menu::all()),
        'orderitems' => $orderitems,
       ], 200);
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
                    // Attach the menu to the category
                     $category->menus()->attach($menu->id);
                    break;
                }
            }
        }

        $menu = Menu::where('id', $menu->id)->with('categories')->firstorfail();
    
        return response()->json([
            "data" => new MenuResource($menu)
        ],201);
    }

    //Display the specified resource.
    public function show(Menu $menu)
    {   
        return response()->json([
            'data' => new MenuResource($menu),
        ], 200); 
    }
    
    //Update the specified resource in storage.
    public function update(UpdateMenuRequest $request, Menu $menu) 
    {
        $request->validated();
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
