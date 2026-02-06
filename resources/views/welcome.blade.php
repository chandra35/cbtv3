<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT v3 - Sistem Ujian Berbasis Komputer</title>
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
                <a href="#features" class="text-gray-700 hover:text-purple-600 transition">Fitur</a>
                <a href="#about" class="text-gray-700 hover:text-purple-600 transition">Tentang</a>
                <a href="{{ route('login') }}" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:shadow-lg transition">
                    Masuk
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
                    Transformasi Pendidikan dengan <span class="text-yellow-300">CBT</span>
                </h1>
                <p class="text-xl text-gray-100 mb-8">
                    Sistem ujian berbasis komputer yang komprehensif untuk merevolusi cara Anda menyelenggarakan ujian. Aman, skalabel, dan ramah siswa.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-purple-600 font-bold rounded-lg hover:bg-gray-100 transition text-center">
                        Mulai Sekarang
                    </a>
                    <a href="#features" class="px-8 py-3 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-purple-600 transition text-center">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
                <div class="mt-12 flex items-center gap-8">
                    <div>
                        <p class="text-3xl font-bold">1000+</p>
                        <p class="text-gray-100">Siswa Teruji</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold">500+</p>
                        <p class="text-gray-100">Pertanyaan</p>
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
                    <p class="text-xl text-gray-200 mt-6">Platform Ujian Modern</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600">Semua yang Anda butuhkan untuk mengelola ujian komprehensif</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1: Exam Management -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-file-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Ujian</h3>
                    <p class="text-gray-600">Buat, jadwalkan, dan kelola ujian dengan konfigurasi fleksibel. Mendukung berbagai jenis ujian dan pengaturan yang dapat disesuaikan.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Buat ujian khusus</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Jadwalkan ujian</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Berbagai jenis ujian</li>
                    </ul>
                </div>

                <!-- Feature 2: Question Bank -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-question-circle text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Bank Soal</h3>
                    <p class="text-gray-600">Kelola dan atur soal dengan berbagai jenis pertanyaan. Dukungan untuk gambar, penjelasan, dan impor massal.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>5 jenis soal</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Impor massal</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Editor kaya fitur</li>
                    </ul>
                </div>

                <!-- Feature 3: Security -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Keamanan Lanjutan</h3>
                    <p class="text-gray-600">Lindungi integritas ujian dengan fitur keamanan ganda termasuk perlindungan kata sandi dan langkah anti-kecurangan.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Perlindungan kata sandi</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Daftar IP putih</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Anti-kecurangan</li>
                    </ul>
                </div>

                <!-- Feature 4: Analytics -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-bar text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Analitik & Laporan</h3>
                    <p class="text-gray-600">Dasbor analitik komprehensif dengan laporan terperinci tentang kinerja ujian dan kemajuan siswa.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Dasbor real-time</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Laporan kinerja</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Ekspor CSV</li>
                    </ul>
                </div>

                <!-- Feature 5: Mobile Support -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Siap Mobile</h3>
                    <p class="text-gray-600">Desain fully responsive bekerja mulus di tablet dan smartphone. Ambil ujian dari mana saja.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Desain responsif</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Dioptimalkan mobile</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Dukungan offline</li>
                    </ul>
                </div>

                <!-- Feature 6: RBAC -->
                <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-users-cog text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen Peran</h3>
                    <p class="text-gray-600">Kontrol akses berbasis peran yang detail dengan 7 peran yang telah ditentukan dan 40+ izin untuk kontrol penuh.</p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-600">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>7 peran bawaan</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>40+ izin</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Kontrol granular</li>
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
                    <div class="text-lg text-gray-100">Tabel Database</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">5,500+</div>
                    <div class="text-lg text-gray-100">Baris Kode</div>
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
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Tentang CBT v3</h2>
                    <p class="text-gray-600 mb-4">
                        CBT v3 adalah sistem ujian berbasis komputer modern dan komprehensif yang dibangun dengan Laravel 12. Ini menyediakan pendidik dan institusi dengan platform yang kuat untuk menyelenggarakan ujian yang aman, adil, dan efisien.
                    </p>
                    <p class="text-gray-600 mb-6">
                        Dengan lebih dari 5.500 baris kode yang dirancang dengan hati-hati, CBT v3 mencakup panel admin lengkap, lapisan API, dan fitur keamanan canggih untuk memastikan integritas proses pengujian Anda.
                    </p>
                    <div class="space-y-3">
                        <p class="text-gray-700"><span class="font-bold">Dibangun dengan:</span> Laravel 12, MySQL, Blade, Tailwind CSS</p>
                        <p class="text-gray-700"><span class="font-bold">Fitur:</span> RBAC, API, Keamanan, Analitik, Dukungan Mobile</p>
                        <p class="text-gray-700"><span class="font-bold">Status:</span> Siap Produksi</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-12">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Siap Produksi</h4>
                                <p class="text-gray-600 text-sm">Sepenuhnya diuji dan digunakan</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-code text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Open Source</h4>
                                <p class="text-gray-600 text-sm">Tersedia di GitHub</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-rocket text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Dikembangkan Secara Aktif</h4>
                                <p class="text-gray-600 text-sm">Pembaruan dan peningkatan rutin</p>
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
            <h2 class="text-4xl font-bold mb-6">Siap Mengubah Ujian Anda?</h2>
            <p class="text-xl text-gray-100 mb-8">
                Mulai gunakan CBT v3 hari ini dan rasakan pendekatan modern untuk ujian berbasis komputer.
            </p>
            <a href="{{ route('login') }}" class="inline-block px-10 py-4 bg-white text-purple-600 font-bold rounded-lg hover:bg-gray-100 transition text-lg">
                Masuk ke Dasbor
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
                    <p class="text-sm">Sistem Ujian Berbasis Komputer Modern</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-white">Fitur</a></li>
                        <li><a href="#about" class="hover:text-white">Tentang</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white">Masuk</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Sumber Daya</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://github.com/chandra35/cbtv3" target="_blank" class="hover:text-white">GitHub</a></li>
                        <li><a href="#" class="hover:text-white">Dokumentasi</a></li>
                        <li><a href="#" class="hover:text-white">Dukungan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Email: info@cbt.local</li>
                        <li>Status: Online</li>
                        <li>Versi: 1.0</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2026 CBT v3. Semua hak dilindungi. Dibuat dengan <i class="fas fa-heart text-red-500"></i> oleh DevTeam</p>
            </div>
        </div>
    </footer>
</body>
</html>
