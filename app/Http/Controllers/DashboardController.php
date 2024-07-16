<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function getUserList()
    {
        $userList = \App\Models\UserList::all();

        return view('pages.tables', [
            'userList' => $userList,
        ]);
    }

    public function addUser()
    {

        $userList = \App\Models\UserList::all();

        return view('pages.tables', [
            'userList' => $userList,
        ]);
    }

    public function addUserPost(Request $request) {
        var_dump($request->all()); die();
        return response()->json($request->all());
    }
}
