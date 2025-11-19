<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Warung Kopi Otomatis</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}?v={{ time() }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}?v={{ time() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #2d2d2d;
            --accent-color: #c9a961;
            --accent-hover: #d4b574;
            --text-dark: #1a1a1a;
            --text-muted: #6c757d;
            --bg-light: #f5f5f5;
        }
        
        body {
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
        }
        
        /* Navbar Elegant Black */
        .navbar-custom {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid var(--accent-color);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: #ffffff !important;
            text-shadow: 0 2px 10px rgba(201, 169, 97, 0.3);
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            color: var(--accent-color) !important;
            transform: scale(1.05);
        }
        
        .navbar-brand i {
            color: var(--accent-color);
            filter: drop-shadow(0 0 8px rgba(201, 169, 97, 0.5));
        }
        
        .nav-link {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 4px;
            padding: 8px 16px !important;
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            position: relative;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover {
            background-color: rgba(201, 169, 97, 0.15);
            color: #ffffff !important;
            transform: translateY(-2px);
        }
        
        .nav-link:hover::before {
            width: 80%;
        }
        
        .nav-link.active {
            background: linear-gradient(135deg, rgba(201, 169, 97, 0.2), rgba(201, 169, 97, 0.3));
            color: var(--accent-color) !important;
            box-shadow: 0 4px 15px rgba(201, 169, 97, 0.2);
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            border-radius: 12px;
            margin-top: 8px;
            background: #ffffff;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 4px 8px;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(201, 169, 97, 0.1), rgba(201, 169, 97, 0.15));
            transform: translateX(5px);
        }
        
        /* Cards Elegant */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
            overflow: hidden;
            position: relative;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-color), var(--accent-hover));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
        }
        
        .card:hover::before {
            opacity: 1;
        }
        
        .card-header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border: none;
            padding: 16px 24px;
            font-weight: 600;
        }
        
        /* Buttons Elegant */
        .btn {
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
            color: #1a1a1a;
            font-weight: 700;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-hover), var(--accent-color));
            color: #000000;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #5a6268);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: #1a1a1a;
            font-weight: 700;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }
        
        /* Alerts Elegant */
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-left: 4px solid;
            backdrop-filter: blur(10px);
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
            border-left-color: #28a745;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(200, 35, 51, 0.1));
            border-left-color: #dc3545;
        }
        
        /* Table Elegant */
        .table {
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table thead {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
        }
        
        .table thead th {
            border: none;
            padding: 16px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(201, 169, 97, 0.05), rgba(201, 169, 97, 0.1));
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
        }
        
        /* Badge Elegant */
        .badge {
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        /* Form Controls */
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(201, 169, 97, 0.15);
        }
        
        /* Main Content */
        main {
            min-height: calc(100vh - 70px);
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--accent-hover), var(--accent-color));
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-cup-hot-fill"></i> Warung Kopi Otomatis
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    @if(session('user_role') === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people"></i> User
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                <i class="bi bi-tags"></i> Kategori
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <i class="bi bi-cup-hot"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-cart-check"></i> Pesanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                            <i class="bi bi-bar-chart"></i> Laporan
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ session('user_name') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text">
                                    <small class="text-muted">{{ ucfirst(session('user_role')) }}</small>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container-fluid">
            <!-- Success Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Error Alert -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/pusher.min.js') }}"></script>
    <script>
        // Notifikasi Real-time untuk Pesanan Baru
        @if(config('broadcasting.default') === 'pusher')
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
        });

        const channel = pusher.subscribe('orders');
        channel.bind('new-order', function(data) {
            // Tampilkan notifikasi
            const notification = document.createElement('div');
            notification.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3';
            notification.style.zIndex = '9999';
            notification.innerHTML = `
                <strong><i class="bi bi-bell-fill"></i> Pesanan Baru!</strong><br>
                ${data.customer_name} memesan ${data.product_name} (${data.quantity}x)<br>
                <small>Total: Rp ${new Intl.NumberFormat('id-ID').format(data.total_price)}</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(notification);

            // Auto dismiss after 10 seconds
            setTimeout(() => {
                notification.remove();
            }, 10000);
        });
        @endif
    </script>
    @stack('scripts')
</body>
</html>
