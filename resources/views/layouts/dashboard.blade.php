<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Include your CSS and JS -->
</head>
<body class="bg-gray-100">
    <div class="flex">
        <div class="sidebar">
            {{-- 
                        <h2 class="text-white text-lg font-bold text-center">Textiles</h2>
                        <ul class="mt-4">
            --}}
                {{-- 
                <li>
                    <a href="{{ route('customers.index') }}" class="nav-link">Customers</a>
                </li>
                <li>
                    <a href="{{ route('textiles.index') }}" class="nav-link">Textiles</a>
                </li>
                <li class="mt-4">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                --}}
            </ul>
        </div>
        <div class="flex-grow p-6">
            <div class="text-center">
                <!-- You can add a welcome message or other content here -->
            </div>
            @yield('content') <!-- This is where the content of your views will be inserted -->
        </div>
    </div>
</body>
</html>