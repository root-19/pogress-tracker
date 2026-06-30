<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Progress Tracking System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

            body {
                font-family: 'Inter', sans-serif;
                color: #1e1b4b;
            }

            .violet-gradient {
                background:
                    radial-gradient(circle at 12% 18%, rgba(167, 139, 250, 0.55) 0%, transparent 45%),
                    radial-gradient(circle at 88% 12%, rgba(99, 102, 241, 0.55) 0%, transparent 45%),
                    radial-gradient(circle at 75% 85%, rgba(236, 72, 153, 0.30) 0%, transparent 50%),
                    linear-gradient(135deg, #4c1d95 0%, #6d28d9 40%, #7c3aed 70%, #8b5cf6 100%);
                background-attachment: fixed;
                min-height: 100vh;
            }

            /* Navbar */
            .top-nav {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1.25rem 0;
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 0.65rem;
                color: #fff;
                font-weight: 800;
                font-size: 1.2rem;
                text-decoration: none;
                letter-spacing: 0.3px;
            }

            .brand-mark {
                width: 40px;
                height: 40px;
                border-radius: 0.75rem;
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(10px);
            }

            .nav-link-custom {
                color: rgba(255, 255, 255, 0.92);
                text-decoration: none;
                font-weight: 600;
                transition: all 0.2s ease;
                padding: 0.5rem 1.1rem;
                border-radius: 0.75rem;
            }

            .nav-link-custom:hover {
                color: white;
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
            }

            /* Hero */
            .hero-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background: rgba(255, 255, 255, 0.15);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: #fff;
                font-weight: 600;
                font-size: 0.8rem;
                padding: 0.4rem 1rem;
                border-radius: 999px;
                backdrop-filter: blur(10px);
                letter-spacing: 0.4px;
            }

            .main-icon-box {
                width: 110px;
                height: 110px;
                background: rgba(255, 255, 255, 0.22);
                backdrop-filter: blur(15px);
                border-radius: 1.75rem;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.3);
                animation: float 6s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-18px); }
            }

            .heading-gradient {
                background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .subtitle-text {
                color: rgba(255, 255, 255, 0.92);
                font-weight: 300;
                letter-spacing: 0.3px;
                max-width: 620px;
                margin-inline: auto;
            }

            .btn-start {
                background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
                color: #4c1d95;
                font-weight: 700;
                padding: 0.9rem 2.5rem;
                border-radius: 3rem;
                border: 2px solid rgba(255, 255, 255, 0.5);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                text-transform: uppercase;
                letter-spacing: 1px;
                font-size: 0.85rem;
                text-decoration: none;
                display: inline-block;
            }

            .btn-start:hover {
                transform: translateY(-3px) scale(1.04);
                box-shadow: 0 20px 35px -5px rgba(0, 0, 0, 0.35);
                color: #4c1d95;
            }

            .btn-ghost {
                background: rgba(255, 255, 255, 0.12);
                color: #fff;
                font-weight: 700;
                padding: 0.9rem 2.2rem;
                border-radius: 3rem;
                border: 2px solid rgba(255, 255, 255, 0.4);
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 1px;
                font-size: 0.85rem;
                text-decoration: none;
                display: inline-block;
                backdrop-filter: blur(10px);
            }

            .btn-ghost:hover {
                background: rgba(255, 255, 255, 0.22);
                color: #fff;
                transform: translateY(-3px);
            }

            /* Stats band */
            .stats-band {
                background: rgba(255, 255, 255, 0.12);
                border: 1px solid rgba(255, 255, 255, 0.25);
                border-radius: 1.5rem;
                backdrop-filter: blur(14px);
                padding: 1.75rem 1rem;
            }

            .stat-value {
                font-size: 2.4rem;
                font-weight: 800;
                color: #fff;
                line-height: 1;
            }

            .stat-label {
                color: rgba(255, 255, 255, 0.85);
                font-weight: 500;
                font-size: 0.85rem;
                letter-spacing: 0.5px;
            }

            .stat-divider {
                width: 1px;
                background: rgba(255, 255, 255, 0.25);
            }

            /* Feature cards */
            .card-custom {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                border-radius: 1.5rem;
                border: 1px solid rgba(255, 255, 255, 0.6);
                box-shadow: 0 1px 2px rgba(16, 8, 48, 0.06), 0 16px 32px -14px rgba(76, 29, 149, 0.3);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .card-custom::before {
                content: '';
                position: absolute;
                inset: 0 0 auto 0;
                height: 5px;
                background: var(--accent, linear-gradient(90deg, #8b5cf6, #6366f1));
            }

            .card-custom:hover {
                transform: translateY(-8px);
                box-shadow: 0 4px 6px -2px rgba(16, 8, 48, 0.08), 0 30px 50px -16px rgba(76, 29, 149, 0.45);
            }

            .icon-box {
                width: 64px;
                height: 64px;
                background: var(--accent, linear-gradient(135deg, #6366f1, #8b5cf6));
                border-radius: 1.1rem;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 10px 18px -6px rgba(99, 102, 241, 0.45);
                transition: transform 0.3s ease;
            }

            .card-custom:hover .icon-box {
                transform: scale(1.08) rotate(-4deg);
            }

            .card-title {
                color: #1e1b4b;
                font-weight: 700;
            }

            .card-text {
                color: #4b5563;
                line-height: 1.7;
            }

            .footer-text {
                color: rgba(255, 255, 255, 0.85);
                font-weight: 500;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="violet-gradient d-flex flex-column min-vh-100 position-relative">
            <div class="container py-4">
                <!-- Nav -->
                <nav class="top-nav">
                    <a href="{{ url('/') }}" class="brand">
                        <span class="brand-mark">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="white" style="width: 22px; height: 22px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </span>
                        Progress Tracking
                    </a>
                    <div class="d-none d-sm-flex align-items-center gap-2">
                        <a href="{{ url('/') }}" class="nav-link-custom">Home</a>
                        <a href="{{ url('/modules') }}" class="nav-link-custom">Modules</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="nav-link-custom">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="nav-link-custom">Log in</a>
                            @endauth
                        @endif
                    </div>
                </nav>

                <!-- Hero -->
                <div class="text-center py-5">
                    <div class="d-flex justify-content-center mb-4">
                        <div class="main-icon-box">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" style="width: 56px; height: 56px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </div>
                    </div>

                    <span class="hero-badge mb-4">✨ Organize · Track · Achieve</span>

                    <h1 class="display-3 fw-bold heading-gradient mb-3 mt-3">Progress Tracking</h1>
                    <p class="lead subtitle-text fs-5 mb-4">
                        Monitor your goals, track your achievements, and reach your potential — all in one beautiful, organized workspace.
                    </p>

                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ url('/modules') }}" class="btn-start">Start Tracking</a>
                        <a href="{{ url('/modules') }}" class="btn-ghost">View Modules</a>
                    </div>
                </div>

                <!-- Stats band -->
                @php
                    $completionRate = $taskCount > 0 ? round($completedCount / $taskCount * 100) : 0;
                @endphp
                <div class="stats-band mb-5">
                    <div class="row text-center align-items-center g-0">
                        <div class="col">
                            <div class="stat-value">{{ $moduleCount }}</div>
                            <div class="stat-label">Modules</div>
                        </div>
                        <div class="col-auto stat-divider align-self-stretch d-none d-sm-block">&nbsp;</div>
                        <div class="col">
                            <div class="stat-value">{{ $taskCount }}</div>
                            <div class="stat-label">Total Tasks</div>
                        </div>
                        <div class="col-auto stat-divider align-self-stretch d-none d-sm-block">&nbsp;</div>
                        <div class="col">
                            <div class="stat-value">{{ $completedCount }}</div>
                            <div class="stat-label">Completed</div>
                        </div>
                        <div class="col-auto stat-divider align-self-stretch d-none d-sm-block">&nbsp;</div>
                        <div class="col">
                            <div class="stat-value">{{ $completionRate }}%</div>
                            <div class="stat-label">Completion</div>
                        </div>
                    </div>
                </div>

                <!-- Feature cards -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card-custom p-4 p-lg-5 h-100" style="--accent: linear-gradient(135deg, #6366f1, #8b5cf6);">
                            <div class="icon-box mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" style="width: 32px; height: 32px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                </svg>
                            </div>
                            <h2 class="h3 card-title mb-3">Goal Setting</h2>
                            <p class="card-text mb-0">
                                Set clear, achievable goals with milestones and deadlines. Track your progress visually and stay motivated on your journey to success.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card-custom p-4 p-lg-5 h-100" style="--accent: linear-gradient(135deg, #ec4899, #f472b6);">
                            <div class="icon-box mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" style="width: 32px; height: 32px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                                </svg>
                            </div>
                            <h2 class="h3 card-title mb-3">Progress Analytics</h2>
                            <p class="card-text mb-0">
                                Visualize your progress with detailed charts and statistics. Analyze trends, identify patterns, and make data-driven decisions to improve.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card-custom p-4 p-lg-5 h-100" style="--accent: linear-gradient(135deg, #10b981, #34d399);">
                            <div class="icon-box mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" style="width: 32px; height: 32px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                            <h2 class="h3 card-title mb-3">Milestone Tracking</h2>
                            <p class="card-text mb-0">
                                Break down large goals into smaller milestones. Celebrate achievements along the way and maintain momentum toward your ultimate objectives.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card-custom p-4 p-lg-5 h-100" style="--accent: linear-gradient(135deg, #f59e0b, #fbbf24);">
                            <div class="icon-box mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" style="width: 32px; height: 32px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            <h2 class="h3 card-title mb-3">Team Collaboration</h2>
                            <p class="card-text mb-0">
                                Share progress with your team, assign tasks, and collaborate effectively. Keep everyone aligned and motivated toward common goals.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row mt-5 pt-3 gap-2">
                    <span class="fw-medium footer-text">Progress Tracking System</span>
                    <span class="footer-text">&copy; {{ date('Y') }} Progress Tracking</span>
                </div>
            </div>
        </div>
    </body>
</html>
