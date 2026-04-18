<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SensorReading;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    // ESP32 calls this to POST sensor data
    public function store(Request $request)
    {
        $payload = $request->validate([
            'ph_level'  => 'sometimes|numeric',
            'turbidity' => 'sometimes|numeric',
            'tds'       => 'sometimes|numeric',
        ]);

        if (empty($payload)) {
            return response()->json([
                'success' => false,
                'message' => 'At least one sensor value is required.',
            ], 422);
        }

        $latest = SensorReading::latest()->first();

        // Determine water quality status
        $ph  = isset($payload['ph_level']) ? (float) $payload['ph_level'] : (float) ($latest?->ph_level ?? 0);
        $tds = isset($payload['tds']) ? (float) $payload['tds'] : (float) ($latest?->tds ?? 0);
        $ntu = isset($payload['turbidity']) ? (float) $payload['turbidity'] : (float) ($latest?->turbidity ?? 0);

        $status = 'normal';
        if ($ph < 6.5 || $ph > 8.5 || $tds > 500 || $ntu > 4) {
            $status = 'warning';
        }
        if ($ph < 6.0 || $ph > 9.0 || $tds > 1000 || $ntu > 10) {
            $status = 'danger';
        }

        $reading = SensorReading::create([
            'ph_level'  => $ph,
            'turbidity' => $ntu,
            'tds'       => $tds,
            'status'    => $status,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $reading
        ], 201);
    }

    // Dashboard polls this to get latest reading
    public function latest()
    {
        $reading = SensorReading::latest()->first();
        return response()->json($reading);
    }

    // Get last 20 readings for charts
    public function history()
    {
        $readings = SensorReading::latest()->take(20)->get()->reverse()->values();
        return response()->json($readings);
    }
}