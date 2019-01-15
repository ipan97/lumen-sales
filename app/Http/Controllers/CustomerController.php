<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::paginate(20);
        return $this->ok('Get customers success', $customers);
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
            'name' => 'required',
            'email' => 'required|unique:customers',
            'address' => 'required',
            'status' => 'required',
        ]);
        $customer = new Customer([
            'name' => $request['name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'status' => $request['status'],
        ]);
        $customer->save();
        return $this->created('Create customer success', $customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return $this->badRequest('Customer id ' . $id . ' not found');
        }
        return $this->ok('Get customer by id success', $customer);
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
        $customer = Customer::find($id);
        if (!$customer) {
            return $this->badRequest('Customer id ' . $id . ' not found');
        }
        $customer->fill($request->all());
        $customer->save();
        return $this->ok('Update customer success', $customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return $this->badRequest('Customer id ' . $id . ' not found');
        }
        $customer->delete();
        return $this->ok('Delete customer success');
    }
}
