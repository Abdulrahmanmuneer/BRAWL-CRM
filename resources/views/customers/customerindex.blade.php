@extends('layouts.dashboard')

@section('content')
<body style="background-color: #000;"></body>
<div class="flex"> <!-- Flexbox to align sidebar and content -->
    <!-- Sidebar -->
    <div class="sidebar">
    <div class="symbol">
        <img src="{{ asset('images/symbol.png') }}" alt="Symbol Logo">
    </div>

        <ul>
        
            <li><a href="{{ route('customers.index') }}">Customers</a></li> <!-- Link to Customers -->
            <li><a href="{{ route('customers.create') }}">Add Customer</a></li>
            <li><a href="{{ route('dashboard') }}">Back to Dashboard</a></li> <!-- Link to Logout -->
        </ul>
    </div>



    <!-- Main Content Area -->
    <div class="content flex-grow ml-64 p-6"> <!-- Adjust margin to accommodate the sidebar -->
        
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>
        <h1 class="font-semibold text-xl text-white leading-tight text-center mt-4">Registered Customers</h1>

        <!-- Customer Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @foreach($customers as $customer)
            <div class="bg-grey shadow-lg rounded-lg p-6 transition-transform duration-300 hover:shadow-xl relative customer-card" id="customer-{{ $customer->id }}">
                <h3 class="text-lg font-semibold text-gray-800">{{ $customer->name }}</h3>
                <p class="mt-1 text-gray-600">Username: {{ $customer->username }}</p>
                <p class="mt-1 text-gray-600">Address: {{ $customer->address }}</p>
                <p class="mt-1 text-gray-600">History: {{ $customer->history }}</p>
                <p class="mt-1 text-gray-600">Ongoing Orders: {{ $customer->ongoing_orders }}</p>

                <!-- Edit and Delete Buttons -->
                <!-- Edit and Delete Buttons -->
<div class="mt-4 flex justify-between">
    <button class="bg-blue-600 text-grey px-4 py-2 rounded hover:bg-blue-700 transition duration-300" onclick="openEditModal({{ $customer->id }})">Edit</button>
    <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300" onclick="confirmRemove({{ $customer->id }})">Delete</button>
</div>

            </div>
            @endforeach
        </div>

        <!-- Edit Customer Modal -->
        <div id="edit-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-1/2 shadow-lg">
                <h2 class="font-semibold text-xl text-white leading-tight">Edit Customer</h2>

                <form id="edit-customer-form" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit-customer-id"> <!-- Hidden field to store customer ID -->
                    <div class="mt-4">
                        <label for="edit-name" class="block">Name:</label>
                        <input type="text" name="name" id="edit-name" class="border rounded p-2 w-full" required>
                    </div>
                    <div class="mt-4">
                        <label for="edit-username" class="block">Username:</label>
                        <input type="text" name="username" id="edit-username" class="border rounded p-2 w-full" required>
                    </div>
                    <div class="mt-4">
                        <label for="edit-address" class="block">Address:</label>
                        <input type="text" name="address" id="edit-address" class="border rounded p-2 w-full">
                    </div>
                    <div class="mt-4">
                        <label for="edit-history" class="block">History:</label>
                        <textarea name="history" id="edit-history" class="border rounded p-2 w-full"></textarea>
                    </div>
                    <div class="mt-4">
                        <label for="edit-ongoing-orders" class="block">Ongoing Orders:</label>
                        <input type="number" name="ongoing_orders" id="edit-ongoing-orders" class="border rounded p-2 w-full">
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Customer</button>
                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded ml-2" onclick="closeEditModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Remove Confirmation Modal -->
<div id="remove-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
        <h2 class="font-semibold text-xl text-white leading-tight">Confirm Deletion</h2>
        <p class="mt-4 text-white">Are you sure you want to delete this customer?</p>
        <div class="mt-6 flex justify-end">
            <button id="confirm-remove" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">Yes</button>
            <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded ml-2 hover:bg-gray-400 transition duration-300" onclick="closeRemoveModal()">No</button>
        </div>
    </div>
</div>


    </div>
</div>

