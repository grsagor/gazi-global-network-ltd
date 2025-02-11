<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AccountController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $total_contact_amount = Passenger::sum('contact_amount');
        $total_deposit_amount = Passenger::sum('deposit_amount');
        $total_due_amount = Passenger::sum('due_amount');
        $total_discount_amount = Passenger::sum('discount_amount');
        if ($user->role == 2) {
            $total_contact_amount = Passenger::where('agent_id', $user->id)->sum('contact_amount');
            $total_deposit_amount = Passenger::where('agent_id', $user->id)->sum('deposit_amount');
            $total_due_amount = Passenger::where('agent_id', $user->id)->sum('due_amount');
            $total_discount_amount = Passenger::where('agent_id', $user->id)->sum('discount_amount');
        }
        $data = [
            'total_contact_amount' => intval($total_contact_amount),
            'total_deposit_amount' => intval($total_deposit_amount),
            'total_due_amount' => intval($total_due_amount),
            'total_discount_amount' => intval($total_discount_amount),
            'user' => $user,
        ];
        return view('backend.pages.accounts.index', $data);
    }
    public function list(Request $request)
    {
        $total_contact_amount = Passenger::sum('contact_amount');
        $total_deposit_amount = Passenger::sum('deposit_amount');
        $total_due_amount = Passenger::sum('due_amount');
        $total_discount_amount = Passenger::sum('discount_amount');

        $data = collect([
            [
                'label' => 'Total Contact Amount',
                'value' => $total_contact_amount
            ],
            [
                'label' => 'Total Deposit Amount',
                'value' => $total_deposit_amount
            ],
            [
                'label' => 'Total Due Amount',
                'value' => $total_due_amount
            ],
            [
                'label' => 'Total Discount Amount',
                'value' => $total_discount_amount
            ],
        ]);

        return DataTables::of($data)
            ->rawColumns([]) // Allow HTML in action column
            ->make(true);
    }
    public function agentList(Request $request)
    {
        $query = User::query();
        $query = $query->where('role', 2);
        $data = $query->get();

        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $html = '';
                $html .= '<a href="' . route('admin.accounts.agent.details', ['id' => $row->id]) . '">' . $row->first_name . ' ' . $row->last_name . '</a>';
                return $html;
            })
            ->addColumn('contact_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('contact_amount');
                return intval($amount);
            })
            ->addColumn('deposit_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('deposit_amount');
                return intval($amount);
            })
            ->addColumn('due_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('due_amount');
                return intval($amount);
            })
            ->addColumn('discount_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('discount_amount');
                return intval($amount);
            })
            ->addColumn('return_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('return_amount');
                return intval($amount);
            })
            ->rawColumns(['name'])
            ->make(true);
    }
    public function passengerList(Request $request)
    {
        $user = Auth::user();
        $query = Passenger::query();

        if ($user->role == 2) {
            $query->where('agent_id', $user->id);
        }

        $data = $query->get();

        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $html = '';
                $html .= '<a href="' . route('admin.passengers.details', ['id' => $row->id]) . '">' . $row->name . '</a>';
                return $html;
            })
            ->editColumn('contact_amount', function ($row) {
                $amount = $row->contact_amount ?? 0;
                return intval($amount);
            })
            ->editColumn('deposit_amount', function ($row) {
                $amount = $row->deposit_amount ?? 0;
                return intval($amount);
            })
            ->editColumn('due_amount', function ($row) {
                $amount = $row->due_amount ?? 0;
                return intval($amount);
            })
            ->editColumn('discount_amount', function ($row) {
                $amount = $row->discount_amount ?? 0;
                return intval($amount);
            })
            ->editColumn('return_amount', function ($row) {
                $amount = $row->return_amount ?? 0;
                return intval($amount);
            })
            ->rawColumns(['name'])
            ->make(true);
    }
    public function agentDetails($id)
    {
        $total_contact_amount = Passenger::where('agent_id', $id)->sum('contact_amount');
        $total_deposit_amount = Passenger::where('agent_id', $id)->sum('deposit_amount');
        $total_due_amount = Passenger::where('agent_id', $id)->sum('due_amount');
        $total_discount_amount = Passenger::where('agent_id', $id)->sum('discount_amount');
        $total_return_amount = Passenger::where('agent_id', $id)->sum('return_amount');
        $data = [
            'total_contact_amount' => $total_contact_amount,
            'total_deposit_amount' => $total_deposit_amount,
            'total_due_amount' => $total_due_amount,
            'total_discount_amount' => $total_discount_amount,
            'total_return_amount' => $total_return_amount,
            'id' => $id,
        ];
        return view('backend.pages.accounts.details', $data);
    }
    public function agentPrint(Request $request)
    {
        $total_contact_amount = Passenger::where('agent_id', $request->id)->sum('contact_amount');
        $total_deposit_amount = Passenger::where('agent_id', $request->id)->sum('deposit_amount');
        $total_due_amount = Passenger::where('agent_id', $request->id)->sum('due_amount');
        $total_discount_amount = Passenger::where('agent_id', $request->id)->sum('discount_amount');
        $total_return_amount = Passenger::where('agent_id', $request->id)->sum('return_amount');
        $data = [
            'total_contact_amount' => $total_contact_amount,
            'total_deposit_amount' => $total_deposit_amount,
            'total_due_amount' => $total_due_amount,
            'total_discount_amount' => $total_discount_amount,
            'total_return_amount' => $total_return_amount,
            'id' => $request->id,
        ];
        $html = view('backend.pages.accounts.print', $data)->render();
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function paidList(Request $request)
    {
        $data = User::select('users.id', 'users.first_name', 'users.last_name', DB::raw('COALESCE(SUM(passengers.deposit_amount), 0) as total_deposit'))
            ->leftJoin('passengers', 'users.id', '=', 'passengers.agent_id') // Join passengers with users
            ->where('users.role', 2) // Filter by role (2 for agents)
            ->groupBy('users.id', 'users.first_name', 'users.last_name') // Group by agent ID and name
            ->orderByDesc('total_deposit') // Sort by total deposit in descending order
            ->limit(5) // Limit to top 5
            ->get();

        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $html = '';
                $html .= '<a href="' . route('admin.accounts.agent.details', ['id' => $row->id]) . '">' . $row->first_name . ' ' . $row->last_name . '</a>';
                return $html;
            })
            ->addColumn('contact_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('contact_amount');
                return intval($amount);
            })
            ->addColumn('deposit_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('deposit_amount');
                return intval($amount);
            })
            ->addColumn('due_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('due_amount');
                return intval($amount);
            })
            ->addColumn('discount_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('discount_amount');
                return intval($amount);
            })
            ->addColumn('return_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('return_amount');
                return intval($amount);
            })
            ->rawColumns(['name'])
            ->make(true);
    }
    public function unpaidList(Request $request)
    {
        $data = User::select('users.id', 'users.first_name', 'users.last_name', DB::raw('COALESCE(SUM(passengers.deposit_amount), 0) as total_deposit'))
            ->leftJoin('passengers', 'users.id', '=', 'passengers.agent_id') // Join passengers with users
            ->where('users.role', 2) // Filter by role (2 for agents)
            ->groupBy('users.id', 'users.first_name', 'users.last_name') // Group by agent ID and name
            ->orderBy('total_deposit') // Sort by total deposit in descending order
            ->limit(5) // Limit to top 5
            ->get();

        return DataTables::of($data)
            ->addColumn('name', function ($row) {
                $html = '';
                $html .= '<a href="' . route('admin.accounts.agent.details', ['id' => $row->id]) . '">' . $row->first_name . ' ' . $row->last_name . '</a>';
                return $html;
            })
            ->addColumn('contact_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('contact_amount');
                return intval($amount);
            })
            ->addColumn('deposit_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('deposit_amount');
                return intval($amount);
            })
            ->addColumn('due_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('due_amount');
                return intval($amount);
            })
            ->addColumn('discount_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('discount_amount');
                return intval($amount);
            })
            ->addColumn('return_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('return_amount');
                return intval($amount);
            })
            ->rawColumns(['name'])
            ->make(true);
    }
}
