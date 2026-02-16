

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings?->name }} | @yield('pageTitle')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="/img/t.png" type="image/png">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f1f1f1;
            color: #1F2937;
        }

        .swiper-container {
            overflow: hidden;
        }

        .swiper-slide img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 0.5rem;
            display: block;
        }

        .product-img {
            width: 100%;
            aspect-ratio: 2 / 1;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        nav {
            background-color: #000;
            color: #fff;
            padding: 0.5rem 1rem;
            border-bottom: 1.5px solid #ff0000;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .btn-primary {
            background-color: #000;
            color: #fff;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            width: 100%;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #FBBF24;
            color: #000;
        }

        footer {
            background-color: #000;
            color: #fff;
            padding: 1.5rem;
            width: 100%;
        }

        footer .payment-icons img {
            height: 30px;
            margin-right: 0.5rem;
        }

        .marquee {
            display: inline-flex;
            gap: 2rem;
            width: max-content;
            animation: marquee 20s linear infinite;
            direction: rtl;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .currency-btn {
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .currency-btn:hover {
            transform: scale(1.2);
        }

        /* الشارات */
        .badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            font-size: 0.75rem;
            font-weight: bold;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
        }

        .badge-sold {
            background-color: #dc2626;
            color: #fff;
        }

        .badge-sale {
            background-color: #facc15;
            color: #000;
        }
    </style>
    </head>

    <body>
