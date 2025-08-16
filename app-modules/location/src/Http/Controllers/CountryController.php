<?php

namespace Modules\Location\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Location\Models\Country;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    /**
     * Display a listing of the countries.
     */
    public function index()
    {
        return view('location::countries.index');
    }

    /**
     * Get country data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = Country::withCount(['cities']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('code', 'like', "%{$searchText}%")
                          ->orWhere('code_3', 'like', "%{$searchText}%");
                    });
                }

                // Active filter
                if ($request->has('is_active') && $request->get('is_active') !== '' && $request->get('is_active') !== null) {
                    $query->where('is_active', (bool) $request->get('is_active'));
                }
            }, true)
            ->addColumn('name_formatted', function (Country $country) {
                $html = '<div class="flex items-center">';
                if ($country->flag_url) {
                    $html .= '<img src="' . htmlspecialchars($country->flag_url) . '" alt="' . htmlspecialchars($country->name) . '" class="w-6 h-4 mr-2 rounded">';
                }
                $html .= '<span class="font-medium">' . htmlspecialchars($country->name) . '</span>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('code_formatted', function (Country $country) {
                return '<code class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded text-sm font-mono">' . htmlspecialchars($country->code) . '</code>';
            })
            ->addColumn('phone_code_formatted', function (Country $country) {
                return $country->phone_code ? '<span class="font-mono">+' . htmlspecialchars($country->phone_code) . '</span>' : '-';
            })
            ->addColumn('currency_formatted', function (Country $country) {
                if ($country->currency_code) {
                    $html = '<div class="text-sm">';
                    $html .= '<div class="font-mono">' . htmlspecialchars($country->currency_code) . '</div>';
                    if ($country->currency_symbol) {
                        $html .= '<div class="text-gray-500">' . htmlspecialchars($country->currency_symbol) . '</div>';
                    }
                    $html .= '</div>';
                    return $html;
                }
                return '-';
            })
            ->addColumn('created_at_formatted', function (Country $country) {
                return $country->created_at ? $country->created_at->format('M d, Y') : '-';
            })
            ->addColumn('status_badge', function (Country $country) {
                return $country->status_badge;
            })
            ->addColumn('action', function (Country $country) {
                $actions = '<div class="flex items-center space-x-2">';
                
                $actions .= '<a href="' . route('location::admin.countries.show', $country->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>';
                
                $actions .= '<a href="' . route('location::admin.countries.edit', $country->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>';
                
                $actions .= '</div>';
                
                return $actions;
            })
            ->rawColumns(['name_formatted', 'code_formatted', 'phone_code_formatted', 'currency_formatted', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating new country.
     */
    public function create()
    {
        return view('location::countries.create');
    }

    /**
     * Store a newly created country.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:2|unique:countries,code',
            'code_3' => 'required|string|size:3|unique:countries,code_3',
            'phone_code' => 'nullable|string|max:10',
            'currency_code' => 'nullable|string|size:3',
            'currency_symbol' => 'nullable|string|max:10',
            'flag_url' => 'nullable|url|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'nullable|boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        Country::create($request->all());

        return redirect()->route('location::admin.countries.index')
                       ->with('success', 'Country created successfully!');
    }

    /**
     * Display the specified country.
     */
    public function show(Country $country)
    {
        $country->load(['cities']);
        return view('location::countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified country.
     */
    public function edit(Country $country)
    {
        return view('location::countries.edit', compact('country'));
    }

    /**
     * Update the specified country.
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:2|unique:countries,code,' . $country->id,
            'code_3' => 'required|string|size:3|unique:countries,code_3,' . $country->id,
            'phone_code' => 'nullable|string|max:10',
            'currency_code' => 'nullable|string|size:3',
            'currency_symbol' => 'nullable|string|max:10',
            'flag_url' => 'nullable|url|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'nullable|boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        $country->update($request->all());

        return redirect()->route('location::admin.countries.show', $country->id)
                       ->with('success', 'Country updated successfully!');
    }

    /**
     * Remove the specified country.
     */
    public function destroy(Country $country)
    {
        try {
            $country->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Country deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}