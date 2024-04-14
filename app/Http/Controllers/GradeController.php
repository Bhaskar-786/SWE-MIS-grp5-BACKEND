<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\AcademicDeficiency;
use App\Models\Grade;
use App\Models\User;

class GradeController extends Controller
{
    public function addGrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
    
            'user_id' => 'required|string',
            'session_year_id' => 'required|numeric',
            'session_id' => 'required|numeric',
            'SGPA' => 'required|numeric|between:0,10.0',
            'CGPA' => 'required|numeric|between:0,10.0',
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $grade = new Grade();
        $grade->user_id = $request->user_id;
        $grade->session_year_id = $request->session_year_id;
        $grade->session_id = $request->session_id;
        $grade->SGPA = $request->SGPA;
        $grade->CGPA = $request->CGPA;

        try {
            $grade->save();
            return response()->json(['message' => 'Grade added successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add grade', 'e' => $e], 500);
        }
    }

    public function testConnection()
    {
        try {
            // Try to fetch a record from a table
            $record = DB::table('users')->first();

            // If the query executes without errors, it means the connection is successful
            if ($record) {
                return response()->json(['message' => 'Database connected successfully', 'record' => $record], 200);
            } else {
                return 'Database connection is established but there are no records in the table.';
            }
        } catch (\Exception $e) {
            // If an exception occurs, it means there's an issue with the database connection
            return 'Failed to connect to the database: ' . $e->getMessage();
        }
    }


    public function hello(Request $request){
        return response()->json(['message' => 'Hello'], 200);
    }

    public function abc(Request $request){
        return response()->json(['message' => $request], 200);
    }

    public function updateUserStatus(Request $request)
    {
        // Get all grades
        $grades = Grade::all();

        // Loop through each grade
        foreach ($grades as $grade) {
            if ($grade->deficiency_updated == 0){
                // Get the academic deficiency record for the user
            $deficiency = AcademicDeficiency::where('user_id', $grade->user_id)->first();

            if (!$deficiency) {
                // If academic deficiency record not found, create a new one
                $deficiency = new AcademicDeficiency();
                $deficiency->user_id = $grade->user_id;
            }

            // Check if SGPA < 4.0 and CGPA < 4.0
            if ($grade->SGPA < 4.0 && $grade->CGPA < 4.0) {
                // First time condition is met
                if ($deficiency->warning_count == 0 && $deficiency->probation_count == 0) {
                    // Set status to Warning
                    $deficiency->status = 'Warning';
                    $deficiency->warning_count++;
                } elseif ($deficiency->warning_count == 1 && $deficiency->probation_count == 0) {
                    // Set status to Probation
                    $deficiency->status = 'Probation';
                    $deficiency->probation_count++;
                } elseif ($deficiency->warning_count == 1 && $deficiency->probation_count == 1) {
                    // Set status to Terminated
                    $deficiency->status = 'Terminated';
                }
            } else {
                // If condition not met, set status to None
                $deficiency->status = 'None';
            }

            // Save the updated status for the user
            $deficiency->save();
            $grade->deficiency_updated=1;
            $grade->save();
            }
        }
        return response()->json(['message' => 'User statuses updated successfully'], 200);
    }

    public function reinstate(Request $request)
    {
        // Validate the request data
        $request->validate([
            'user_id' => 'required|string',
        ]);

        // Get the user ID from the request
        $userId = $request->input('user_id');

        // Find the user
        $user = User::find($userId);

        // If user not found, return error response
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Reset warning count, probation count, and status
        $deficiency = AcademicDeficiency::where('user_id', $userId)->first();

        if ($deficiency && $deficiency->status == "Terminated") {
            // Reset warning count and probation count
            $deficiency->warning_count = 0;
            $deficiency->probation_count = 0;

            // Set status to Active
            $deficiency->status = 'Active';

            // Save the changes
            $deficiency->save();

            return response()->json(['message' => 'User reinstated successfully'], 200);
        } else {
            return response()->json(['error' => 'Academic deficiency record not found for the user'], 404);
        }
    }

}
