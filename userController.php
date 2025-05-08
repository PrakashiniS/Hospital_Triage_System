<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bed;
use App\Models\User;
use App\Models\BedAvailability;
use App\Models\DoctorAssignment;
use App\Models\Notification;
use App\Models\Patient;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;



class userController extends Controller
{
    public function index()
    {
        $availabilityData = BedAvailability::all()->map(function ($ward) {
            $occupiedBeds = Bed::where('ward_number', $ward->ward_number)
                               ->where('is_occupied', true)
                               ->count();
    
            return [
                'ward_number'    => $ward->ward_number,
                'total_beds'     => $ward->total_beds,
                'occupied_beds'  => $occupiedBeds,
                'available_beds' => $ward->total_beds - $occupiedBeds,
                'ward_incharge'  => $ward->ward_incharge,
                'percent_used'   => round(($occupiedBeds / $ward->total_beds) * 100)
            ];
        });
    $detailtable=Patient::all();
    $detailtablecount=Patient::count();
    $criticalCount = Patient::where('triage_level', 'Critical')->count();
    $UrgentCount = Patient::where('triage_level', 'Urgent')->count();
    $StableCount = Patient::where('triage_level', 'Stable')->count();
        return view('index',compact('availabilityData','detailtable','detailtablecount','criticalCount','UrgentCount','StableCount'));
    }
   
//     public function submitPatientForm(Request $request)
// {
//     $age = (int) $request->input('patientAge');

//     // Age-based triage logic
//     if ($age >= 10 && $age <= 20) {
//         $triage_level = 'Stable';
//     } elseif ($age >= 21 && $age <= 40) {
//         $triage_level = 'Urgent';
//     } elseif ($age > 40) {
//         $triage_level = 'Critical';
//     } else {
//         $triage_level = 'Unknown';
//     }
//     $temperature = $request->input('temperature');
//     $heart_rate = $request->input('heartRate');
//     $blood_pressure = $request->input('bloodPressure');
    

//     if (strpos($blood_pressure, '/') !== false) {
//         list($bp_systolic, $bp_diastolic) = explode('/', $blood_pressure);
//     } else {
//         return response()->json(['error' => 'Invalid blood pressure format. Use systolic/diastolic like 120/80'], 422);
//     }
//     list($bp_systolic, $bp_diastolic) = explode('/', $blood_pressure);

//     $process = new Process([
//         'python',
//         storage_path('app/models/predict_triage.py'),
//         $temperature,
//         $heart_rate,
//         $bp_systolic,
//         $bp_diastolic
//     ]);

//     $process = new Process([
//         'python',
//         storage_path('app/models/predict_triage.py'),
//         $temperature,
//         $heart_rate,
//         $bp_systolic,
//         $bp_diastolic
//     ]);
//     $process->run();
    
//     $triage_level = trim($process->getOutput());
    
//     // if (!$triage_level || !is_numeric($triage_level)) {
//     //     return response()->json(['error' => 'Python output invalid'], 500);
//     // }
// // 
public function submitPatientForm(Request $request)
{
    $age = (int) $request->input('patientAge');

    // Age-based triage logic
    if ($age >= 10 && $age <= 20) {
        $triage_level = 'Stable';
    } elseif ($age >= 21 && $age <= 40) {
        $triage_level = 'Urgent';
    } elseif ($age > 40) {
        $triage_level = 'Critical';
    } else {
        $triage_level = 'Unknown';
    }

    // Save to DB
    Patient::create([
        'name' => $request->input('patientName'),
        'age' => $age,
        'symptoms' => $request->input('chiefComplaint'),
        'bp' => $request->input('bloodPressure'),
        'heart_rate' => $request->input('heartRate'),
        'temperature' => $request->input('temperature'),
        'triage_level' => $triage_level,
    ]);

    return redirect()->back()->with('success', 'Patient saved with triage level: ' . $triage_level);
}
public function showForm()
    {
        return view('verify');
    }

    public function checkHash(Request $request)
{
    // Validate the file upload
    $request->validate([
        'prescription' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // max 10MB
    ]);

    // Store the file in the 'uploads' directory
    $path = $request->file('prescription')->store('uploads');

    // Get the full path of the uploaded file
    $fullPath = storage_path('app/' . $path);

    // Ensure the file exists before trying to hash it
    if (!file_exists($fullPath)) {
        return back()->withError('File not found or failed to upload.');
    }

    // Calculate the hash of the file
    $hash = hash_file('sha256', $fullPath);

    // Return the result
    return view('check_result', ['hash' => $hash]);
}
public function verify()
    {
        // You can customize what this does
        return view('verify'); // make sure verify.blade.php exists in resources/views
    }
}