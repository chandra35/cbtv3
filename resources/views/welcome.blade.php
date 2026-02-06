<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT v3 - Computer-Based Testing System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .feature-card {
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .scroll-smooth {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="scroll-smooth">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-pink-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-laptop text-white text-lg"></i>
                </div>
                <span class="text-2xl font-bold gradient-text">CBT v3</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="#features" class="text-gray-700 hover:text-purple-600 transition">Features</a>
                <a href="#about" class="text-gray-700 hover:text-purple-600 transition">About</a>
                <a href="{{ route('login') }}" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg min-h-screen flex items-center justify-center pt-20 pb-12 text-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    Transform Education with <span class="text-yellow-300">CBT</span>
                </h1>
                <p class="text-xl text-gray-100 mb-8">
                    A comprehensive Computer-Based Testing system that revolutionizes the way you conduct exams. Secure, scalable, and student-friendly.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-purple-600 font-bold rounded-lg hover:bg-gray-100 transition text-center">
                        Get Started
                    </a>
                    <a href="#features" class="px-8 py-3 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-purple-600 transition text-center">
                        Learn More
                    </a>
                </div>
                <div class="mt-12 flex items-center gap-8">
                    <div>
                        <p class="text-3xl font-bold">1000+</p>
                        <p class="text-gray-100">Students Tested</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold">500+</p>
                        <p class="text-gray-100">Questions</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold">99.9%</p>
                        <p class="text-gray-100">Uptime</p>
                    </div>
                </div>
            </div>

            <!-- Right Image/Illustration -->
            <div class="text-center">
                <div class="bg-white bg-opacity-10 rounded-2xl p-12 backdrop-blur-sm border border-white border-opacity-20">
                    <i class="fas fa-laptop text-9xl text-yellow-300 opacity-80"></i>
                    <p class="text-xl text-gray-200 mt-6">Modern Testing Platform</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Powerful Features</h2>
                <p class="text-xl text-gray-600">Everything you need to manage comprehensive testing</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1: Exam Management -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-file-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Exam Management</h3>
                    <p class="text-gray-600">Create, schedule, and manage exams with flexible configurations. Support multiple exam types and customizable settings.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Create custom exams</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Schedule exams</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Multiple exam types</li>
                    </ul>
                </div>

                <!-- Feature 2: Question Bank -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-question-circle text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Question Bank</h3>
                    <p class="text-gray-600">Organize and manage questions with multiple question types. Support for images, explanations, and bulk imports.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>5 question types</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Bulk import</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Rich editor</li>
                    </ul>
                </div>

                <!-- Feature 3: Security -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Advanced Security</h3>
                    <p class="text-gray-600">Protect exam integrity with multiple security features including password protection and anti-cheating measures.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Password protection</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>IP whitelist</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Anti-cheating</li>
                    </ul>
                </div>

                <!-- Feature 4: Analytics -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-bar text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Analytics & Reports</h3>
                    <p class="text-gray-600">Comprehensive analytics dashboard with detailed reports on exam performance and student progress.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Real-time dashboard</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Performance reports</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>CSV export</li>
                    </ul>
                </div>

                <!-- Feature 5: Mobile Support -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Mobile Ready</h3>
                    <p class="text-gray-600">Fully responsive design works seamlessly on tablets and smartphones. Take exams from anywhere.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Responsive design</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Mobile optimized</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Offline support</li>
                    </ul>
                </div>

                <!-- Feature 6: RBAC -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-users-cog text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Role Management</h3>
                    <p class="text-gray-600">Fine-grained role-based access control with 7 predefined roles and 40+ permissions for complete control.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>7 built-in roles</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>40+ permissions</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Granular control</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 gradient-bg text-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-5xl font-bold mb-2">22+</div>
                    <div class="text-lg text-gray-100">Git Commits</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">17</div>
                    <div class="text-lg text-gray-100">Database Tables</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">5,500+</div>
                    <div class="text-lg text-gray-100">Lines of Code</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">100%</div>
                    <div class="text-lg text-gray-100">Open Source</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">About CBT v3</h2>
                    <p class="text-gray-600 mb-4">
                        CBT v3 is a modern, comprehensive Computer-Based Testing system built with Laravel 12. It provides educators and institutions with a powerful platform to conduct secure, fair, and efficient examinations.
                    </p>
                    <p class="text-gray-600 mb-6">
                        With over 5,500 lines of carefully crafted code, CBT v3 includes a complete admin panel, API layer, and advanced security features to ensure the integrity of your testing process.
                    </p>
                    <div class="space-y-3">
                        <p class="text-gray-700"><span class="font-bold">Built with:</span> Laravel 12, MySQL, Blade, Tailwind CSS</p>
                        <p class="text-gray-700"><span class="font-bold">Features:</span> RBAC, API, Security, Analytics, Mobile Support</p>
                        <p class="text-gray-700"><span class="font-bold">Status:</span> Production Ready</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-12">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Production Ready</h4>
                                <p class="text-gray-600 text-sm">Fully tested and deployed</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-code text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Open Source</h4>
                                <p class="text-gray-600 text-sm">Available on GitHub</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-rocket text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Actively Developed</h4>
                                <p class="text-gray-600 text-sm">Regular updates and improvements</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Transform Your Testing?</h2>
            <p class="text-xl text-gray-100 mb-8">
                Start using CBT v3 today and experience a modern approach to computer-based testing.
            </p>
            <a href="{{ route('login') }}" class="inline-block px-10 py-4 bg-white text-purple-600 font-bold rounded-lg hover:bg-gray-100 transition text-lg">
                Login to Dashboard
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-laptop text-purple-500 text-xl"></i>
                        <span class="text-white font-bold">CBT v3</span>
                    </div>
                    <p class="text-sm">Modern Computer-Based Testing System</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-white">Features</a></li>
                        <li><a href="#about" class="hover:text-white">About</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://github.com/chandra35/cbtv3" target="_blank" class="hover:text-white">GitHub</a></li>
                        <li><a href="#" class="hover:text-white">Documentation</a></li>
                        <li><a href="#" class="hover:text-white">Support</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Email: info@cbt.local</li>
                        <li>Status: Online</li>
                        <li>Version: 1.0</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2026 CBT v3. All rights reserved. Built with <i class="fas fa-heart text-red-500"></i> by DevTeam</p>
            </div>
        </div>
    </footer>
</body>
</html>
