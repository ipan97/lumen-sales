<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bill::paginate(20);
        return $this->ok('Get bills success', $bills);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'transaction_date' => 'required',
            'total' => 'total',
            'product_id' => 'required',
            'customer_id' => 'required',
            'admin_id' => 'required',
        ]);

        $input = $request->all();
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($input['product_id']);
            $customer = Customer::findOrFail($input['customer_id']);
            $admin = Admin::findOrFail($input['admin_id']);

            $bill = new Bill();
            $bill->transaction_date = $input['transaction_date'];
            $bill->total = $input['total'];

            $bill->product()->associate($product);
            $bill->customer()->associate($customer);
            $bill->admin()->associate($admin);
            $bill->save();

            return $this->ok('Create bill success', $bill);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Bill::findOrFail($id);
        return $this->ok('Get bill by id success', $bill);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($input['product_id']);
            $customer = Customer::findOrFail($input['customer_id']);
            $admin = Admin::findOrFail($input['admin_id']);

            $bill = new Bill();
            $bill->transaction_date = $input['transaction_date'];
            $bill->total = $input['total'];

            $bill->product()->associate($product);
            $bill->customer()->associate($customer);
            $bill->admin()->associate($admin);
            $bill->save();

            return $this->ok('Create bill success', $bill);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->internalServerError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);
        $bill->delete();
        return $this->ok('Delete bill by id success', $bill);
    }
}
