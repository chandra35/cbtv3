@extends('layouts.admin')

@section('title', 'Mobile Settings')
@section('page-title', 'Mobile App Settings')
@section('page-subtitle', 'Exam: ' . $exam->exam_name)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow-sm border-b">
        <div class="flex border-b border-gray-200">
            <button class="px-6 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600" id="tab-general">
                <i class="fas fa-cog mr-2"></i> General Settings
            </button>
            <button class="px-6 py-4 text-sm font-medium text-gray-600 hover:text-gray-900" id="tab-whitelist">
                <i class="fas fa-lock mr-2"></i> Whitelist
            </button>
            <button class="px-6 py-4 text-sm font-medium text-gray-600 hover:text-gray-900" id="tab-activity">
                <i class="fas fa-history mr-2"></i> Activity
            </button>
        </div>
    </div>

    <!-- General Settings Tab -->
    <div id="general-content">
        <form method="POST" action="{{ route('admin.mobile-settings.update', $exam) }}" class="space-y-6">
            @csrf @method('PUT')

            <!-- Password Protection -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Password Protection</h3>
                
                <div class="space-y-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="enable_password_protection" value="1" 
                            {{ $settings->enable_password_protection ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="ml-3 text-gray-700">Require password to start exam</span>
                    </label>

                    @if ($settings->enable_password_protection)
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm text-blue-900 mb-3">Current Password: <strong>{{ $settings->exam_password_hash ? '••••••••' : 'Not set' }}</strong></p>
                        
                        <div class="flex gap-2">
                            <button type="button" id="generate-password-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <i class="fas fa-refresh mr-2"></i> Generate Random Password
                            </button>
                            <button type="button" id="reset-password-btn" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                <i class="fas fa-trash mr-2"></i> Clear Password
                            </button>
                        </div>

                        <div id="password-display" class="mt-4 p-3 bg-white rounded border border-gray-200 hidden">
                            <p class="text-sm text-gray-600 mb-2">New Password Generated:</p>
                            <p class="text-2xl font-bold text-gray-900" id="password-value"></p>
                            <p class="text-xs text-gray-500 mt-2">Copy this password to share with students.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Anti-Cheating Features -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Anti-Cheating Features</h3>
                
                <div class="space-y-3">
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="prevent_screenshot" value="1" {{ $settings->prevent_screenshot ? 'checked' : '' }}
                            class="w-4 h-4 text-red-600 rounded focus:ring-2 focus:ring-red-500">
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Prevent Screenshots</p>
                            <p class="text-sm text-gray-500">Block screenshot attempts on mobile app</p>
                        </div>
                    </label>

                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="prevent_app_switching" value="1" {{ $settings->prevent_app_switching ? 'checked' : '' }}
                            class="w-4 h-4 text-red-600 rounded focus:ring-2 focus:ring-red-500">
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Detect App Switching</p>
                            <p class="text-sm text-gray-500">Flag when student leaves the exam app</p>
                        </div>
                    </label>

                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="prevent_screen_recording" value="1" {{ $settings->prevent_screen_recording ? 'checked' : '' }}
                            class="w-4 h-4 text-red-600 rounded focus:ring-2 focus:ring-red-500">
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Prevent Screen Recording</p>
                            <p class="text-sm text-gray-500">Block screen recording attempts</p>
                        </div>
                    </label>

                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="disable_copy_paste" value="1" {{ $settings->disable_copy_paste ? 'checked' : '' }}
                            class="w-4 h-4 text-red-600 rounded focus:ring-2 focus:ring-red-500">
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Disable Copy/Paste</p>
                            <p class="text-sm text-gray-500">Prevent copying/pasting text from exam</p>
                        </div>
                    </label>

                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="lock_device_orientation" value="1" {{ $settings->lock_device_orientation ? 'checked' : '' }}
                            class="w-4 h-4 text-red-600 rounded focus:ring-2 focus:ring-red-500">
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">Lock Device Orientation</p>
                            <p class="text-sm text-gray-500">Keep device in portrait mode</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Session Management -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Session Management</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Idle Timeout (seconds)</label>
                    <input type="number" name="max_idle_time" value="{{ old('max_idle_time', $settings->max_idle_time ?? 300) }}" min="60" max="3600"
                        class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Auto-submit exam if student inactive for this long (default: 5 minutes)</p>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                    <i class="fas fa-save mr-2"></i> Save Settings
                </button>
                <a href="{{ route('admin.exams.show', $exam) }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-all">
                    Back to Exam
                </a>
            </div>
        </form>
    </div>

    <!-- Whitelist Tab -->
    <div id="whitelist-content" class="hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- IP Whitelist -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">IP Whitelist</h3>
                
                <div class="space-y-4">
                    <p class="text-sm text-gray-600">Only these IP addresses can access this exam</p>
                    
                    <form id="add-ip-form" class="flex gap-2">
                        <input type="text" id="ip-input" placeholder="e.g., 192.168.1.1" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add IP</button>
                    </form>

                    <div id="ip-list" class="space-y-2 max-h-64 overflow-y-auto">
                        @forelse ($allowedIPs as $ip)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <code class="text-gray-900">{{ $ip }}</code>
                                <button type="button" class="delete-ip text-red-600 hover:text-red-800" data-ip="{{ $ip }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 py-4">No IP whitelist configured</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Device Whitelist -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Device Whitelist</h3>
                
                <div class="space-y-4">
                    <p class="text-sm text-gray-600">Only these devices can access this exam</p>
                    
                    <form id="add-device-form" class="space-y-2">
                        <input type="text" id="device-id-input" placeholder="Device ID" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="text" id="device-name-input" placeholder="Device Name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Device</button>
                    </form>

                    <div id="device-list" class="space-y-2 max-h-64 overflow-y-auto">
                        @forelse ($allowedDevices as $device)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $device['name'] ?? 'Unknown' }}</p>
                                    <code class="text-sm text-gray-500">{{ $device['id'] ?? 'Unknown' }}</code>
                                </div>
                                <button type="button" class="delete-device text-red-600 hover:text-red-800" data-device="{{ $device['id'] ?? '' }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 py-4">No device whitelist configured</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Tab -->
    <div id="activity-content" class="hidden">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
            
            <div class="space-y-3">
                <p class="text-sm text-gray-600 mb-4">
                    <a href="{{ route('admin.activity-logs.index', $exam) }}" class="text-blue-600 hover:text-blue-800">
                        View all activity logs →
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Tab switching
    document.getElementById('tab-general').addEventListener('click', () => switchTab('general'));
    document.getElementById('tab-whitelist').addEventListener('click', () => switchTab('whitelist'));
    document.getElementById('tab-activity').addEventListener('click', () => switchTab('activity'));

    function switchTab(tab) {
        document.querySelectorAll('[id$="-content"]').forEach(el => el.classList.add('hidden'));
        document.getElementById(tab + '-content').classList.remove('hidden');
        
        document.querySelectorAll('[id^="tab-"]').forEach(el => {
            el.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
            el.classList.add('text-gray-600');
        });
        document.getElementById('tab-' + tab).classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
    }

    // Generate password
    document.getElementById('generate-password-btn')?.addEventListener('click', function() {
        fetch('{{ route("admin.mobile-settings.generate-password", $exam) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('password-value').textContent = data.password;
                    document.getElementById('password-display').classList.remove('hidden');
                    showToast('Password generated successfully');
                }
            });
    });

    // Add IP
    document.getElementById('add-ip-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const ip = document.getElementById('ip-input').value;
        if (!ip) return;

        fetch('{{ route("admin.mobile-settings.add-ip", $exam) }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ ip })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('ip-input').value = '';
                location.reload();
            }
        });
    });

    // Delete IP
    document.querySelectorAll('.delete-ip')?.forEach(btn => {
        btn.addEventListener('click', function() {
            const ip = this.dataset.ip;
            if (confirm('Remove this IP?')) {
                fetch('{{ route("admin.mobile-settings.remove-ip", $exam) }}', {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ip })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) location.reload();
                });
            }
        });
    });
</script>
@endsection

@endsection
