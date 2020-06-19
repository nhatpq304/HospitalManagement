<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    private $examResult;

    public function __construct(ExamResult $examResult)
    {
        $this->examResult = $examResult;
    }


    public function index()
    {
        $examResults = ExamResult::with('patient', 'doctor', 'medicines')->whereActive(1)->orderBy('updated_at', 'desc')->get();

        return response()->json(['data' => $examResults], 200);
    }

    public function store(Request $request)
    {
        $medArray = [];
        $this->examResult->fill($request->only([
            'doctor_id',
            'department',
            'created_date',
            'patient_id',
            'body_temp',
            'body_weight',
            'body_height',
            'blood_pressure',
            'result',
            'reexamination_date',
            'reminders'
        ]));

        $this->examResult->save();
        $savedResult = ExamResult::findOrFail($this->examResult->id);
        if (isset($request->medicines)) {

            foreach ($request->medicines as $medicine) {
                $medArray[$medicine['id']] = ['amount' => $medicine['amount'], 'remark' => $medicine['remark']];
            }
            $savedResult->medicines()->sync($medArray);
        };

        return response()->json(['data' => $savedResult->load('patient', 'doctor', 'medicines')], 201);
    }


    public function show(ExamResult $examResult)
    {
        $examResult = $examResult->load('patient' ,'patient.media', 'doctor',  'medicines' );

        return response()->json(['data' => $examResult], 200);
    }

    public function update(Request $request, ExamResult $examResult)
    {
        $medArray = [];
        $examResult->fill($request->only([
            'doctor_id',
            'department',
            'created_date',
            'patient_id',
            'body_temp',
            'body_weight',
            'body_height',
            'blood_pressure',
            'result',
            'reexamination_date',
            'reminders',
            'active'
        ]));

        $examResult->save();
        if (isset($request->medicines)) {

            foreach ($request->medicines as $medicine) {
                $medArray[$medicine['id']] = ['amount' => $medicine['amount'], 'remark' => $medicine['remark']];
            }
            $examResult->medicines()->sync($medArray);
        };

        return response()->json(['data' => $examResult->load('patient', 'doctor', 'medicines')], 200);
    }


    public function destroy(ExamResult $examResult)
    {
        $examResult->delete();

        return  response()->json([],204);
    }
}
