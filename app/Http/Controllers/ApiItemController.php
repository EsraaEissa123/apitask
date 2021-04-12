<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;


class ApiItemController extends Controller
{
    //
    public function store(Request $request)
    {
       

        // move 
        $img = $request->file('img');
        $ext = $img->getClientOriginalExtension();
        $name = "item-". uniqid() . ".$ext";
        $img->move( public_path('uploads/item') , $name);

        $item = Item::create([
            'brand' => $request->brand,
            'desc' => $request->desc,
            'img' => $name,
            'priceinfo' => $request->priceinfo
        ]);
        $success = "item created successfully";
        return response()->json($success);
    }

    public function update(Request $request, $id)
    {
        
    

        $item = Item::findOrFail($id);
        $name = $item->img;

        if($request->hasFile('img'))
        {
            if($name !== null) 
            {
                unlink( public_path('uploads/items/') . $name );
            }

            $img = $request->file('img');
            $ext = $img->getClientOriginalExtension();
            $name = "item-". uniqid() . ".$ext";
            $img->move( public_path('uploads/items/') , $name);
        }

        $item->update([
            'brand' => $request->brand,
            'desc' => $request->desc,
            'img' => $name,
            'priceinfo' => $request->priceinfo
        ]);

       

        $success = "item updated successfully";

        return response()->json($success);
    }

    public function delete($id)
    {
        $item = Item::findOrFail($id);

        if($item->img !== null) 
        {
            unlink( public_path('uploads/items/') . $item->img );
        }

       
        $item->delete();

        $success = "item deleted successfully";

        return response()->json($success);
    }

}
