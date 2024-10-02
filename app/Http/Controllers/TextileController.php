<?php

// app/Http/Controllers/TextileController.php

namespace App\Http\Controllers;

use App\Models\Textile;
use Illuminate\Http\Request;

class TextileController extends Controller
{
    // Get all textiles
    public function index()
    {
        $textiles = Textile::all(); // Retrieve all textiles
        return view('textiles.index', compact('textiles')); // Load the textiles index view
    }

    // Add a new textile
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer',
            'categories' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'seller' => 'nullable|string',
        ]);

        Textile::create($validated);

        return redirect()->route('textiles.index')->with('success', 'Textile added successfully.');
    }

    // Get a specific textile
    public function show($id)
    {
        return Textile::findOrFail($id);
    }

    // Update a specific textile
    // app/Http/Controllers/TextileController.php

    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'stock' => 'required|integer',
        'categories' => 'nullable|string', // This allows categories to be null
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'seller' => 'nullable|string',
    ]);

    // Find the textile record by ID
    $textile = Textile::findOrFail($id);

    // Update the textile fields
    $textile->name = $request->name;
    $textile->stock = $request->stock;
    $textile->categories = $request->categories ?? ''; // Default to empty string if null
    $textile->description = $request->description;
    $textile->price = $request->price;
    $textile->seller = $request->seller;

    // Save the changes to the database
    $textile->save();

    // Redirect back with success message
    return redirect()->route('textiles.index')->with('success', 'Textile updated successfully.');
}

    


    // Delete a textile
    public function destroy($id)
    {
        Textile::destroy($id);
        return response()->json(null, 204);
    }

    public function create()
    {
        return view('textiles.create');
    }
}