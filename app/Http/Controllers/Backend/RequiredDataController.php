<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RequiredData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequiredDataController extends Controller
{
    public function passengerRequireData($passenger_id)
    {
        $required_data = RequiredData::where('passenger_id', $passenger_id)->get();
        $data = [
            'passenger_id' => $passenger_id,
            'required_data' => $required_data,
        ];
        return view('backend.pages.required_data.index', $data);
    }
    public function passengerRequireDataNew(Request $request, $passenger_id)
    {
        try {
            DB::beginTransaction();
            $required_data = new RequiredData();
            $required_data->passenger_id = $passenger_id;
            $required_data->required_text = $request->required_text;
            $required_data->save();
            DB::commit();
            return back()->with('success', 'New required data added!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function passengerRequireDataSubmit(Request $request, $data_id)
    {
        $rules = [
            'submitted_text_' . $data_id => 'required|string',
            'submitted_files_' . $data_id => 'required|array',
            'submitted_files_' . $data_id . '.*' => 'file|mimes:jpg,png,pdf|max:2048', // Adjust file rules as needed
        ];

        $messages = [
            'submitted_text_' . $data_id . '.required' => 'The text field is required.',
            'submitted_files_' . $data_id . '.required' => 'Please upload at least one file.',
            'submitted_files_' . $data_id . '.*.mimes' => 'Only JPG, PNG, and PDF files are allowed.',
            'submitted_files_' . $data_id . '.*.max' => 'Each file must not exceed 2MB.',
        ];

        $validated = $request->validate($rules, $messages);

        try {
            DB::beginTransaction();
            $required_data = RequiredData::findOrFail($data_id);
            $required_data->submitted_text = $validated['submitted_text_' . $data_id];
            
            $files = [];
            if ($request->hasFile('submitted_files_' . $data_id)) {
                foreach ($request->file('submitted_files_' . $data_id) as $file) {
                    $destinationPath = public_path('uploads/required-data');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($destinationPath, $fileName);
                    $files[] = [
                        // 'type' => $file->getMimeType(),
                        'path' => 'uploads/required-data/' . $fileName,
                    ];
                }
            }
            
            return 'try';
            $required_data->submitted_files = json_encode($files);
            $required_data->save();

            DB::commit();
            return back()->with('success', 'New required data added!');
        } catch (\Throwable $th) {
            return $th->getMessage();
            DB::rollBack();
            // return back()->with('error', 'Something went wrong!');
            return back()->with('error', $th->getMessage());
        }
    }
}
