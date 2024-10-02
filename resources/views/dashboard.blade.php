<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Include your CSS and JS -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Google Fonts -->
    <style>
   body {
        font-family: 'Roboto', sans-serif;
        background-color: #000; /* Changed to black */
        color: #fff; /* Changed text color to white */
        margin: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh; /* Ensure body takes full screen height */
        overscroll-behavior: none;
    }
    .sidebar {
        width: 250px; 
        background-color: #333; /* Changed to dark grey */
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
        transition: transform 0.3s ease;
    }
    .sidebar a {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        color: #e0f2fe;
        text-decoration: none;
        border-radius: 5px;
        margin: 5px 0;
        transition: background-color 0.3s, transform 0.3s;
    }
    .sidebar a:hover {
        background-color: #5a7be6;
        color: white;
        transform: translateX(5px);
    }
    .main-content {
        margin-left: 250px;
        padding: 20px;
        background-color: #000;
        flex: 1; /* Allows main content to take up available space */
        min-height: 100vh; /* Ensure the content area takes full screen height */
        transition: margin-left 0.3s;
    }
    .content {
        margin-top: 20px;
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
        width: 300px; /* Original size for logo.png */
        height: 250px;
    }

    /* Styling for logout button */
    .logout-form {
        position: absolute;
        bottom: 20px; /* Position at the bottom of the sidebar */
        width: 100%; /* Full width of sidebar */
        padding: 0 20px; /* Padding for alignment */
    }

    .logout-button {
        display: flex;
        align-items: center;
        justify-content: center; /* Center the text */
        width: 100%;
        padding: 10px 20px;
        background-color: #e3342f; /* Red background */
        color: white; /* White text */
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .logout-button:hover {
        background-color: #cc1f1a; /* Darker red on hover */
        transform: translateX(5px);
    }

    /* Styling for pie chart boxes */
    .pie-chart-box {
        background-color: #333;
        padding: 10px;
        border-radius: 10px;
        margin: 40px;
        width: 400px;
    }

    .pie-chart-box h2 {
        color: #fff;
        margin-bottom: 5px;
    }

   .footer {
        background-color: #8B0000;
        color: #fff;
        padding: 20px;
        text-align: center;
        width: 100%;
        margin-top: auto; /* Push footer to the bottom */
    }

    .footer a {
        color: #fff;
        text-decoration: none;
    }

    .footer a:hover {
        color: #ccc;
    }
</style>
</head>
<body class="bg-gray-100">
<div class="sidebar">
    <!-- Symbol image with smaller size -->
    <div class="symbol">
        <img src="{{ asset('images/symbol.png') }}" alt="Symbol Logo">
    </div>

    <nav class="mt-10">
        <a href="{{ route('customers.index') }}" class="flex items-center">
            <span class="mx-2">👥</span>
            <span>Customers</span>
        </a>
        <a href="{{ route('textiles.index') }}" class="flex items-center">
            <span class="mx-2">🧵</span>
            <span>Inventory</span>
        </a>
    </nav>

    <!-- Add logout button at the bottom -->
    <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf <!-- CSRF token for protection -->
 <button type="submit" class="logout-button flex items-center">
            <span class="mx-2">🚪</span>
            <span>Logout</span>
        </button>
    </form>
</div>

<div class="main-content">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>
    <!-- Text content without the blue box -->
    <div>
        <h1 class="text-2xl font-bold">Welcome</h1>
        <p class="text-lg">Manage your customers and inventory efficiently here</p>
    </div>
    <div class="content">
        
        <p>To get started, use the navigation links on the left to view customers and Inventory</p>
    </div>
    

    <div class="flex justify-center mb-4">
        <div class="w-1/2 mr-4 pie-chart-box">
            <h2>Customer Base</h2>
            <canvas id="pieChart1" width="150" height="150"></canvas>
        </div>
        <div class="w-1/2 pie-chart-box">
            <h2>Inventory</h2>
            <canvas id="pieChart2" width="150" height="150"></canvas>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2018 - {{ date('Y') }} BRAWL</p>
    <p>Address: 123 Main St, Anytown, USA 12345</p>
    <p>Phone: 555-555-5555</p>
    <p>Email: <a href="mailto:info@brawl.com">info@brawl.com</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the canvas elements
    var ctx1 = document.getElementById('pieChart1').getContext('2d');
    var ctx2 = document.getElementById('pieChart2').getContext('2d');

    // Create the pie charts
    var pieChart1 = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: ['Jan', 'Feb', 'Mar'],
            datasets: [{
                label: 'Customer Base',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(0, 0, 0, 0.2)',
                    'rgba(128, 128, 128, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(0, 0, 0, 1)',
                    'rgba(128, 128, 128, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });

    var pieChart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Jan', 'Feb', 'Mar'],
            datasets: [{
                label: 'Inventory',
                data: [100, 200, 50],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(0, 0, 0, 0.2)',
                    'rgba(128, 128, 128, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(0, 0, 0, 1)',
                    'rgba(128, 128, 128, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
</script>
</body>
</html>