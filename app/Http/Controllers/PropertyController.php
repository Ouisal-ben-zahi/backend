<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Property;

class PropertyController extends Controller
{
    // Get all properties
    public function index()
    {
        return response()->json(Property::all(), 200);
    }

    // Get a specific property
    public function show($id)
    {
        $property = Property::find($id);
        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }
        return response()->json($property, 200);
    }

    // Get all unique categories of published properties
    public function getCategories()
    {
        $categories = Property::where('status', 'published')
                        ->distinct()
                        ->pluck('category');
        return response()->json($categories, 200);
    }

    // Add a new property
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'purpose' => 'required|in:sell,rent',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'reference_code' => 'required|string|unique:properties,reference_code',
            'description' => 'nullable|string',
            'kitchen' => 'nullable|integer',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach($request->file('images') as $image){
                $path = $image->store('properties', 'public');
                $imagePaths[] = '/storage/'.$path;
            }
        }
        $validated['images'] = $imagePaths;

        $property = Property::create($validated);
        return response()->json($property, 201);
    }

    // Update an existing property
    public function update(Request $request, $id)
    {
        $property = Property::find($id);
        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string',
            'purpose' => 'sometimes|required|in:sell,rent',
            'category' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'reference_code' => 'sometimes|required|string|unique:properties,reference_code,'.$id,
            'description' => 'nullable|string',
            'kitchen' => 'nullable|integer',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Delete old images if new ones are provided
        if ($request->hasFile('images')) {
            if ($property->images) {
                foreach($property->images as $oldImage) {
                    $oldPath = str_replace('/storage/', '', $oldImage);
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $imagePaths = [];
            foreach($request->file('images') as $image){
                $path = $image->store('properties', 'public');
                $imagePaths[] = '/storage/'.$path;
            }
            $validated['images'] = $imagePaths;
        }

        $property->update($validated);
        return response()->json($property, 200);
    }

    // Delete a property
    public function destroy($id)
    {
        $property = Property::find($id);
        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        // Delete images from storage
        if ($property->images) {
            foreach($property->images as $image) {
                $path = str_replace('/storage/', '', $image);
                Storage::disk('public')->delete($path);
            }
        }

        $property->delete();
        return response()->json(['message' => 'Property deleted successfully'], 200);
    }
}
