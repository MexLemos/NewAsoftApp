<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HrAttendance;
use Carbon\Carbon;

class HrController extends Controller
{
    public function ponto()
    {
        $today = Carbon::today()->format('Y-m-d');
        $attendance = HrAttendance::where('employee_id', auth()->id())
            ->where('date', $today)
            ->first();
            
        $allAttendances = [];
        if (auth()->user()->hasRole('admin')) {
            $allAttendances = HrAttendance::with('employee')->latest()->limit(100)->get();
        }

        return view('admin.ponto', compact('attendance', 'allAttendances'));
    }
    
    public function registrarPonto(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        
        $lat = $request->latitude;
        $lon = $request->longitude;
        
        // Coordenadas da ASoftMedia fornecidas pelo utilizador
        $asoftLat = -8.9343238138973;
        $asoftLon = 13.30569966776501;
        
        $distance = $this->calculateDistance($lat, $lon, $asoftLat, $asoftLon);
        
        if ($distance > 50) { 
            return back()->with('error', "Ponto recusado! A sua localização está a " . $distance . " metros do escritório. (Raio máximo permitido: 50m)");
        }
        
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now()->format('H:i:s');
        
        $attendance = HrAttendance::where('employee_id', auth()->id())
            ->where('date', $today)
            ->first();
            
        if (!$attendance) {
            HrAttendance::create([
                'employee_id' => auth()->id(),
                'date' => $today,
                'check_in_time' => $now,
                'latitude' => $lat,
                'longitude' => $lon,
                'location_status' => 'valid'
            ]);
            return back()->with('success', 'Entrada registada com sucesso às ' . $now . '!');
        } elseif (!$attendance->check_out_time) {
            $attendance->update([
                'check_out_time' => $now,
            ]);
            return back()->with('success', 'Saída registada com sucesso às ' . $now . '!');
        } else {
            return back()->with('error', 'O seu ponto de entrada e saída já foi registado na totalidade para o dia de hoje.');
        }
    }
    
    private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371000; // in meters
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
        $a = sin($latDelta / 2) * sin($latDelta / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c);
    }
}
