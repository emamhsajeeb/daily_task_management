<?php

namespace App\Http\Controllers;

use App\Models\Objection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ObjectionController extends Controller
{
    public function showObjections()
    {
        $user = Auth::user();
        $title = "Objection List";
        return view('qcdoc/objections', compact( 'user','title'));
    }

    public function allObjections(Request $request)
    {
        $objections = Objection::all();

        return response()->json([
            'objections' => $objections
        ]);
    }

    public function addObjection(Request $request)
    {

        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'obj_no' => 'required|numeric|unique:objections',
                'ref_no' => 'required|string',
                'obj_type' => 'required|string',
                'issue_date' => 'required|date',
                'chainages' => 'required|string',
                'details' => 'required|string',
                'status' => 'required|string',
            ],[
                'obj_no.required' => 'Objection No. is required.',
                'obj_no.numeric' => 'Objection No. must be a number.',
                'obj_no.unique' => 'An Objection with the same Objection No. already exists.',
                'ref_no.required' => 'Reference No. is required.',
                'objection_type.required' => 'objection Type is required.',
                'issue_date.required' => 'Issue Date is required.',
                'issue_date.date' => 'Issue Date must be a valid date format.',
                'chainages.required' => 'Chainages are required.',
                'details.required' => 'Details is required.',
                'status.required' => 'Status is required.',
            ]);


            // Create a new objection instance
            $objection = new Objection();
            $objection->obj_no = $validatedData['obj_no'];
            $objection->ref_no = $validatedData['ref_no'];
            $objection->obj_type = $validatedData['obj_type'];
            $objection->issue_date = $validatedData['issue_date'];
//            $chainages = explode(' ', str_replace(',', ' ', $validatedData['chainages']));
//            $objection->chainages = implode(', ', array_filter($chainages));
            $objection->chainages = $validatedData['chainages'];
            $objection->details = $validatedData['details'];
            $objection->status = $validatedData['status'];
            $objection->remarks = $request->input('remarks');

            // Save the objection to the database
            $objection->save();

            // Retrieve updated list of objections
            $objections = Objection::all();

            // Return a success response
            return response()->json(['message' => 'Objection added successfully', 'objections' => $objections]);
        } catch (ValidationException $e) {
            // Validation failed, return error response
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Other exceptions occurred, return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteObjection(Request $request)
    {
        $objId = $request->id;

        // Retrieve the task from the database
        $objection = Objection::findOrFail($objId);

        // Perform any necessary logic before deleting the task
        // For example, you might check permissions or dependencies

        // Delete the task
        $objection->delete();

        // You can return a response if needed
        return response()->json(['message' => 'Objection deleted successfully']);
    }
}
