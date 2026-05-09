<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlackSpot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Get all black spots to draw on map
    public function getBlackSpots()
    {
        // ST_AsGeoJSON works seamlessly for Point, LineString, Polygon
        $spots = DB::select("SELECT id, name, radius, ST_AsGeoJSON(location) as geojson FROM black_spots");
        return response()->json($spots);
    }

    // Create a black spot from map click/draw
    public function storeBlackSpot(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'geojson' => 'required|string', // Stringified GeoJSON geometry
            'radius' => 'required|integer|min:10',
        ]);

        DB::statement("INSERT INTO black_spots (name, location, radius, created_at, updated_at) VALUES (?, ST_GeomFromGeoJSON(?)::geography, ?, NOW(), NOW())", [
            $request->name,
            $request->geojson,
            $request->radius
        ]);

        return response()->json(['status' => 'success', 'message' => 'Black spot berhasil ditambahkan']);
    }

    // Delete black spot
    public function deleteBlackSpot($id)
    {
        BlackSpot::findOrFail($id)->delete();
        return response()->json(['status' => 'success']);
    }
}
