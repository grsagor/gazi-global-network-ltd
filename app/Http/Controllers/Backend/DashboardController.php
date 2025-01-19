<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $agents = User::select('users.id', 'users.first_name', DB::raw('COALESCE(SUM(passengers.deposit_amount), 0) as total_deposit'))
            ->leftJoin('passengers', 'users.id', '=', 'passengers.agent_id') // Join passengers with users
            ->where('users.role', 2) // Filter by role (2 for agents)
            ->groupBy('users.id', 'users.first_name') // Group by agent ID and name
            ->orderByDesc('total_deposit') // Sort by total deposit in descending order
            ->limit(5) // Limit to top 5
            ->get();
        // $agents = User::select('users.id', 'users.first_name', DB::raw('COALESCE(SUM(passengers.deposit_amount), 0) as total_deposit'))
        //     ->leftJoin('passengers', 'users.id', '=', 'passengers.agent_id') // Join passengers with users
        //     ->where('users.role', 2) // Filter by role (2 for agents)
        //     ->groupBy('users.id', 'users.first_name') // Group by agent ID and name
        //     ->orderBy('total_deposit') // Sort by total deposit in descending order
        //     ->limit(5) // Limit to top 5
        //     ->get();

        return response()->json($agents);
        $total_contact_amount = Passenger::sum('contact_amount');
        $total_deposit_amount = Passenger::sum('deposit_amount');
        $total_due_amount = Passenger::sum('due_amount');
        $total_discount_amount = Passenger::sum('discount_amount');
        $data = [
            'total_contact_amount' => $total_contact_amount,
            'total_deposit_amount' => $total_deposit_amount,
            'total_due_amount' => $total_due_amount,
            'total_discount_amount' => $total_discount_amount,
        ];
        return view('backend.pages.dashboard.index', $data);
    }
    public function paidList(Request $request)
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
                return $amount;
            })
            ->addColumn('deposit_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('deposit_amount');
                return $amount;
            })
            ->addColumn('due_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('due_amount');
                return $amount;
            })
            ->addColumn('discount_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('discount_amount');
                return $amount;
            })
            ->addColumn('return_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('return_amount');
                return $amount;
            })
            ->rawColumns(['name'])
            ->make(true);
    }
    public function unpaidList(Request $request)
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
                return $amount;
            })
            ->addColumn('deposit_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('deposit_amount');
                return $amount;
            })
            ->addColumn('due_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('due_amount');
                return $amount;
            })
            ->addColumn('discount_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('discount_amount');
                return $amount;
            })
            ->addColumn('return_amount', function ($row) {
                $amount = Passenger::where('agent_id', $row->id)->sum('return_amount');
                return $amount;
            })
            ->rawColumns(['name'])
            ->make(true);
    }
}
