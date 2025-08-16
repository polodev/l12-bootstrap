<?php

namespace Modules\Location\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Location\Models\City;
use Modules\Location\Models\Country;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    /**
     * Display a listing of the cities.
     */
    public function index()
    {
        $countries = Country::active()->ordered()->get();
        return view('location::cities.index', compact('countries'));
    }

    /**
     * Get city data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = City::with('country');

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('state_province', 'like', "%{$searchText}%")
                          ->orWhereHas('country', function ($countryQuery) use ($searchText) {
                              $countryQuery->where('name', 'like', "%{$searchText}%");
                          });
                    });
                }

                // Country filter
                if ($request->has('country_id') && $request->get('country_id')) {
                    $query->where('country_id', $request->get('country_id'));
                }

                // Active filter
                if ($request->has('is_active') && $request->get('is_active') !== '' && $request->get('is_active') !== null) {
                    $query->where('is_active', (bool) $request->get('is_active'));
                }

                // Popular filter
                if ($request->has('is_popular') && $request->get('is_popular') !== '') {
                    $query->where('is_popular', $request->boolean('is_popular'));
                }

                // Capital filter
                if ($request->has('is_capital') && $request->get('is_capital') !== '') {
                    $query->where('is_capital', $request->boolean('is_capital'));
                }
            }, true)
            ->addColumn('name_formatted', function (City $city) {
                return '<div class="font-medium">' . htmlspecialchars($city->name) . '</div>';
            })
            ->addColumn('country_name', function (City $city) {
                return '<span class="text-sm">' . htmlspecialchars($city->country->name) . '</span>';
            })
            ->addColumn('status_badge', function (City $city) {
                return $city->status_badge;
            })
            ->addColumn('created_at_formatted', function (City $city) {
                return $city->created_at ? $city->created_at->format('M d, Y') : '-';
            })
            ->addColumn('badges', function (City $city) {
                $badges = '';
                $badges .= $city->popular_badge;
                $badges .= $city->capital_badge;
                return $badges ?: '<span class="text-gray-400 text-sm">-</span>';
            })
            ->addColumn('stats', function (City $city) {
                $html = '<div class="text-sm text-gray-600 dark:text-gray-400">';
                if ($city->population) {
                    $html .= '<div>Population: ' . number_format($city->population) . '</div>';
                } else {
                    $html .= '<div class="text-gray-400">No data available</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('action', function (City $city) {
                $actions = '<div class="flex items-center space-x-2">';
                
                $actions .= '<a href="' . route('location::admin.cities.show', $city->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>';
                
                $actions .= '<a href="' . route('location::admin.cities.edit', $city->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>';
                
                $actions .= '</div>';
                
                return $actions;
            })
            ->rawColumns(['name_formatted', 'country_name', 'status_badge', 'created_at_formatted', 'badges', 'stats', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating new city.
     */
    public function create()
    {
        $countries = Country::active()->ordered()->get();
        return view('location::cities.create', compact('countries'));
    }

    /**
     * Store a newly created city.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'state_province' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'timezone' => 'nullable|string|max:255',
            'population' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'is_capital' => 'nullable|boolean',
            'is_popular' => 'nullable|boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        City::create($request->all());

        return redirect()->route('location::admin.cities.index')
                       ->with('success', 'City created successfully!');
    }

    /**
     * Display the specified city.
     */
    public function show(City $city)
    {
        $city->load(['country']);
        return view('location::cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified city.
     */
    public function edit(City $city)
    {
        $countries = Country::active()->ordered()->get();
        return view('location::cities.edit', compact('city', 'countries'));
    }

    /**
     * Update the specified city.
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'state_province' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'timezone' => 'nullable|string|max:255',
            'population' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'is_capital' => 'nullable|boolean',
            'is_popular' => 'nullable|boolean',
            'position' => 'nullable|integer|min:0',
        ]);

        $city->update($request->all());

        return redirect()->route('location::admin.cities.show', $city->id)
                       ->with('success', 'City updated successfully!');
    }

    /**
     * Remove the specified city.
     */
    public function destroy(City $city)
    {
        try {
            $city->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'City deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}