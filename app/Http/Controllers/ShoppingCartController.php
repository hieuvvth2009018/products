<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ShoppingCartController extends Controller
{
    public function add(Request $request){
        $productId = $request->get('productId');
        $productQuantity = $request->get('productQuantity');
        $action = $request->get('cartAction');
        $product = Products::find($productId);
        if ($product == null){
            return view('404');
        }
        if (Session::has('shoppingCart')){
            $shoppingCart = Session::get('shoppingCart');
        }else{
            $shoppingCart = [];
        }
        $message = 'Thêm sản phẩm vào giỏ hàng thành công!';
        $cartItem = null;
        if (!array_key_exists($productId, $shoppingCart)){
            $cartItem = new \stdClass();
            $cartItem->id = $product->id;
            $cartItem->name = $product->name;
            $cartItem->thumbnail = $product->thumbnail;
            $cartItem->unitPrice = $product->price;
            $cartItem->quantity = intval($productQuantity);
        }else{
            $cartItem = $shoppingCart[$productId];
            if ($action != null && $action == 'update'){
                $cartItem->quantity = $productQuantity;
                $message = 'update sản phẩm thành công';
            }else{
                $cartItem->quantity += $productQuantity;
            }
        }
        $shoppingCart[$productId] = $cartItem;
        Session::put('shoppingCart',$shoppingCart);
        return redirect('show')->with('message',$message);
    }
    public function show(){
        if (!Session::has('shoppingCart')){
            Session::put('shoppingCart',[]);
        }
        $shoppingCart = Session::get('shoppingCart');
        return view('cart',[
            'shoppingCart'=>$shoppingCart
        ]);
    }
    public function remove(Request $request){
        $productId = $request->get('productId');
        $shoppingCart =null;
        if (Session::has('shoppingCart')){
            $shoppingCart=Session::get('shoppingCart');
            unset($shoppingCart[$productId]);
            Session::put('shoppingCart',$shoppingCart);
            return redirect('show')->with('remove','delete thành công!');
        }
    }
    public function save(Request $request){
        if (!Session::has('shoppingCart') || count(Session::get('shoppingCart'))==0){
            Session::flash('error-msg','Hiện tại không có sản phẩm nào trong giỏ hàng!');
            return redirect('products');
        }
        $shoppingCart = Session::get('shoppingCart');
        $order = new Order();
        $order->totalPrice = 0;
        $order->customerId = 1;
        $order->shipName = $request->get('shipName');
        $order->shipPhone = $request->get('shipPhone');
        $order->shipAddress = $request->get('shipAddress');
        $order->note = $request->get('note');
        $order->isCheckout = false;
        $order->created_at = Carbon::now();
        $order->updated_at = Carbon::now();
        $order->status = 0;
        $orderDetails = [];
        $messageError = '';
        foreach ($shoppingCart as $cartItem){
            $products = Products::find($cartItem->id);
            if ($products == null){
                $messageError = 'Có lỗi xảy ra, sản phẩm với id'. $cartItem->id. 'không tồn tại hoặc đã bị xóa!';
                break;
            }
            $orderDetail = new OrderDetail();
            $orderDetail->productId = $products->id;
            $orderDetail->unitPrice = $products->price;
            $orderDetail->quantity = $cartItem->quantity;
            $order->totalPrice += $orderDetail->quantity * $orderDetail->unitPrice;
            array_push($orderDetails, $orderDetail);
        }
        if (count($orderDetails) == 0){
            Session::flash('error-msg', $messageError);
            return redirect('/list');
        }
        try {
            DB::beginTransaction();
            $order->save();
            $orderDetailArray = [];
            foreach ($orderDetails as $orderDetail){
                $orderDetail->orderId = $order->id;
                array_push($orderDetailArray, $orderDetail->toArray());
            }
            OrderDetail::insert($orderDetailArray);
            DB::commit();
            Session::forget('shoppingCart');
            Session::flash('success-msg','Lưu đơn hàng thành công!');
        }catch (\Exception $exception){
            DB::rollBack();
            return $exception;
        }
        return redirect('/list');
    }
}
