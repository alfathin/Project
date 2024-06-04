<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'unique:users'],
            'username' => ['required', 'unique:users'],
            'name' => 'required',
            'password' => 'required'
        ]);

        if ($data) {
            $user = new User();
            $user->email = $request->email;
            $user->username = $request->username;
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->image = 'img/profile.png';
            $user->role_id = 1;
    
            $user->save();

            return response()->json([
                'status' => true,
                'message' => "Berhasil Registrasi",
                'data' => $user
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Gagal Registrasi!'
        ], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request) {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt($data)) {
            $user = Auth::user();
            if ($user->role_id == 1) {
                return response()->json([
                    'status' => true,
                    'message' => "Sebagai Costumer",
                    'data' => $user
                ], 200);
            } elseif ($user->role_id == 2) {
                return response()->json([
                    'status' => true,
                    'message' => "Sebagai Admin",
                    'data' => $user
                ], 200);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'Username atau Password Salah!'
        ], 401);
    }

}
