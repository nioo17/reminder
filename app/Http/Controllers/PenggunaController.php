<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    public function store(Request $request)
    {
        $empData = [
            'name' => $request->name,
            'email' => $request->email,
            'id_telegram' => $request->address,
        ];
        Pengguna::create($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    public function getall()
    {
        $Penggunas = Pengguna::all();
        return response()->json([
            'status' => 200,
            'Penggunas' => $Penggunas
        ]);
    }

    public function edit($id)
    {
        $Pengguna = Pengguna::find($id);
        if ($Pengguna) {
            return response()->json([
                'status' => 200,
                'Pengguna' => $Pengguna
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Pengguna not found'
            ]);
        }
    }

    public function update(Request $request)
    {
        $Pengguna = Pengguna::find($request->id);
        if ($Pengguna) {
            $Pengguna->name = $request->name;
            $Pengguna->email = $request->email;
            $Pengguna->address = $request->address;
            $Pengguna->phone = $request->phone;
            $Pengguna->save();
            return response()->json([
                'status' => 200,
                'message' => 'Pengguna updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Pengguna not found'
            ]);
        }
    }

    public function delete(Request $request)
    {
        $Pengguna = Pengguna::find($request->id);
        if ($Pengguna && $Pengguna->delete()) {
            return response()->json(['status' => 200, 'message' => 'Pengguna deleted successfully.']);
        } else {
            return response()->json(['status' => 400, 'message' => 'Failed to delete Pengguna.']);
        }
    }

}