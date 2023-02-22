<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseOrderLine;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    public function getProductList()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', ["products" => $products]);
    }
    public function getProductShow($id)
    {
        return view('admin.products.index');
    }
    public function getProductEdit($id)
    {
        return view('admin.products.index');
    }
    public function getProductDestroy($id)
    {
        return view('admin.products.index');
    }
    public function getPurchaseOrderLineList()
    {
        $purchaseOrderLines = PurchaseOrderLine::paginate(10);
        return view('admin.purchaseOrderLines.index', ["purchaseOrderLines" => $purchaseOrderLines]);
    }
    public function getPurchaseOrderLineCreate()
    {
        $products = Product::all();
        return view('admin.purchaseOrderLines.create', ["products" => $products]);
    }
    public function postPurchaseOrderLineInsert(Request $request, PurchaseOrderLine $purchaseOrderLine)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'discount' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        $purchaseOrderLine->product_id = $request->post('product');
        $purchaseOrderLine->qty = $request->post('qty');
        $purchaseOrderLine->price = $request->post('price');
        $purchaseOrderLine->discount = $request->post('discount');
        $purchaseOrderLine->total = (int)$request->post('qty') * ((100 - (int)$request->post('discount')) / 100) * (int)$request->post('price');
        $purchaseOrderLine->created_at = new DateTime();
        $purchaseOrderLine->updated_at = new DateTime();
        $purchaseOrderLine->save();

        return redirect()->intended(route('admin.purchase.order.lines'));
    }
    public function getPurchaseOrderLineShow($id)
    {
        return view('admin.purchaseOrderLines.index');
    }
    public function getPurchaseOrderLineEdit($id)
    {
        return view('admin.purchaseOrderLines.index');
    }
    public function getPurchaseOrderLineDestroy($id)
    {
        return view('admin.purchaseOrderLines.index');
    }
}
