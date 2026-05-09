<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLocation;
use App\Models\BlackSpot;
use App\Models\WarningLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function sync(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'heading' => 'nullable|numeric',
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;
        $user = auth()->user();
        $userId = $user->id;
        $userName = $user->name;
        $vehicleType = $user->vehicle_type ?? 'Kendaraan Umum';

        // 1. Convert to WKT point
        $point = "POINT($lng $lat)"; 

        // 2. Optimized Upsert user location (Single Query)
        DB::statement("
            INSERT INTO user_locations (user_id, current_location, lat, lng, heading, user_name, vehicle_type, created_at, updated_at)
            VALUES (?, ST_GeogFromText(?), ?, ?, ?, ?, ?, NOW(), NOW())
            ON CONFLICT (user_id) DO UPDATE SET
                current_location = EXCLUDED.current_location,
                lat = EXCLUDED.lat,
                lng = EXCLUDED.lng,
                heading = EXCLUDED.heading,
                user_name = EXCLUDED.user_name,
                vehicle_type = EXCLUDED.vehicle_type,
                updated_at = NOW()
        ", [$userId, $point, $lat, $lng, $request->heading, $userName, $vehicleType]);

        // 3. Geofencing Check
        // ST_DWithin checks if geography points are within N meters of each other.
        $dangerSpots = DB::select("
            SELECT id, name, radius 
            FROM black_spots 
            WHERE ST_DWithin(location, ST_GeogFromText(?), radius)
        ", [$point]);

        if (count($dangerSpots) > 0) {
            foreach ($dangerSpots as $spot) {
                // To avoid spamming logs and DB queries every 5 seconds, use Caching
                $cacheKey = "warning_log_{$userId}_{$spot->id}";
                
                if (!\Illuminate\Support\Facades\Cache::has($cacheKey)) {
                    // Double check in DB just in case cache is cleared, but only if not in cache
                    $recentLog = WarningLog::where('user_id', $userId)
                        ->where('black_spot_id', $spot->id)
                        ->where('triggered_at', '>=', now()->subMinutes(2))
                        ->exists();

                    if (!$recentLog) {
                        WarningLog::create([
                            'user_id' => $userId,
                            'black_spot_id' => $spot->id,
                            'triggered_at' => now()
                        ]);
                    }
                    
                    // Cache the triggered state for 2 minutes to prevent any DB hit for this user/spot
                    \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->addMinutes(2));
                }
            }

            return response()->json([
                'status' => 'warning',
                'spots' => $dangerSpots,
                'message' => 'LOKASI BERBAHAYA! Kurangi kecepatan!'
            ]);
        }

        return response()->json([
            'status' => 'safe',
            'message' => 'Anda berada di rute aman.'
        ]);
    }
}
