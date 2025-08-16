<?php

namespace Modules\Option\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Option\Models\Option;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class OptionController extends Controller
{
    public function index()
    {
        $types = ['string', 'json', 'array', 'boolean', 'integer', 'float'];
        $batchNames = Option::getBatchNames();
        
        return view('option::index', compact('types', 'batchNames'));
    }

    public function indexJson(Request $request)
    {
        $model = Option::query();
        
        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Type filter
                if ($request->has('option_type') && $request->get('option_type')) {
                    $query->whereIn('option_type', $request->get('option_type'));
                }
                
                // Batch filter
                if ($request->has('batch_name') && $request->get('batch_name')) {
                    $query->where('batch_name', $request->get('batch_name'));
                }
                
                // Autoload filter
                if ($request->has('is_autoload') && $request->get('is_autoload') !== '' && $request->get('is_autoload') !== null) {
                    $filterValue = $request->get('is_autoload');
                    if ($filterValue == '1') {
                        $query->where('is_autoload', 1);
                    } else {
                        $query->where(function($q) {
                            $q->where('is_autoload', 0)->orWhere('is_autoload', '')->orWhereNull('is_autoload');
                        });
                    }
                }
                
                // System filter
                if ($request->has('is_system') && $request->get('is_system') !== '' && $request->get('is_system') !== null) {
                    $filterValue = $request->get('is_system');
                    if ($filterValue == '1') {
                        $query->where('is_system', 1);
                    } else {
                        $query->where(function($q) {
                            $q->where('is_system', 0)->orWhere('is_system', '')->orWhereNull('is_system');
                        });
                    }
                }
                
                // Date range filters
                if ($request->has('starting_date_of_option_create_at') && $request->get('starting_date_of_option_create_at')) {
                    $query->whereDate('created_at', '>=', $request->get('starting_date_of_option_create_at'));
                }
                if ($request->has('ending_date_of_option_created_at') && $request->get('ending_date_of_option_created_at')) {
                    $query->whereDate('created_at', '<=', $request->get('ending_date_of_option_created_at'));
                }
                
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('option_name', 'like', "%{$searchText}%")
                          ->orWhere('description', 'like', "%{$searchText}%")
                          ->orWhere('option_value', 'like', "%{$searchText}%");
                    });
                }
            }, true)
            ->addColumn('batch_name', function (Option $option) {
                if ($option->batch_name) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-300">' . htmlspecialchars($option->batch_name) . '</span>';
                }
                return '<span class="text-gray-400 dark:text-gray-500">-</span>';
            })
            ->addColumn('position', function (Option $option) {
                if (! $option->position) {
                    return 'N/A';
                }
                return '<span class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 rounded-full">' . $option->position . '</span>';
            })
            ->addColumn('formatted_value', function (Option $option) {
                $value = $option->formatted_value;
                if (strlen($value) > 100) {
                    return '<span class="truncate block max-w-xs" title="' . htmlspecialchars($value) . '">' . 
                           htmlspecialchars(substr($value, 0, 100)) . '...</span>';
                }
                return '<span class="break-words">' . htmlspecialchars($value) . '</span>';
            })
            ->addColumn('type_badge', function (Option $option) {
                return $option->type_badge;
            })
            ->addColumn('autoload_badge', function (Option $option) {
                return $option->autoload_badge;
            })
            ->addColumn('system_badge', function (Option $option) {
                return $option->system_badge;
            })
            ->addColumn('created_at_formatted', function (Option $option) {
                return $option->created_at->format('M d, Y H:i');
            })
            ->addColumn('updated_at_formatted', function (Option $option) {
                return $option->updated_at->format('M d, Y H:i');
            })
            ->addColumn('action', function (Option $option) {
                $actions = '<div class="flex items-center space-x-2">';
                
                $actions .= '<a href="' . route('option::admin.options.show', $option->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>';
                
                $actions .= '<a href="' . route('option::admin.options.edit', $option->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>';
                
                
                $actions .= '</div>';
                
                return $actions;
            })
            ->rawColumns(['batch_name', 'position', 'formatted_value', 'type_badge', 'autoload_badge', 'system_badge', 'action'])
            ->make(true);
    }

    public function create()
    {
        $types = ['string', 'json', 'array', 'boolean', 'integer', 'float'];
        return view('option::create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'option_name' => 'required|string|max:255|unique:options,option_name',
            'batch_name' => 'nullable|string|max:255',
            'option_value' => 'nullable',
            'option_type' => 'required|in:string,json,array,boolean,integer,float',
            'description' => 'nullable|string',
            'position' => 'integer|min:0',
            'is_autoload' => 'boolean',
            'is_system' => 'boolean'
        ]);

        // Handle JSON validation for json and array types
        if (in_array($request->option_type, ['json', 'array'])) {
            if ($request->option_value && !json_decode($request->option_value)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON format for ' . $request->option_type . ' type.'
                ], 422);
            }
        }

        try {
            $success = Option::set(
                $request->option_name,
                $request->option_value,
                $request->option_type,
                $request->description,
                $request->boolean('is_autoload'),
                $request->batch_name,
                $request->integer('position', 0)
            );

            if ($success) {
                // Set is_system flag if provided
                if ($request->boolean('is_system')) {
                    Option::where('option_name', $request->option_name)
                          ->update(['is_system' => true]);
                }

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Option created successfully!'
                    ]);
                }

                return redirect()->route('option::admin.options.index')
                               ->with('success', 'Option created successfully!');
            } else {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to create option.'
                    ], 500);
                }

                return back()->withInput()
                           ->with('error', 'Failed to create option.');
            }
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                       ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show(Option $option)
    {
        // Get siblings (options under the same batch name)
        $siblings = [];
        if ($option->batch_name) {
            $siblings = Option::where('batch_name', $option->batch_name)
                             ->where('id', '!=', $option->id)
                             ->orderBy('position')
                             ->select('id', 'option_name', 'position')
                             ->get();
        }
        
        return view('option::show', compact('option', 'siblings'));
    }

    public function edit(Option $option)
    {
        $types = ['string', 'json', 'array', 'boolean', 'integer', 'float'];
        return view('option::edit', compact('option', 'types'));
    }

    public function update(Request $request, Option $option)
    {
        $request->validate([
            'option_name' => 'required|string|max:255|unique:options,option_name,' . $option->id,
            'option_value' => 'nullable',
            'option_type' => 'required|in:string,json,array,boolean,integer,float',
            'description' => 'nullable|string',
            'position' => 'integer|min:0',
            'is_autoload' => 'boolean',
            'is_system' => 'boolean'
        ]);

        // Handle JSON validation for json and array types
        if (in_array($request->option_type, ['json', 'array'])) {
            if ($request->option_value && !json_decode($request->option_value)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON format for ' . $request->option_type . ' type.'
                ], 422);
            }
        }

        try {
            $success = Option::set(
                $request->option_name,
                $request->option_value,
                $request->option_type,
                $request->description,
                $request->boolean('is_autoload'),
                $request->batch_name,
                $request->integer('position', 0)
            );

            if ($success) {
                // Update is_system flag
                $option->update(['is_system' => $request->boolean('is_system')]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Option updated successfully!'
                    ]);
                }

                return redirect()->route('option::admin.options.index')
                               ->with('success', 'Option updated successfully!');
            } else {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to update option.'
                    ], 500);
                }

                return back()->withInput()
                           ->with('error', 'Failed to update option.');
            }
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                       ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(Option $option)
    {
        try {
            if ($option->is_system) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete system options.'
                ], 403);
            }

            $success = Option::delete($option->option_name);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Option deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete option.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}