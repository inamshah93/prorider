<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PickupLocation;
use App\Models\SenderProfile;

class PickupLocationController extends Controller
{
    /**
     * List all pickup locations for the logged-in user
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $locations = $user->pickupLocations()->get();

        return response()->json([
            'status' => true,
            'message' => 'Pickup locations fetched successfully',
            'data' => $locations
        ]);
    }

    /**
     * Add a new pickup location
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_default' => 'nullable|boolean',
        ]);

        // Check if user already has pickup locations
        $hasLocations = $user->pickupLocations()->exists();

        // If this is the first location → force default = true
        if (!$hasLocations) {
            $validated['is_default'] = true;
        }

        // If marked as default, unset all other defaults
        if (!empty($validated['is_default']) && $validated['is_default'] == true) {
            $user->pickupLocations()->update(['is_default' => false]);
        }

        // Create pickup location
        $location = $user->pickupLocations()->create($validated);

        // If this one is default, update sender profile default_pickup_location_id
        if ($validated['is_default'] ?? false) {
            SenderProfile::updateOrCreate(
                ['user_id' => $user->id],
                ['default_pickup_location_id' => $location->id]
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Pickup location added successfully',
            'data' => $location
        ], 201);
    }

    /**
     * Update a pickup location
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $location = $user->pickupLocations()->where('id', $id)->firstOrFail();

        $validated = $request->validate([
            'address' => 'sometimes|string|max:255',
            'city' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_default' => 'nullable|boolean',
        ]);

        // If user marks this as default
        if (isset($validated['is_default']) && $validated['is_default'] == true) {
            $user->pickupLocations()->update(['is_default' => false]);
            SenderProfile::updateOrCreate(
                ['user_id' => $user->id],
                ['default_pickup_location_id' => $location->id]
            );
        }

        $location->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Pickup location updated successfully',
            'data' => $location
        ]);
    }

    /**
     * Set a pickup location as default
     */
    public function makeDefault(Request $request, $id)
    {
        $user = $request->user();

        // Unset all defaults
        $user->pickupLocations()->update(['is_default' => false]);

        // Set this one as default
        $user->pickupLocations()->where('id', $id)->update(['is_default' => true]);

        $location = $user->pickupLocations()->where('id', $id)->firstOrFail();

        // Update sender profile
        SenderProfile::updateOrCreate(
            ['user_id' => $user->id],
            ['default_pickup_location_id' => $location->id]
        );

        return response()->json([
            'status' => true,
            'message' => 'Default pickup location updated successfully',
            'data' => $location
        ]);
    }

    /**
     * Delete pickup location
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $location = $user->pickupLocations()->where('id', $id)->firstOrFail();

        $location->delete();

        return response()->json([
            'status' => true,
            'message' => 'Pickup location deleted successfully'
        ]);
    }
}
