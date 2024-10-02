@extends('layouts.dashboard')

@section('content')
<body style="background-color: #000;"></body>
<div class="flex">
    <!-- Sidebar -->
    <div class="sidebar"> <!-- Sidebar contents go here --> 
    <div class="symbol">
        <img src="{{ asset('images/symbol.png') }}" alt="Symbol Logo">
    </div>
        <ul>
            <li><a href="{{ route('textiles.index') }}">Inventory</a></li> <!-- Link to Textiles Index -->
            <li><a href="{{ route('textiles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">Add New Inventory</a></li>
    
            <li><a href="{{ route('dashboard') }}">Back to Dashboard</a></li> <!-- Link to Logout -->
        </ul>
    </div>


    <!-- Main Content Area -->
    <div class="content flex-grow ml-64 p-6">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>
        <h1 class="font-semibold text-2xl text-white leading-tight text-center">Add New Product</h1>

        <form action="{{ route('textiles.store') }}" method="POST" class="mt-6 space-y-6 bg-white p-6 rounded-lg shadow-lg">
            @csrf
            <div class="mt-4">
                <label for="name" class="block text-gray-700 font-semibold">Name:</label>
                <input type="text" name="name" id="name" class="border rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mt-4">
                <label for="stock" class="block text-gray-700 font-semibold">Stock:</label>
                <input type="number" name="stock" id="stock" class="border rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mt-4">
                <label for="categories" class="block text-gray-700 font-semibold">Categories:</label>
                <input type="text" name="categories" id="categories" class="border rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mt-4">
                <label for="description" class="block text-gray-700 font-semibold">Description:</label>
                <textarea name="description" id="description" class="border rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mt-4">
                <label for="price" class="block text-gray-700 font-semibold">Price:</label>
                <input type="number" name="price" id="price" class="border rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01" required>
            </div>
            <div class="mt-4">
                <label for="seller" class="block text-gray-700 font-semibold">Seller:</label>
                <input type="text" name="seller" id="seller" class="border rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Add Inventory</button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    body {
        background-color: #f7fafc; /* Light background color */
    }

    .sidebar {
    width: 300px; /* Increased width for sidebar */
    height: 100vh; /* Full height of the viewport */
    background-color: #333; /* Darker background for the sidebar */
    color: #fff; /* Text color */
    padding: 20px; /* Padding inside sidebar */
    position: fixed; /* Keeps the sidebar in place */
    z-index: 1000; /* Ensure it is above other elements */
}

.sidebar h2 {
    font-size: 1.5rem; /* Font size for sidebar heading */
    text-align: center; /* Center text */
    margin-bottom: 20px; /* Margin below heading */
    color: #fff; /* White text color */
}

.sidebar ul {
    list-style-type: none; /* No bullets */
    padding: 0; /* No padding */
}

.sidebar ul li {
    margin-bottom: 15px; /* Spacing between items */
}

.sidebar ul li a {
    color: #fff; /* White text color */
    padding: 10px 15px; /* Padding for links */
    display: block; /* Full-width links */
    border-radius: 5px; /* Rounded corners */
    transition: background-color 0.3s; /* Smooth background transition */
}

.sidebar ul li a:hover {
    background-color: #555; /* Darker background on hover */
}

.content {
    margin-left: 300px; /* Adjusted to sidebar width */
    padding: 20px; /* Padding for content area */
    flex-grow: 1; /* Allow content area to grow */
    background-color: #000; /* Black background color */
}

    /* Styling for symbol.png */
 .symbol {
        display: flex;
        justify-content: center;
        align-items: center;
      
    }
    .symbol img {
        width: 120px; /* Set the size for symbol.png */
        height: 100px;
    }
    form {
    background-color: #333; /* Grey background for form */
    padding: 20px; /* Padding inside form */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Box shadow */
    width: 800px; /* Widen the form */
    display: block; /* Display the form as a block element */
    margin-left: 15%; /* Center the form horizontally */
    margin-right: auto; /* Center the form horizontally */
}
button[type="submit"] {
    background-color: #fff; /* Grey background for submit button */
    color: #000; /* Black text color for submit button */
    padding: 10px 20px; /* Padding for submit button */
    border: none; /* No border for submit button */
    border-radius: 5px; /* Rounded corners for submit button */
    cursor: pointer; /* Pointer cursor for submit button */
}
   
   /* Updated logo styling */
.logo {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 170px; /* Adjust as needed */
        margin-bottom: 40px;
    }
    .logo img {
        width: 200px; /* Original size for logo.png */
        height: 170px;
    }
    
</style>
