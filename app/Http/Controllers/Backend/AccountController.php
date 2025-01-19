<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AccountController extends Controller
{

    public function index()
    {
        return view('backend.pages.accounts.index');
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
}
