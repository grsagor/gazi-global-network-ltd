<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Passenger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $country_ids = Passenger::distinct()->pluck('country_id');
        $countries = [];
        foreach ($country_ids as $country_id) {
            $country_name = Country::find($country_id)->name;
            $total_passengers = Passenger::where('country_id', $country_id)->count();
            $request_onlisted_passengers = Passenger::where([['status', 1], ['country_id', $country_id]])->count();
            $onlisted_passengers = Passenger::where([['status', 2], ['country_id', $country_id]])->count();
            $not_submitted_passengers = Passenger::where([['status', 3], ['country_id', $country_id]])->count();
            $submitted_passengers = Passenger::where([['status', 4], ['country_id', $country_id]])->count();
            $pending_passengers = Passenger::where([['status', 5], ['country_id', $country_id]])->count();
            $ready_for_submission_passengers = Passenger::where([['status', 6], ['country_id', $country_id]])->count();
            $additional_doc_required_passengers = Passenger::where([['status', 7], ['country_id', $country_id]])->count();
            $hold_passengers = Passenger::where([['status', 8], ['country_id', $country_id]])->count();
            $permit_passengers = Passenger::where([['status', 9], ['country_id', $country_id]])->count();
            $stamping_done_passengers = Passenger::where([['status', 10], ['country_id', $country_id]])->count();
            $rejected_passengers = Passenger::where([['status', 11], ['country_id', $country_id]])->count();
            $resubumit_passengers = Passenger::where([['status', 12], ['country_id', $country_id]])->count();
            $return_passengers = Passenger::where([['status', 13], ['country_id', $country_id]])->count();

            $country = [
                'country_namecountry_name' => $country_name,
                'total_passengerstotal_passengers' => $total_passengers,
                'request_onlisted_passengersrequest_onlisted_passengers' => $request_onlisted_passengers,
                'onlisted_passengersonlisted_passengers' => $onlisted_passengers,
                'not_submitted_passengersnot_submitted_passengers' => $not_submitted_passengers,
                'submitted_passengerssubmitted_passengers' => $submitted_passengers,
                'pending_passengerspending_passengers' => $pending_passengers,
                'ready_for_submission_passengersready_for_submission_passengers' => $ready_for_submission_passengers,
                'additional_doc_required_passengersadditional_doc_required_passengers' => $additional_doc_required_passengers,
                'hold_passengershold_passengers' => $hold_passengers,
                'permit_passengerspermit_passengers' => $permit_passengers,
                'stamping_done_passengersstamping_done_passengers' => $stamping_done_passengers,
                'rejected_passengersrejected_passengers' => $rejected_passengers,
                'resubumit_passengersresubumit_passengers' => $resubumit_passengers,
                'return_passengersreturn_passengers' => $return_passengers,
            ];

            $countries[] = $country;
        }
        // return $countries;
        $total_passengers = Passenger::count();
        $request_onlisted_passengers = Passenger::where('status', 1)->count();
        $onlisted_passengers = Passenger::where('status', 2)->count();
        $not_submitted_passengers = Passenger::where('status', 3)->count();
        $submitted_passengers = Passenger::where('status', 4)->count();
        $pending_passengers = Passenger::where('status', 5)->count();
        $ready_for_submission_passengers = Passenger::where('status', 6)->count();
        $additional_doc_required_passengers = Passenger::where('status', 7)->count();
        $hold_passengers = Passenger::where('status', 8)->count();
        $permit_passengers = Passenger::where('status', 9)->count();
        $stamping_done_passengers = Passenger::where('status', 10)->count();
        $rejected_passengers = Passenger::where('status', 11)->count();
        $resubumit_passengers = Passenger::where('status', 12)->count();
        $return_passengers = Passenger::where('status', 13)->count();

        $data = [
            'total_passengers' => $total_passengers,
            'request_onlisted_passengers' => $request_onlisted_passengers,
            'onlisted_passengers' => $onlisted_passengers,
            'not_submitted_passengers' => $not_submitted_passengers,
            'submitted_passengers' => $submitted_passengers,
            'pending_passengers' => $pending_passengers,
            'ready_for_submission_passengers' => $ready_for_submission_passengers,
            'additional_doc_required_passengers' => $additional_doc_required_passengers,
            'hold_passengers' => $hold_passengers,
            'permit_passengers' => $permit_passengers,
            'stamping_done_passengers' => $stamping_done_passengers,
            'rejected_passengers' => $rejected_passengers,
            'resubumit_passengers' => $resubumit_passengers,
            'return_passengers' => $return_passengers,
        ];
        return view('backend.pages.dashboard.index', $data);
    }
    public function countriesList() {
        $country_ids = Passenger::distinct()->pluck('country_id');
        $countries = [];
    
        foreach ($country_ids as $country_id) {
            $country = Country::find($country_id);
    
            if (!$country) {
                continue; // Skip if country not found
            }
    
            $countries[] = [
                'country_name' => $country->name,
                'total_passengers' => Passenger::where('country_id', $country_id)->count(),
                'request_onlisted_passengers' => Passenger::where([['status', 1], ['country_id', $country_id]])->count(),
                'onlisted_passengers' => Passenger::where([['status', 2], ['country_id', $country_id]])->count(),
                'not_submitted_passengers' => Passenger::where([['status', 3], ['country_id', $country_id]])->count(),
                'submitted_passengers' => Passenger::where([['status', 4], ['country_id', $country_id]])->count(),
                'pending_passengers' => Passenger::where([['status', 5], ['country_id', $country_id]])->count(),
                'ready_for_submission_passengers' => Passenger::where([['status', 6], ['country_id', $country_id]])->count(),
                'additional_doc_required_passengers' => Passenger::where([['status', 7], ['country_id', $country_id]])->count(),
                'hold_passengers' => Passenger::where([['status', 8], ['country_id', $country_id]])->count(),
                'permit_passengers' => Passenger::where([['status', 9], ['country_id', $country_id]])->count(),
                'stamping_done_passengers' => Passenger::where([['status', 10], ['country_id', $country_id]])->count(),
                'rejected_passengers' => Passenger::where([['status', 11], ['country_id', $country_id]])->count(),
                'resubmit_passengers' => Passenger::where([['status', 12], ['country_id', $country_id]])->count(),
                'return_passengers' => Passenger::where([['status', 13], ['country_id', $country_id]])->count(),
            ];
        }
    
        return DataTables::of($countries)->toJson();
    }
}
