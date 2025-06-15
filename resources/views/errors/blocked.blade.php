<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Diblokir - Sistem SPK</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(-45deg, #0f0f0f, #1a0000, #2d0a0a, #1a0505);
            background-size: 400% 400%;
            animation: gradientWave 12s ease infinite;
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @keyframes gradientWave {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .geometric-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(220, 38, 38, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(239, 68, 68, 0.1) 0%, transparent 50%),
                linear-gradient(135deg, transparent 0%, rgba(185, 28, 28, 0.05) 50%, transparent 100%);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 4rem;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 1rem;
            }
        }

        .left-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 2rem;
        }

        .right-section {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            padding: 0 2rem;
        }

        .error-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            position: relative;
            animation: pulse 2s infinite;
            box-shadow: 0 0 40px rgba(220, 38, 38, 0.4);
        }

        .error-icon::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(45deg, transparent, rgba(220, 38, 38, 0.3), transparent);
            border-radius: 50%;
            animation: rotate 3s linear infinite;
            z-index: -1;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .main-title {
            font-size: 3.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #ffffff, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 1rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.8);
        }

        .subtitle {
            color: #d1d5db;
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .info-card {
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ef4444, transparent);
            transition: left 0.5s ease;
        }

        .info-card:hover::before {
            left: 100%;
        }

        .info-card:hover {
            transform: translateY(-5px);
            border-color: rgba(239, 68, 68, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .countdown-display {
            text-align: center;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(185, 28, 28, 0.2));
            border: 2px solid rgba(220, 38, 38, 0.3);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
        }

        .countdown-number {
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            margin: 1rem 0;
        }

        .floating-elements {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .floating-dot {
            position: absolute;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.6), transparent);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-dot:nth-child(1) {
            width: 20px;
            height: 20px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-dot:nth-child(2) {
            width: 15px;
            height: 15px;
            top: 60%;
            right: 20%;
            animation-delay: 2s;
        }

        .floating-dot:nth-child(3) {
            width: 25px;
            height: 25px;
            bottom: 30%;
            left: 80%;
            animation-delay: 4s;
        }

        .floating-dot:nth-child(4) {
            width: 12px;
            height: 12px;
            top: 40%;
            left: 70%;
            animation-delay: 1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .action-button {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
        }

        .action-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .action-button:hover::before {
            left: 100%;
        }

        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(220, 38, 38, 0.4);
        }

        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            background: #ef4444;
            border-radius: 50%;
            margin-right: 8px;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0.3;
            }
        }

        .section-title {
            color: #ef4444;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .info-list {
            color: #d1d5db;
            line-height: 1.8;
        }

        .info-list li {
            margin-bottom: 0.5rem;
            padding-left: 1rem;
            position: relative;
        }

        .info-list li::before {
            content: '▶';
            position: absolute;
            left: 0;
            color: #ef4444;
            font-size: 0.8rem;
        }

        .ip-display {
            background: rgba(0, 0, 0, 0.5);
            color: #f87171;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            border: 1px solid rgba(248, 113, 113, 0.3);
        }
    </style>
</head>

<body>
    <!-- Geometric Background -->
    <div class="geometric-bg"></div>

    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-dot"></div>
        <div class="floating-dot"></div>
        <div class="floating-dot"></div>
        <div class="floating-dot"></div>
    </div>

    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="error-icon">
                <i class="fas fa-ban text-white text-5xl"></i>
            </div>

            <h1 class="main-title">AKSES DIBLOKIR</h1>
            <p class="subtitle">Sistem keamanan telah mendeteksi aktivitas mencurigakan</p>

            <div class="countdown-display">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-clock text-yellow-400 text-2xl mr-3"></i>
                    <span class="text-yellow-300 text-xl font-semibold">Waktu Blokir Tersisa</span>
                </div>
                <div class="countdown-number" id="countdown">{{ $minutes }} menit</div>
                <p class="text-yellow-400 text-sm">Akses akan dipulihkan secara otomatis</p>
            </div>

            <button class="action-button w-full" onclick="window.location.reload()" id="refreshBtn">
                <i class="fas fa-sync-alt mr-2"></i>
                Periksa Status Akses
            </button>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <!-- IP Info Card -->
            <div class="info-card">
                <h3 class="section-title">
                    <span class="status-indicator"></span>
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Status Blokir
                </h3>
                <p class="text-gray-300 mb-4">
                    IP Address Anda telah diblokir karena terlalu banyak percobaan login yang gagal.
                </p>
                <div class="ip-display">
                    <i class="fas fa-network-wired mr-2"></i>
                    IP: {{ $ip }}
                </div>
            </div>

            <!-- Security Info Card -->
            <div class="info-card">
                <h3 class="section-title">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Mengapa Akses Diblokir?
                </h3>
                <ul class="info-list">
                    <li>Maksimal 5 percobaan login gagal dalam 1 sesi</li>
                    <li>Melindungi sistem dari serangan brute force</li>
                    <li>Menjaga keamanan data dan akun pengguna</li>
                    <li>Mencegah akses tidak sah ke sistem</li>
                </ul>
            </div>

            <!-- Action Guide Card -->
            <div class="info-card">
                <h3 class="section-title">
                    <i class="fas fa-lightbulb mr-2"></i>
                    Langkah Selanjutnya
                </h3>
                <ul class="info-list">
                    <li>Tunggu hingga waktu blokir berakhir</li>
                    <li>Pastikan kredensial login Anda benar</li>
                    <li>Gunakan fitur lupa password jika diperlukan</li>
                    <li>Hubungi administrator jika masih bermasalah</li>
                </ul>
            </div>

            <!-- Help Card -->
            <div class="info-card">
                <h3 class="section-title">
                    <i class="fas fa-question-circle mr-2"></i>
                    Butuh Bantuan?
                </h3>
                <p class="text-gray-300">
                    Jika Anda mengalami kesulitan atau memerlukan bantuan lebih lanjut,
                    silakan hubungi administrator sistem untuk mendapatkan dukungan teknis.
                </p>
                <div class="mt-4 text-center">
                    <span class="text-gray-400 text-sm">
                        <i class="fas fa-clock mr-1"></i>
                        Blokir dimulai: <span id="blockTime"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set block time
        document.getElementById('blockTime').textContent = new Date().toLocaleString('id-ID');

        // Auto refresh every 30 seconds to check if block is lifted
        let refreshInterval;

        function startAutoRefresh() {
            refreshInterval = setInterval(function() {
                window.location.reload();
            }, 30000); // 30 seconds
        }

        // Start auto refresh
        startAutoRefresh();

        let countdownMinutes = parseInt('{{ $minutes }}');
        const countdownElement = document.getElementById('countdown');

        function updateCountdown() {
            if (countdownMinutes > 0) {
                countdownElement.textContent = countdownMinutes + ' menit';
                countdownMinutes--;
            } else {
                countdownElement.textContent = 'Memuat ulang...';
                clearInterval(countdownInterval);
                window.location.reload();
            }
        }

        // Update countdown every minute
        const countdownInterval = setInterval(updateCountdown, 60000);

        // Prevent back button
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };

        // Add parallax effect to floating elements
        document.addEventListener('mousemove', function(e) {
            const dots = document.querySelectorAll('.floating-dot');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            dots.forEach((dot, index) => {
                const speed = (index + 1) * 0.5;
                const xOffset = (x - 0.5) * speed * 20;
                const yOffset = (y - 0.5) * speed * 20;
                dot.style.transform = `translate(${xOffset}px, ${yOffset}px)`;
            });
        });

        // Add scroll reveal effect for cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all info cards
        document.querySelectorAll('.info-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>

</html>