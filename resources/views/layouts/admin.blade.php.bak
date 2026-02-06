<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CBT Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar-active {
            @apply bg-blue-600 text-white;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white shadow-lg flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-2xl font-bold">CBT Admin</h1>
                <p class="text-sm text-gray-400 mt-1">v1.0</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <!-- Exam Management -->
                <div class="pt-2">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Management</p>
                    
                    <a href="{{ route('admin.exams.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-all {{ request()->routeIs('admin.exams.*') ? 'sidebar-active' : '' }}">
                        <i class="fas fa-file-alt w-5"></i>
                        <span class="ml-3">Exams</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-all">
                        <i class="fas fa-question-circle w-5"></i>
                        <span class="ml-3">Question Groups</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-all">
                        <i class="fas fa-file-import w-5"></i>
                        <span class="ml-3">Imports</span>
                    </a>
                </div>

                <!-- Settings -->
                <div class="pt-2">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Settings</p>
                    
                    <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-all">
                        <i class="fas fa-mobile-alt w-5"></i>
                        <span class="ml-3">Mobile Settings</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-all">
                        <i class="fas fa-users-cog w-5"></i>
                        <span class="ml-3">User Management</span>
                    </a>
                </div>

                <!-- Monitoring -->
                <div class="pt-2">
                    <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Monitoring</p>
                    
                    <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-all">
                        <i class="fas fa-book w-5"></i>
                        <span class="ml-3">Activity Logs</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition-all">
                        <i class="fas fa-exclamation-triangle w-5"></i>
                        <span class="ml-3">Suspicious Activity</span>
                    </a>
                </div>
            </nav>

            <!-- User Profile -->
            <div class="border-t border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-700 rounded-lg transition-all">
                        <i class="fas fa-sign-out-alt w-4"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <div class="bg-white border-b border-gray-200 px-8 py-4 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-500 mt-1">@yield('page-subtitle', '')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 overflow-auto p-8">
                <!-- Alert Messages -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <h3 class="text-sm font-semibold text-red-800">Error</h3>
                        <ul class="mt-2 space-y-1 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex">
                            <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                            <p class="ml-3 text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Toast notification
        function showToast(message, type = 'success') {
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => toast.remove(), 3000);
        }

        // Delete confirmation
        function confirmDelete(message = 'Are you sure?') {
            return confirm(message);
        }
    </script>

    @yield('scripts')
</body>
</html>
