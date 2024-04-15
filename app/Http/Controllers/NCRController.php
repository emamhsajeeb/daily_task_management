<?php

namespace App\Http\Controllers;

use App\Models\NCR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class NCRController extends Controller
{
    public function showNCRs()
    {
        $user = Auth::user();
        $title = "NCR List";
        return view('qcdoc/ncrs', compact( 'user','title'));
    }

    public function allNCRs(Request $request)
    {
        $ncrs = NCR::all();

        return response()->json([
            'ncrs' => $ncrs
        ]);
    }

    public function addNCR(Request $request)
    {

        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'ncr_no' => 'required|numeric|unique:n_c_r_s',
                'ref_no' => 'required|string',
                'ncr_type' => 'required|string',
                'issue_date' => 'required|date',
                'chainages' => 'required|ncr_chainages',
                'details' => 'required|string',
                'status' => 'required|string',
            ],[
                'ncr_no.required' => 'NCR No. is required.',
                'ncr_no.numeric' => 'NCR No. must be a number.',
                'ncr_no.unique' => 'An NCR with the same NCR No. already exists.',
                'ref_no.required' => 'Reference No. is required.',
                'ncr_type.required' => 'NCR Type is required.',
                'issue_date.required' => 'Issue Date is required.',
                'issue_date.date' => 'Issue Date must be a valid date format.',
                'chainages.required' => 'Chainages are required.',
                'chainages.ncr_chainages' => 'Invalid Chainages.',
                'chainages.comma_separator' => 'Chainages should be followed by comma.',
                'details.required' => 'Details is required.',
                'status.required' => 'Status is required.',
            ]);


            // Create a new NCR instance
            $ncr = new NCR();
            $ncr->ncr_no = $validatedData['ncr_no'];
            $ncr->ref_no = $validatedData['ref_no'];
            $ncr->ncr_type = $validatedData['ncr_type'];
            $ncr->issue_date = $validatedData['issue_date'];
            $chainages = explode(' ', str_replace(',', ' ', $validatedData['chainages']));
            $ncr->chainages = implode(', ', array_filter($chainages));
            $ncr->details = $validatedData['details'];
            $ncr->status = $validatedData['status'];
            $ncr->remarks = $request->input('remarks');

            // Save the NCR to the database
            $ncr->save();

            // Retrieve updated list of NCRs
            $ncrs = NCR::all();

            // Return a success response
            return response()->json(['message' => 'NCR added successfully', 'ncrs' => $ncrs]);
        } catch (ValidationException $e) {
            // Validation failed, return error response
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Other exceptions occurred, return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
