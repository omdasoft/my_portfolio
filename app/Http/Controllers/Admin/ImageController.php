<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function uploadTinyMCEImage(Request $request): JsonResponse
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Validate the file
                $request->validate([
                    'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                // Generate unique filename
                $filename = time().'_'.$file->getClientOriginalName();

                // Store the file
                $file->storeAs('public/tinymce', $filename);

                // Ensure we return a location
                $location = asset('storage/tinymce/'.$filename);

                // Return the URL with additional details to help with debugging
                return response()->json([
                    'location' => $location,
                    'file_details' => [
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ],
                ]);
            }

            // Log and return error if no file
            Log::error('No file uploaded in TinyMCE image upload');

            return response()->json([
                'error' => 'No file uploaded',
                'location' => null,
            ], 400);
        } catch (Exception $e) {
            // Log the full error
            Log::error('TinyMCE image upload error: '.$e->getMessage());

            return response()->json([
                'error' => $e->getMessage(),
                'location' => null,
            ], 500);
        }
    }
}
