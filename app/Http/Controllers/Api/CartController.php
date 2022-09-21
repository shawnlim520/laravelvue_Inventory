<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pos;
use App\Models\Product;
use App\Models\Vat;
class CartController extends Controller
{
    public function AddToCart($id){
        $product = Product::findOrFail($id);

        $pos = new Pos();
        $check = Pos::where('pro_id',$id)->first();
        if ($check) {
            $check->increment('pro_quantity');
            // $check->pro_quantity = $check->pro_quantity + 1;
            $check->sub_total = $check->product_price * $check->pro_quantity;

            $check->save();
        }
        else
        {
            $pos->pro_id = $id;
            $pos->pro_name = $product->product_name;
            $pos->pro_quantity = 1;
            $pos->product_price = $product->selling_price;
            $pos->sub_total = $product->selling_price;
            $pos->save();

        }
    }

    public function CartProduct(){
        $cart = Pos::all();

        return response()->json($cart);
    }

    public function RemoveCart($id){
        $cart = Pos::findOrFail($id);

        $cart->delete();
    }

    public function AddCart($id){
        $pos = Pos::findOrFail($id);
        $pos->increment('pro_quantity');
        //$pos->pro_quantity = $pos->pro_quantity + 1;
        $pos->sub_total = $pos->product_price * $pos->pro_quantity;
        $pos->save();
    }

    public function MinusCart($id){
        $pos = Pos::findOrFail($id);
        if ($pos->pro_quantity == 1) {
            $pos->delete();
            return response('Item Deleted');
        }
        else{
            $pos->decrement('pro_quantity');
            // $pos->pro_quantity = $pos->pro_quantity - 1;
            $pos->sub_total = $pos->product_price * $pos->pro_quantity;
            $pos->save();
        }

    }

    public function Vats(){
        $vat = Vat::first();

        return response()->json($vat);
    }
}
