@extends('layouts.dashboard')

@section('content')
<body style="background-color: #000;"></body>
<div class="flex"> <!-- Flexbox to align sidebar and content -->

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
    <div class="content flex-grow ml-56 p-6"> <!-- Adjust margin to accommodate the sidebar -->
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>
    <h1 class="font-semibold text-xl text-white leading-tight text-center mt-4">Inventory Management</h1>


        <!-- Textile Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @foreach($textiles as $textile)
            <div class="textile-card bg-white shadow-lg rounded-lg p-6 transition-transform duration-300 hover:shadow-xl relative" id="textile-{{ $textile->id }}" data-stock="{{ $textile->stock }}" data-category="{{ $textile->categories }}" data-description="{{ $textile->description }}" data-price="{{ $textile->price }}" data-seller="{{ $textile->seller }}">
                <h3 class="text-lg font-semibold text-gray-800">{{ $textile->name }}</h3>
                <button class="mt-2 text-gray-400 hover:underline more-info-button" onclick="toggleMoreInfo({{ $textile->id }})">More Information</button>
                <div id="more-info-{{ $textile->id }}" class="hidden mt-2 text-gray-600">
                    <p>Stock: {{ $textile->stock }}</p>
                    <p>Category: {{ $textile->categories }}</p>
                    <p>Description: {{ $textile->description }}</p>
                    <p>Price: {{ $textile->price }}</p>
                    <p>Seller: {{ $textile->seller }}</p>
                </div>

                <!-- Edit and Delete Buttons -->
                <div class="mt-4 flex justify-between">
                    <button class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700 transition duration-300" onclick="openEditModal({{ $textile->id }})">Edit</button>
                    <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300" onclick="confirmRemove({{ $textile->id }})">Delete</button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Edit Textile Modal -->
        <div id="edit-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-1/2 shadow-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Textile</h2>

                <form id="edit-textile-form" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit-textile-id"> <!-- Hidden field to store textile ID -->
                    <div class="mt-4">
                        <label for="edit-name" class="block">Name:</label>
                        <input type="text" name="name" id="edit-name" class="border rounded p-2 w-full" required>
                    </div>
                    <div class="mt-4">
                        <label for="edit-stock" class="block">Stock:</label>
                        <input type="number" name="stock" id="edit-stock" class="border rounded p-2 w-full" required>
                    </div>
                    <div class="mt-4">
                        <label for="edit-category" class="block">Category:</label>
                        <input type="text" name="category" id="edit-category" class="border rounded p-2 w-full">
                    </div>
                    <div class="mt-4">
                        <label for="edit-description" class="block">Description:</label>
                        <textarea name="description" id="edit-description" class="border rounded p-2 w-full"></textarea>
                    </div>
                    <div class="mt-4">
                        <label for="edit-price" class="block">Price:</label>
                        <input type="number" name="price" id="edit-price" class="border rounded p-2 w-full" step="0.01" required>
                    </div>
                    <div class="mt-4">
                        <label for="edit-seller" class="block">Seller:</label>
                        <input type="text" name="seller" id="edit-seller" class="border rounded p-2 w-full">
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded">Update Textile</button>
                        <button type="button" class="bg-red-600 text-white px-4 py-2 rounded ml-2" onclick="closeEditModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Remove Confirmation Modal -->
        <div id="remove-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Confirm Deletion</h2>
                <p class="mt-4">Are you sure you want to delete this textile?</p>
                <div class="mt-6 flex justify-end">
                    <button id="confirm-remove" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">Yes</button>
                    <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded ml-2 hover:bg-gray-400 transition duration-300" onclick="closeRemoveModal()">No</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function toggleMoreInfo(id) {
    const moreInfo = document.getElementById(`more-info-${id}`);
    moreInfo.classList.toggle('hidden');
}

function openEditModal(textileId) {
    // Populate the form with the current textile data
    const textileCard = document.getElementById(`textile-${textileId}`);
    document.getElementById('edit-textile-id').value = textileId;
    document.getElementById('edit-name').value = textileCard.querySelector('h3').innerText;
    document.getElementById('edit-stock').value = textileCard.getAttribute('data-stock');
    document.getElementById('edit-category').value = textileCard.getAttribute('data-category');
    document.getElementById('edit-description').value = textileCard.getAttribute('data-description');
    document.getElementById('edit-price').value = textileCard.getAttribute('data-price');
    document.getElementById('edit-seller').value = textileCard.getAttribute('data-seller');
  

    // Set the form action dynamically
    document.getElementById('edit-textile-form').action = `{{ url('textiles') }}/${textileId}`;

    // Show the modal
    document.getElementById('edit-modal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('edit-modal').classList.add('hidden');
}

function confirmRemove(textileId) {
    document.getElementById('confirm-remove').onclick = function() {
        document.getElementById('remove-modal').classList.add('hidden');
        // Make a DELETE request to delete the textile
        fetch(`{{ url('textiles') }}/${textileId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: textileId })
        }).then(response => {
            if (response.ok) {
                document.getElementById(`textile-${textileId}`).remove();
            }
        });
    };
    document.getElementById('remove-modal').classList.remove('hidden');
}

function closeRemoveModal() {
    document.getElementById('remove-modal').classList.add('hidden');
}
</script>

<style>
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

.textile-card {
    width: 350px; /* Increased width for textile cards */
    position: relative;
    padding: 20px;
    background-color: #333; /* Dark grey background for textile cards */
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.textile-card h3, .textile-card p {
    color: #fff; /* White text color */
}

.textile-card:hover {
    transform: translateY(-5px);
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
/* Responsive Adjustments */
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }

    .content {
        margin-left: 200px; 
    }
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

@endsection