<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::paginate(20);
        return $this->ok($admins);
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
            'password' => 'required',
        ]);
        $admin = new Admin([
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
        ]);
        $admin->save();
        return $this->created('Create admin success', $admin);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return $this->badRequest('Admin id ' . $id . ' not found');
        }
        return $this->ok('Get admin by id success', $admin);
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
        $admin = Admin::find($id);
        if (!$admin) {
            return $this->badRequest('Admin id ' . $id . ' not found');
        }
        $admin->fill($request->all());
        $admin->save();
        return $this->ok('Update admin success', $admin);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return $this->badRequest('Admin id ' . $id . ' not found');
        }
        $admin->delete();
        return $this->ok('Delete admin success');
    }
}
