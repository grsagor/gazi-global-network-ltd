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
        foreach ($required_data as $item) {
            $item->submitted_files = json_decode($item->submitted_files);
        }
        // return $required_data;
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
            'submitted_files_' . $data_id . '.*' => 'file|mimes:jpg,png,pdf|max:20048', // Adjust file rules as needed
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
            $required_data->submitted_text = $validated['submitted_text_' . $data_id] ? $validated['submitted_text_' . $data_id] : $required_data->submitted_text;

            $files = [];
            if ($request->hasFile('submitted_files_' . $data_id)) {
                foreach ($request->file('submitted_files_' . $data_id) as $file) {
                    $destinationPath = public_path('uploads/required-data');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($destinationPath, $fileName);

                    // Mimetype
                    $filePath = $destinationPath . '/' . $fileName;
                    $finfo = new \finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->file($filePath);

                    $files[] = [
                        'type' => $mimeType,
                        'path' => 'uploads/required-data/' . $fileName,
                        'file_name' => $fileName,
                    ];
                }

                if ($required_data->submitted_files) {
                    $oldFiles = json_decode($required_data->submitted_files, true);
                    foreach ($oldFiles as $oldFile) {
                        $oldFilePath = public_path($oldFile['path']);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath); // Delete the old file
                        }
                    }
                }
            }

            $required_data->submitted_files = json_encode($files);
            $required_data->save();

            DB::commit();
            return back()->with('success', 'New required data added!');
        } catch (\Throwable $th) {
            DB::rollBack();
            // return back()->with('error', 'Something went wrong!');
            return back()->with('error', $th->getMessage());
        }
    }
}
