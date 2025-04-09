<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{
    // @desc Store new job application
    // @route POST /jobs/{job}/apply

    public function store(Request $request, Job $job): RedirectResponse
    {
        try {
            \Log::info('Starting job application process', [
                'job_id' => $job->id,
                'user_id' => auth()->id(),
            ]);

            // Check for server-level file size errors first
            if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_INI_SIZE) {
                \Log::error('File exceeds server upload_max_filesize limit');
                return redirect()->back()->withInput()->with('error', 'The resume file exceeds the server size limit of 2MB. Please upload a smaller file.');
            }

            // First validate basic form fields
            $validatedData = $request->validate([
                'full_name' => 'required|string',
                'contact_phone' => 'nullable|string',
                'contact_email' => 'required|string|email',
                'message' => 'nullable|string',
                'location' => 'nullable|string',
            ]);

            // Handle file upload separately
            if (!$request->hasFile('resume')) {
                \Log::error('Resume file missing from request');
                return redirect()->back()->withInput()->with('error', 'No resume file was provided.');
            }

            $file = $request->file('resume');

            // Validate file separately to give specific error messages
            if (!$file->isValid()) {
                \Log::error('Invalid resume file', ['error' => $file->getError()]);
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Invalid resume file: ' . $file->getErrorMessage());
            }

            // Log file details before attempting to store
            \Log::info('Resume file details', [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ]);

            // Explicitly validate file type
            if ($file->getClientMimeType() !== 'application/pdf' && !str_contains($file->getMimeType(), 'pdf')) {
                \Log::error('Invalid file type', ['mime' => $file->getMimeType()]);
                return redirect()->back()->withInput()->with('error', 'Resume must be a PDF file.');
            }

            try {
                // Create filename with timestamp to avoid conflicts
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());

                // Make sure directory exists
                $directory = 'resumes';
                if (!Storage::exists($directory)) {
                    Storage::makeDirectory($directory);
                    \Log::info('Created directory: ' . $directory);
                }

                // Store the file
                $path = Storage::putFileAs($directory, $file, $fileName);
                \Log::info('File stored successfully', ['path' => $path]);

                // Store proper path in database
                $validatedData['resume_path'] = str_replace('public/', '', $path);
            } catch (\Exception $e) {
                \Log::error('File storage error: ' . $e->getMessage());
                \Log::error($e->getTraceAsString());
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Failed to store resume: ' . $e->getMessage());
            }

            // Create application record
            try {
                $application = new Applicant($validatedData);
                $application->job_id = $job->id;
                $application->user_id = auth()->id();

                \Log::info('Saving application', [
                    'data' => $validatedData,
                    'job_id' => $job->id,
                    'user_id' => auth()->id(),
                ]);

                $application->save();
                \Log::info('Application saved successfully', ['id' => $application->id]);

                return redirect()->back()->with('success', 'Your application has been submitted');
            } catch (\Exception $e) {
                \Log::error('Database error: ' . $e->getMessage());
                \Log::error($e->getTraceAsString());
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Failed to save application: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            \Log::error('Unexpected error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
}

// private function getUploadErrorMessage($error)
//     {
//         switch ($error) {
//             case UPLOAD_ERR_INI_SIZE:
//                 return 'The uploaded file exceeds the maximum file size limit (check php.ini).';
//             case UPLOAD_ERR_FORM_SIZE:
//                 return 'The uploaded file exceeds the maximum file size limit specified in the form.';
//             case UPLOAD_ERR_PARTIAL:
//                 return 'The file was only partially uploaded.';
//             case UPLOAD_ERR_NO_FILE:
//                 return 'No file was uploaded.';
//             case UPLOAD_ERR_NO_TMP_DIR:
//                 return 'Missing a temporary folder.';
//             case UPLOAD_ERR_CANT_WRITE:
//                 return 'Failed to write file to disk.';
//             case UPLOAD_ERR_EXTENSION:
//                 return 'A PHP extension stopped the file upload.';
//             default:
//                 return 'Unknown upload error.';
//         }
//     }
