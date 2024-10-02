<?php

// app/Http/Controllers/CustomerController.php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    // Get all customers
   // app/Http/Controllers/CustomerController.php

   public function index()
   {
       $customers = Customer::all();
       return view('customers.customerindex', compact('customers'));
   }
   


    // Register a new customer
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:customers',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'history' => 'nullable|string',
            'ongoing_orders' => 'nullable|integer|min:0',
            'password' => 'required|string|min:6',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']); // Hash the password

        Customer::create($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    // Get a specific customer
    public function show($id)
{
    $customer = Customer::find($id); // Find the customer by ID

    if (!$customer) {
        return redirect()->route('customers.index')->with('error', 'Customer not found.');
    }

    return view('customers.show', compact('customer')); // Pass customer to the view
}


    // Update a specific customer
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'username' => 'required|unique:customers,username,' . $customer->id,
            'name' => 'required',
            'address' => 'required',
            'password' => 'nullable|min:6', // Password is optional during updates
        ]);

        // Hash the password only if it is provided
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // If password is not provided, keep the old password
            unset($validatedData['password']);
        }

        $customer->update($validatedData);

        return response()->json($customer, 200);
    }

    // Delete a customer
    public function destroy($id)
    {
        Customer::destroy($id);
        return response()->json(null, 204);
    }

    public function edit($id)
{
    $customer = Customer::findOrFail($id);
    return response()->json($customer, 200); // Send back the customer data for editing
}

public function create()
    {
        return view('customers.create'); // Assuming the view is stored at resources/views/customers/create.blade.php
    }

}