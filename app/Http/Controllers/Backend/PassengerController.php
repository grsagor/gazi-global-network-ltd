<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PassengerController extends Controller
{
    public function index()
    {
        return view('backend.pages.passengers.index');
    }

    public function details($id)
    {
        $passenger = Passenger::find($id);
        return view('backend.pages.passengers.details', compact('passenger'));
    }
    public function print(Request $request)
    {
        $passenger = Passenger::find($request->id);
        $html = view('backend.pages.passengers.print', compact('passenger'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }


    public function list(Request $request)
    {
        $data = Passenger::all();

        return DataTables::of($data)
            ->editColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('action', function ($row) {
                $html = '<div class="d-flex flex-wrap gap-2">';
                $html .= '<a href="'.route('admin.passengers.details', ['id' => $row->id]).'" data-id="'.$row->id.'" class="btn btn-sm btn-secondary">Details</a>';
                $html .= '<button type="button" data-id="'.$row->id.'" class="btn btn-sm btn-success crudPrintBtn">Print</button>';
                $html .= '<button type="button" data-id="'.$row->id.'" class="btn btn-sm btn-primary crudEditBtn">Edit</button>';
                $html .= '<button type="button" data-id="'.$row->id.'" class="btn btn-sm btn-danger crudDeleteBtn">Delete</button>';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $html = view('backend.pages.passengers.create')->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'nid_no' => 'nullable|string|max:20',
            'passport_no' => 'nullable|string|max:20',
            'passport_expire_date' => 'nullable|date',
            'passport_info_upload' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'pcc_number' => 'nullable|string|max:50',
            'pcc_issue_date' => 'nullable|date',
            'pcc_upload' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'designated_country_name' => 'required|string|max:255',
            'work_type' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'required_doc_name' => 'nullable|string|max:255',
            'application_status' => 'nullable|string|max:50',
            'contact_amount' => 'nullable|numeric',
            'deposit_amount' => 'nullable|numeric',
            'due_amount' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'image_upload' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'pdf_upload' => 'nullable|file|mimes:pdf|max:2048',
            'payment_doc_upload' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {
            $passenger = new Passenger();
            $passenger->added_by = Auth::user()->id;
            foreach ($validated as $key => $value) {
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    $destinationPath = public_path('uploads/passengers');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($destinationPath, $fileName);
                    $filePath = 'uploads/passengers/' . $fileName;
                    $passenger->$key = $filePath;                    
                } else {
                    $passenger->$key = $value;
                }
            }
            $passenger->save();

            return response()->json(['success' => true, 'msg' => 'Passenger saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }

    public function edit(Request $request)
    {
        $passenger = Passenger::findOrFail($request->id);
        $html = view('backend.pages.passengers.edit', compact('passenger'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'nid_no' => 'nullable|string|max:20',
            'passport_no' => 'nullable|string|max:20',
            'passport_expire_date' => 'nullable|date',
            'passport_info_upload' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'pcc_number' => 'nullable|string|max:50',
            'pcc_issue_date' => 'nullable|date',
            'pcc_upload' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'designated_country_name' => 'required|string|max:255',
            'work_type' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'required_doc_name' => 'nullable|string|max:255',
            'application_status' => 'nullable|string|max:50',
            'contact_amount' => 'nullable|numeric',
            'deposit_amount' => 'nullable|numeric',
            'due_amount' => 'nullable|numeric',
            'discount_amount' => 'nullable|numeric',
            'image_upload' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'pdf_upload' => 'nullable|file|mimes:pdf|max:2048',
            'payment_doc_upload' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
    
        try {
            $passenger = Passenger::findOrFail($request->id);
    
            foreach ($validated as $key => $value) {
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    $destinationPath = public_path('uploads/passengers');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($destinationPath, $fileName);
                    $filePath = 'uploads/passengers/' . $fileName;
    
                    // Delete the old file if it exists
                    if ($passenger->$key && file_exists(public_path($passenger->$key))) {
                        unlink(public_path($passenger->$key));
                    }
    
                    $passenger->$key = $filePath;
                } else {
                    $passenger->$key = $value;
                }
            }
    
            $passenger->save();
    
            return response()->json(['success' => true, 'msg' => 'Passenger updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }
    

    public function delete(Request $request)
    {
        try {
            $passenger = Passenger::findOrFail($request->id);
    
            // List all the file fields that need to be deleted
            $fileFields = [
                'passport_info_upload',
                'pcc_upload',
                'image_upload',
                'pdf_upload',
                'payment_doc_upload'
            ];
    
            // Loop through each file field and delete the corresponding file if it exists
            foreach ($fileFields as $field) {
                if ($passenger->$field && file_exists(public_path($passenger->$field))) {
                    unlink(public_path($passenger->$field)); // Delete the file
                }
            }
    
            // Now delete the passenger record
            $passenger->delete();
    
            return response()->json(['success' => true, 'msg' => 'Passenger deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }
    
}
