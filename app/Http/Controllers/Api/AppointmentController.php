<?php

namespace App\Http\Controllers\Api;

use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    private $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment =$appointment;
    }

    public function index()
    {
        $appointment = Appointment::with('patient', 'doctor')->get();

        return response()->json(["data"=>$appointment], 200);
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
        $this->appointment->fill($request->all());

        if($this->appointment->save()){
            return response()->json(['data'=> $this->appointment->load('patient', 'doctor')],201);
        }else {
            return response()->json([], 500);
        }
    }


    public function show(Appointment $appointment)
    {
            return response()->json(['data'=> $appointment->load('patient', 'doctor')],200  );
    }


    public function edit(Appointment $appointment)
    {
        //
    }


    public function update(Request $request, Appointment $appointment)
    {
        $appointment->fill($request->all());
        if($appointment->save()){
            return response()->json(['data'=> $appointment->load('patient', 'doctor')],200);
        }else {
            return response()->json([],500);
        }
    }


    public function destroy(Appointment $appointment)
    {
        if($appointment->delete()) {
            return response()->json([],204);
        }else {
            return response()->json([],500);
        }


    }
}
