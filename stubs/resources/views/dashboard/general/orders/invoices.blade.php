{{--<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $locale == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <title>{{ trans('dashboard/invoce.invoice') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }

        .invoice-box {
            padding: 30px;
            border: 1px solid #eee;
        }

        .logo {
            width: 120px;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th,
        .table td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .table th {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table width="100%">
            <tr>
                <td>
                    <img src="{{ public_path('assets/logo.png') }}" class="logo">
                </td>
                <td class="{{ $locale == 'ar' ? 'text-left' : 'text-right' }}">
                    <h3>{{ trans('dashboard/invoce.invoice') }}</h3>
                    <p>{{ trans('dashboard/invoce.order_number') }}: {{ $order->number }}</p>
                    <p>{{ trans('dashboard/invoce.date') }}: {{ $order->created_at->format('Y-m-d') }}</p>
                </td>
            </tr>
        </table>

        <hr>

        <h4>{{ trans('dashboard/invoce.customer_information') }}</h4>
        <p>
            {{ $order->user->name ?? trans('dashboard/invoce.guest') }}<br>
            {{ $order->addresses->first()?->address ?? '' }}
        </p>

        <h4>{{ trans('dashboard/invoce.order_details') }}</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ trans('dashboard/invoce.product') }}</th>
                    <th>{{ trans('dashboard/invoce.price') }}</th>
                    <th>{{ trans('dashboard/invoce.qty') }}</th>
                    <th>{{ trans('dashboard/invoce.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                <tr>
                    <td>
                        <div>{{ $product->pivot->product_name ?? $product->name }}</div>
                        @php
                        $image = $product->getMediaUrl('product', $product, null, 'media', 'product');
                        @endphp
                        @if($image)
                        <img src="{{ public_path($image) }}" width="50" alt="">
                        @endif
                    </td>
                    <td>{{ number_format($product->pivot->product_price, 2) }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->pivot->product_price * $product->pivot->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="text-right">
            {{ trans('dashboard/invoce.total') }}: {{ number_format($order->products->sum(fn($p) => $p->pivot->product_price *
            $p->pivot->quantity), 2) }} 
        </h4>
    </div>
</body>

</html>--}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('Invoice') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;

            direction: {
                    {
                    app()->getLocale()=='ar' ? 'rtl': 'ltr'
                }
            }

            ;
        }

        .header,
        .footer {
            text-align: center;
        }

        .header img {
            width: 120px;
        }

        .invoice-box {
            padding: 20px;
            border: 1px solid #eee;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ $logo }}" alt="Logo">
        <h2>{{ $site_name }}</h2>
        <p>{{ $site_url }} | {{ $site_phone ?? '' }} | {{ $site_email ?? '' }}</p>
    </div>

    <div class="invoice-box">
        <h3>{{ __('Invoice #') }} {{ $order->id }}</h3>
        <p><strong>{{ __('Customer') }}:</strong> {{ $order->user->name ?? __('Guest') }}</p>
        <p><strong>{{ __('Date') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Product') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Qty') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->pivot->price, 2) }}</td>
                    <td>{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="text-right"><strong>{{ __('Subtotal') }}:</strong> {{ number_format($order->total_price, 2) }}</p>
        @if($order->coupon)
        <p class="text-right"><strong>{{ __('Discount') }}:</strong> -{{ number_format($order->coupon->discount_amount,
            2) }}</p>
        @endif
        <p class="text-right"><strong>{{ __('Total') }}:</strong> {{ number_format($order->final_price, 2) }}</p>
    </div>

    <div class="footer">
        <p>{{ __('Thank you for your purchase!') }}</p>
    </div>

</body>

</html>