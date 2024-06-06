<?php

namespace App\Http\Controllers;

use App\Models\NCR;
use App\Models\Tasks;
use App\Models\User;
use App\Models\WorkLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WorkLocationController extends Controller
{
    public function showWorkLocations()
    {
        $incharges = User::role('se')->get();
        $user = Auth::user();
        $title = "Work Locations";
        return view('config/work_locations', compact( 'user','title','incharges'));
    }

    public function allWorkLocations(Request $request)
    {
        try {
            // Attempt to retrieve all work locations
            $workLocations = WorkLocation::all();

            // Return a successful response with the work locations
            return response()->json([
                'work_locations' => $workLocations
            ], 200); // 200 is the HTTP status code for OK
        } catch (\Exception $e) {
            // Catch any exceptions that occur and return an error response
            return response()->json([
                'error' => 'Failed to retrieve work locations',
                'message' => $e->getMessage()
            ], 500); // 500 is the HTTP status code for Internal Server Error
        }
    }


    public function addWorkLocation(Request $request)
    {

        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'location' => 'required|string|unique:work_locations',
                'start_chainage' => 'required|string|unique:work_locations',
                'end_chainage' => 'required|string|unique:work_locations',
                'incharge' => 'required|string|unique:work_locations',
            ],[
                'location.required' => 'Work location name is required.',
                'start_chainage.unique' => 'A work location with same start chainage is already exists.',
                'start_chainage.required' => 'Start Chainage is required.',
                'end_chainage.unique' => 'A work location with same start chainage is already exists.',
                'end_chainage.required' => 'End Chainage is required.',
                'incharge.unique' => 'A work location with same incharge is already exists.',
                'incharge.required' => 'Location incharge is required.',
            ]);


            // Create a new NCR instance
            $workLocation = new WorkLocation();
            $workLocation->location = $validatedData['work_location_name'];
            $workLocation->start_chainage = $validatedData['start_chainage'];
            $workLocation->end_chainage = $validatedData['end_chainage'];
            $workLocation->incharge = $validatedData['incharge'];

            // Save the NCR to the database
            $workLocation->save();

            // Retrieve updated list of NCRs
            $workLocations = WorkLocation::all();

            // Return a success response
            return response()->json(['message' => 'Work location added successfully', 'work_locations' => $workLocations]);
        } catch (ValidationException $e) {
            // Validation failed, return error response
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Other exceptions occurred, return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
