<?php

namespace Modules\MyFile\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\MyFile\Models\MyFile;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MyFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('my-file::index');
    }

    /**
     * Get data for DataTables (JSON endpoint)
     */
    public function indexJson(Request $request)
    {
        $query = MyFile::with('media')->latest();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('file_preview', function (MyFile $myFile) {
                if ($myFile->hasFile()) {
                    $extension = $myFile->file_extension;
                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                    
                    if ($isImage) {
                        return '<img src="' . $myFile->file_url . '" alt="' . $myFile->title . '" class="w-16 h-16 object-cover rounded-lg">';
                    } else {
                        return '<div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-300">' . strtoupper($extension) . '</span>
                                </div>';
                    }
                }
                return '<div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 text-xs">No File</span>
                        </div>';
            })
            ->addColumn('file_info', function (MyFile $myFile) {
                if ($myFile->hasFile()) {
                    return '<div class="text-sm">
                                <div class="font-medium text-gray-900 dark:text-gray-100">' . $myFile->file_name . '</div>
                                <div class="text-gray-500 dark:text-gray-400">' . $myFile->file_size . '</div>
                            </div>';
                }
                return '<span class="text-gray-400 text-sm">No file attached</span>';
            })
            ->addColumn('status', function (MyFile $myFile) {
                if ($myFile->is_active) {
                    return '<span class="inline-flex px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-800 dark:text-green-100">Active</span>';
                }
                return '<span class="inline-flex px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full dark:bg-red-800 dark:text-red-100">Inactive</span>';
            })
            ->addColumn('actions', function (MyFile $myFile) {
                $actions = '<div class="flex space-x-2">';
                
                // View button
                $actions .= '<a href="' . route('my-file::show', $myFile) . '" 
                               class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 dark:bg-blue-800 dark:text-blue-100 dark:hover:bg-blue-700">
                               <i class="fas fa-eye mr-1"></i> View
                            </a>';
                
                // Edit button
                $actions .= '<a href="' . route('my-file::edit', $myFile) . '" 
                               class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-600 bg-yellow-100 rounded-md hover:bg-yellow-200 dark:bg-yellow-800 dark:text-yellow-100 dark:hover:bg-yellow-700">
                               <i class="fas fa-edit mr-1"></i> Edit
                            </a>';
                
                // Delete button
                $actions .= '<form method="POST" action="' . route('my-file::destroy', $myFile) . '" class="inline-block" onsubmit="return confirm(\'Are you sure you want to delete this file?\')">
                               ' . csrf_field() . method_field('DELETE') . '
                               <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-md hover:bg-red-200 dark:bg-red-800 dark:text-red-100 dark:hover:bg-red-700">
                                   <i class="fas fa-trash mr-1"></i> Delete
                               </button>
                            </form>';
                
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['file_preview', 'file_info', 'status', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('my-file::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        try {
            DB::beginTransaction();

            $fileData = [
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->has('is_active'),
                'user_id' => auth()->id() ?? 1, // Default to user 1 if not authenticated
            ];

            // Extract file information if file is uploaded
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileData['extension'] = $file->getClientOriginalExtension();
                $fileData['mime_type'] = $file->getMimeType();
                $fileData['size'] = $file->getSize();
            }

            $myFile = MyFile::create($fileData);

            // Add the file to media collection
            if ($request->hasFile('file')) {
                $myFile->addMediaFromRequest('file')
                    ->toMediaCollection('my_file');
            }

            DB::commit();

            return redirect()->route('my-file::show', $myFile)
                ->with('success', 'File created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating MyFile: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create file: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MyFile $myFile): View
    {
        return view('my-file::show', compact('myFile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MyFile $myFile): View
    {
        return view('my-file::edit', compact('myFile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MyFile $myFile): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'title' => $request->title,
                'description' => $request->description,
                'is_active' => $request->has('is_active'),
            ];

            // Update the file if a new one is uploaded
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $updateData['extension'] = $file->getClientOriginalExtension();
                $updateData['mime_type'] = $file->getMimeType();
                $updateData['size'] = $file->getSize();
                
                // Clear existing media first (since it's singleFile)
                $myFile->clearMediaCollection('my_file');
                
                // Add new file
                $myFile->addMediaFromRequest('file')
                    ->toMediaCollection('my_file');
            }

            $myFile->update($updateData);

            DB::commit();

            return redirect()->route('my-file::show', $myFile)
                ->with('success', 'File updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating MyFile: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update file. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MyFile $myFile): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Clear all media first
            $myFile->clearMediaCollection('my_file');
            
            // Delete the record
            $myFile->delete();

            DB::commit();

            return redirect()->route('my-file::index')
                ->with('success', 'File deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting MyFile: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to delete file. Please try again.');
        }
    }

    /**
     * Download the file
     */
    public function download(MyFile $myFile)
    {
        if (!$myFile->hasFile()) {
            abort(404, 'File not found.');
        }

        $media = $myFile->getFirstMedia('my_file');
        
        if (!$media) {
            abort(404, 'Media not found.');
        }
        
        // Check if the file exists on the storage disk
        $filePath = $media->getPathRelativeToRoot();
        if (!Storage::disk($media->disk)->exists($filePath)) {
            Log::error('Media file not found', [
                'media_id' => $media->id,
                'disk' => $media->disk,
                'path' => $filePath,
                'file_name' => $media->file_name
            ]);
            abort(404, 'File not found on storage.');
        }
        
        try {
            // For S3 or remote storage, stream the download
            return Storage::disk($media->disk)->download($filePath, $media->file_name);
        } catch (\Exception $e) {
            Log::error('Media download failed', [
                'media_id' => $media->id,
                'error' => $e->getMessage(),
                'disk' => $media->disk,
                'path' => $filePath
            ]);
            abort(500, 'Download failed: ' . $e->getMessage());
        }
    }
}