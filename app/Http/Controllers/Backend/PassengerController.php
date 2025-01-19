<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AgentSubagent;
use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $user = Auth::user();
        $query = Passenger::query();
        if ($user->role == 2) {
            $query->where('agent_id', $user->id);
        }
        if ($user->role == 3) {
            $agent_ids = AgentSubagent::where('sub_agent_id', $user->id)->pluck('agent_id');
            $query->whereIn('agent_id', $agent_ids);
        }

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        if ($request->passport_no) {
            $query->where('passport_no', $request->passport_no);
        }
        
        if ($request->designated_country_name) {
            $query->where('designated_country_name', $request->designated_country_name);
        }
        
        if ($request->company_name) {
            $query->where('company_name', $request->company_name);
        }
        
        if ($request->agent_name) {
            $query->whereHas('agent', function ($agent) use ($request) {
                $agent->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $request->agent_name . '%');
            });
        }
        
        if ($request->agent_id) {
            $query->where('agent_id', $request->agent_id);
        }
        if ($request->subagent_id) {
            $sub_agent = User::find($request->subagent_id);
            $query->where('agent_id', $sub_agent->agent_id());
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        

        $data = $query->get();

        return DataTables::of($data)
            ->editColumn('name', function ($row) {
                $html = '';
                $html .= '<a href="'.route('admin.passengers.details', ['id' => $row->id]).'" data-id="'.$row->id.'">'.$row->name.'</a>';
                return $html;
            })
            ->addColumn('agent_name', function ($row) {
                return $row->agent->first_name . ' ' . $row->agent->last_name;
            })
            ->editColumn('status', function ($row) {
                $html = '';
                $html .= '<select data-id="'.$row->id.'" style="width: 223px;" class="form-select crudStatusBtn" aria-label="Default select example">';
                $html .= '<option ' . ($row->status == 1 ? "selected" : '') . ' value="1">Request for onlist</option>';
                $html .= '<option ' . ($row->status == 2 ? "selected" : '') . ' value="2">Onlisted</option>';
                $html .= '<option ' . ($row->status == 3 ? "selected" : '') . ' value="3">Not submitted</option>';
                $html .= '<option ' . ($row->status == 4 ? "selected" : '') . ' value="4">Submitted</option>';
                $html .= '<option ' . ($row->status == 5 ? "selected" : '') . ' value="5">Pending</option>';
                $html .= '<option ' . ($row->status == 6 ? "selected" : '') . ' value="6">Ready for submission</option>';
                $html .= '<option ' . ($row->status == 7 ? "selected" : '') . ' value="7">Additional docs require</option>';
                $html .= '<option ' . ($row->status == 8 ? "selected" : '') . ' value="8">Hold</option>';
                $html .= '<option ' . ($row->status == 9 ? "selected" : '') . ' value="9">Permit</option>';
                $html .= '<option ' . ($row->status == 10 ? "selected" : '') . ' value="10">Stamping done</option>';
                $html .= '<option ' . ($row->status == 11 ? "selected" : '') . ' value="11">Rejected</option>';
                $html .= '<option ' . ($row->status == 12 ? "selected" : '') . ' value="12">Resubmit</option>';
                $html .= '<option ' . ($row->status == 13 ? "selected" : '') . ' value="13">Return</option>';
                $html .= '</select>';
                return $html;
            })
            
            ->addColumn('action', function ($row) {
                $html = '<div class="d-flex flex-wrap gap-2">';
                $html .= '<a href="'.route('admin.required_data.single.passenger', ['passenger_id' => $row->id]).'" class="btn btn-sm btn-info">Data</a>';
                $html .= '<button type="button" data-id="'.$row->id.'" class="btn btn-sm btn-success crudPrintBtn">Print</button>';
                $html .= '<button type="button" data-id="'.$row->id.'" class="btn btn-sm btn-primary crudEditBtn">Edit</button>';
                $html .= '<button type="button" data-id="'.$row->id.'" class="btn btn-sm btn-danger crudDeleteBtn">Delete</button>';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action', 'name', 'status'])
            ->make(true);
    }

    public function create()
    {
        $user = Auth::user();
        $agents = User::where('role', 2)->get();
        $html = view('backend.pages.passengers.create', compact('agents', 'user'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'agent_id' => 'required',
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
            'return_amount' => 'nullable|numeric',
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
    public function status(Request $request)
    {
        try {
            $passenger = Passenger::findOrFail($request->id);
            $passenger->status = $request->status;
            $passenger->save();
    
            return response()->json(['success' => true, 'msg' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }
    
}
