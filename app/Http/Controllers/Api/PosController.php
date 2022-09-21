<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pos;
class PosController extends Controller
{
    public function GetProduct($id){
        $product = Product::where('category_id',$id)->get();

        return response()->json($product);

    }

    public function OrderDone(Request $request)
    {
        $validatedata = $request->validate([
            'customer_id' => 'required',
            'payby' => 'required',
        ]);
        $order = new Order();
        
        $order->customer_id = $request->customer_id;
        $order->qty = $request->qty;
        $order->sub_total = $request->subtotal;
        $order->vat = $request->vat;
        $order->total = $request->total;
        $order->pay = $request->pay;
        $order->due = $request->due;
        $order->payby = $request->payby;
        $order->order_date = date('d/m/Y');
        $order->order_month = date('F');
        $order->order_year = date('Y');
        $order->save();

        $contents = Pos::all();

        foreach ($contents as $item) {
            $orderdetail = new OrderDetail();
            $orderdetail->order_id = $order->id;
            $orderdetail->product_id = $item->pro_id;
            $orderdetail->pro_quantity = $item->pro_quantity;
            $orderdetail->product_price = $item->product_price;
            $orderdetail->sub_total = $item->sub_total;
            $orderdetail->save();

            $product = Product::findOrFail($item->pro_id);
            $product->product_quantity = $product->product_quantity - $item->pro_quantity;
            $product->save();

            $item->delete();
        }
        return response('Done');
        
    }
}
