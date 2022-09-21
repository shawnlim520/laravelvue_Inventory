<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use DB;
use DateTime;
Use App\Models\Order;
Use App\Models\Expense;
use App\Models\OrderDetails;
class OrderController extends Controller
{
    public function TodayOrder(){
        $data = date('d/m/Y');
        $order = DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->where('order_date',$data)
            ->select('customers.name','orders.*')
            ->orderBy('orders.id','DESC')
            ->get();

        return response()->json($order);
    }

    public function OrderDetails($id){
        $order = DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->where('orders.id',$id)
            ->select('customers.name','customers.email','customers.phone','customers.address','orders.*')
            ->first();
        
        return response()->json($order);
    }

    public function OrderDetailsAll($id){
        $details = DB::table('order_details')
            ->join('products','order_details.product_id','products.id')
            ->where('order_details.order_id',$id)
            ->select('products.product_name','products.product_code','products.image','order_details.*')
            ->get();
        
        return response()->json($details);
    }

    public function SearchOrderDate(Request $request){
        $orderdate = $request->date;

        $newdate = new DateTime($orderdate);
        $done = $newdate->format('d/m/Y');
        $order = DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->select('customers.name','orders.*')
            ->where('orders.order_date',$done)
            ->get();

        return response()->json($order);
    }

    public function TodaySell(){
        $date = date('d/m/Y');
        $sell = Order::where('order_date',$date)->sum('total');

        return response()->json($sell);
    }

    public function TodayIncome(){
        $date = date('d/m/Y');
        $income = Order::where('order_date',$date)->sum('pay');

        return response()->json($income);
    }

    public function TodayDue(){
        $date = date('d/m/Y');
        $due = Order::where('order_date',$date)->sum('due');

        return response()->json($due);
    }

    public function TodayExpense(){
        $date = date('d/m/Y');
        $due = Expense::where('expense_date',$date)->sum('amount');

        return response()->json($due);
    }
}
