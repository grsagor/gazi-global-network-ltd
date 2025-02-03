<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AgentSubagent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class AgentController extends Controller
{

    public function index($role)
    {
        if ($role == 'agent') {
            $role = 2;
        } elseif ($role == 'sub-agent') {
            $role = 3;
        }
        return view('backend.pages.agents.index', compact('role'));
    }
    public function details($id)
    {
        $agent = User::find($id);
        return view('backend.pages.agents.details', compact('agent'));
    }
    public function list(Request $request, $role)
    {
        // return 'abc';
        $query = User::query();
        if ($request->agent_id) {
            $sub_agent_ids = AgentSubagent::where('agent_id', $request->agent_id)->pluck('sub_agent_id');
            $query->whereIn('id', $sub_agent_ids);
        } elseif (Auth::user()->role == 2) {
            $sub_agent_ids = AgentSubagent::where('agent_id', Auth::user()->id)->pluck('sub_agent_id');
            $query->whereIn('id', $sub_agent_ids);
        }
        
        if ($request->name) {
            $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $request->name . '%');
        }

        if ($request->passport) {
            $query->where('passport', $request->passport);
        }
        
        if ($request->company) {
            $query->where('company', $request->company);
        }
        
        if ($request->id) {
            $query->where('id', $request->id);
        }
        
        if ($request->nid) {
            $query->where('nid', $request->nid);
        }

        $data = $query->where('role', $role)->get();

        return DataTables::of($data)
            ->editColumn('name', function ($row) {
                $html = '';
                $html .= '<a href="'.route('admin.agents.details', ['id' => $row->id]).'">'.$row->first_name . ' ' . $row->last_name.'</a>';
                return $html;
            })
            ->editColumn('status', function ($row) {
                $html = '<div>';
                $html .= '<label class="switch" data-id="729">
                <input type="checkbox" class="switch_input crudStatusBtn" data-id="' . $row->id . '" ' . ($row->status ? 'checked' : '') . '>
                <span class="switch_slider round"></span>
            </label>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('action', function ($row) {
                $html = '<div class="d-flex gap-2">';
                $html .= '<button type="button" data-id="' . $row->id . '" class="btn btn-sm btn-primary crudEditBtn">Edit</a>';
                $html .= '<button type="button" data-id="' . $row->id . '" class="btn btn-sm btn-danger crudDeleteBtn">Delete</a>';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action', 'status', 'name']) // Allow HTML in action column
            ->make(true);
    }
    public function create($role)
    {
        $user = Auth::user();
        $agents = User::where('role', 2)->get();
        $html = view('backend.pages.agents.create', compact('role', 'user', 'agents'))->render();
        $response = [
            'success' => true,
            'html' => $html
        ];
        return response()->json($response);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'rating' => 'required|string|max:11',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        try {
            DB::beginTransaction();
            $profileImagePath = '';
            if ($request->hasFile('profile_image')) {
                $profileImage = $request->file('profile_image');
                $destinationPath = public_path('uploads/users');
                $profileImageName = time() . '_' . $profileImage->getClientOriginalName();
                $profileImage->move($destinationPath, $profileImageName);
                $profileImagePath = 'uploads/users/' . $profileImageName;
            }

            // Save the user
            $user = new User();
            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->role = $request->role;
            $user->password = Hash::make($validated['password']);
            $user->profile_image = $profileImagePath;
            $user->status = $request->status;
            $user->father_name = $request->father_name;
            $user->nid = $request->nid;
            $user->passport = $request->passport;
            $user->company = $request->company;
            $user->category = $request->category;
            $user->rating = $request->rating;
            $user->note = $request->note;
            $user->save();

            if ($request->agent_id) {
                $agent_subagent = new AgentSubagent();
                $agent_subagent->agent_id = $request->agent_id;
                $agent_subagent->sub_agent_id = $user->id;
                $agent_subagent->save();
            }

            DB::commit();

            return response()->json(['success' => true, 'msg' => 'User saved successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }
    public function edit(Request $request, $role)
    {
        $agent = User::find($request->id);
        $html = view('backend.pages.agents.edit', compact('agent', 'role'))->render();
        $response = [
            'success' => true,
            'html' => $html
        ];
        return response()->json($response);
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:6',
            'rating' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();
            // Find the user by ID
            $user = User::findOrFail($id);

            // Handle profile image upload if present
            if ($request->hasFile('profile_image')) {
                $profileImage = $request->file('profile_image');
                $destinationPath = public_path('uploads/users');
                $profileImageName = time() . '_' . $profileImage->getClientOriginalName();
                $profileImage->move($destinationPath, $profileImageName);
                $profileImagePath = 'uploads/users/' . $profileImageName;

                // Delete the old profile image if it exists
                if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                    unlink(public_path($user->profile_image));
                }

                $user->profile_image = $profileImagePath;
            }

            // Update user fields
            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->status = $request->status;
            $user->father_name = $request->father_name;
            $user->nid = $request->nid;
            $user->passport = $request->passport;
            $user->company = $request->company;
            $user->category = $request->category;
            $user->rating = $request->rating;
            $user->note = $request->note;
            $user->save();

            if ($request->agent_id) {
                $agent_subagent = AgentSubagent::where('sub_agent_id', $user->id)->first();
                $agent_subagent->delete();

                $agent_subagent = new AgentSubagent();
                $agent_subagent->agent_id = $request->agent_id;
                $agent_subagent->sub_agent_id = $user->id;
                $agent_subagent->save();
            }
            DB::commit();

            return response()->json(['success' => true, 'msg' => 'User updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            DB::beginTransaction();
            $agent = User::find($request->id);
            if ($agent->profile_image && file_exists(public_path($agent->profile_image))) {
                unlink(public_path($agent->profile_image));
            }
            AgentSubagent::where('agent_id', $agent->id)->delete();
            $agent->delete();
            DB::commit();
            return response()->json(['success' => true, 'msg' => 'User deleted successfully']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => $th->getMessage()], 500);
        }
    }
    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:users,id'
        ]);
    
        try {
            DB::beginTransaction();
    
            // Find the agent
            $agent = User::find($request->id);
            if (!$agent) {
                return response()->json(['success' => false, 'msg' => 'Agent not found'], 404);
            }
    
            // Toggle the status
            $new_status = $agent->status == 1 ? 0 : 1;
            $agent->status = $new_status;
            $agent->save();
    
            DB::commit();
            return response()->json(['success' => true, 'msg' => 'Status updated successfully']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => 'Failed to update status'], 500);
        }
    }
    
}