<script>
    let currentCustomerId;

    function closeEditModal() {
        const modal = document.getElementById('edit-modal');
        modal.classList.add('hidden');
    }

    function openEditModal(customerId) {
        const customerCard = document.getElementById(`customer-${customerId}`);
        const name = customerCard.querySelector('h3').innerText;
        const username = customerCard.querySelector('p:nth-of-type(1)').innerText.split(': ')[1];
        const address = customerCard.querySelector('p:nth-of-type(2)').innerText.split(': ')[1];
        const history = customerCard.querySelector('p:nth-of-type(3)').innerText.split(': ')[1];
        const ongoingOrders = customerCard.querySelector('p:nth-of-type(4)').innerText.split(': ')[1];

        document.getElementById('edit-customer-id').value = customerId;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-username').value = username;
        document.getElementById('edit-address').value = address;
        document.getElementById('edit-history').value = history;
        document.getElementById('edit-ongoing-orders').value = ongoingOrders;

        document.getElementById('edit-modal').classList.remove('hidden');
    }

    function confirmRemove(customerId) {
        currentCustomerId = customerId;
        document.getElementById('remove-modal').classList.remove('hidden');
    }

    document.getElementById('confirm-remove').onclick = function () {
        fetch(`/customers/${currentCustomerId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            if (response.ok) {
                document.getElementById(`customer-${currentCustomerId}`).remove(); // Remove the card from the UI
                closeRemoveModal(); // Close the confirmation modal
            }
        });
    }

    function closeRemoveModal() {
        document.getElementById('remove-modal').classList.add('hidden');
    }

    // Handle form submission for editing a customer
    document.getElementById('edit-customer-form').onsubmit = function (e) {
        e.preventDefault(); // Prevent default form submission
        const customerId = document.getElementById('edit-customer-id').value;

        fetch(`/customers/${customerId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                name: document.getElementById('edit-name').value,
                username: document.getElementById('edit-username').value,
                address: document.getElementById('edit-address').value,
                history: document.getElementById('edit-history').value,
                ongoing_orders: document.getElementById('edit-ongoing-orders').value
            })
        })
        .then(response => {
            if (response.ok) {
                // Update the customer card
                const customerCard = document.getElementById(`customer-${customerId}`);
                customerCard.querySelector('h3').innerText = document.getElementById('edit-name').value;
                customerCard.querySelector('p:nth-of-type(1)').innerText = `Username: ${document.getElementById('edit-username').value}`;
                customerCard.querySelector('p:nth-of-type(2)').innerText = `Address: ${document.getElementById('edit-address').value}`;
                customerCard.querySelector('p:nth-of-type(3)').innerText = `History: ${document.getElementById('edit-history').value}`;
                customerCard.querySelector('p:nth-of-type(4)').innerText = `Ongoing Orders: ${document.getElementById('edit-ongoing-orders').value}`;
                
                closeEditModal();
            }
        });
    };
</script>

<style>
    body {
    background-color: #000 /* Black background color */
}

h1, h2 {
    color: #fff; /* White text color */
    margin-bottom: 1.5rem; /* Spacing below heading */
}

.sidebar {
    width: 300px; /* Increased width for sidebar */
    height: 100vh; /* Full height of the viewport */
    background-color: #333; /* Dark grey background for the sidebar */
    color: #fff; /* White text color */
    padding: 20px; /* Padding inside sidebar */
    position: fixed; /* Keeps the sidebar in place */
    z-index: 1000; /* Ensure it is above other elements */
}

.sidebar h2 {
    font-size: 1.5rem; /* Font size for sidebar heading */
    text-align: center; /* Center text */
    margin-bottom: 20px; /* Margin below heading */
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
}

.customer-card {
    position: relative;
    padding: 20px;
    background-color: #333; /* Dark grey background for customer cards */
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.customer-card h3, .customer-card p {
    color: #fff; /* White text color */
}

.customer-card:hover {
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



    
#edit-modal {
    background-color: #000;
    background-opacity: 1;
}

#edit-modal .bg-white {
    background-color: #333;
}

#edit-modal label {
    color: #fff;
}

#edit-modal button {
    color: #fff;
    background-color: #333;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
}

#edit-modal button:hover {
    background-color: #555;
}

#remove-modal {
    background-color: #000;
    background-opacity: 1;
}

#remove-modal .bg-white {
    background-color: #333;
}

#remove-modal label {
    color: #fff;
}

#remove-modal button {
    color: #fff;
    background-color: #333;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
}

#remove-modal button:hover {
    background-color: #555;
}
</style>

