<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شحن الجواهر</title>
    <style>
        body {
            font-family: 'Tajawal', sans-serif; /* خط عربي جميل إذا كان متاحاً */
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .page-title {
            text-align: center;
            margin: 40px 0;
            color: #333;
            font-size: 2.5rem;
            font-weight: bold;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 10px;
        }
        .product-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .product-title {
            font-size: 1.3em;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .product-desc {
            color: #7f8c8d;
            font-size: 0.9em;
            margin-bottom: 15px;
            min-height: 40px;
        }
        .product-price {
            color: #27ae60;
            font-weight: bold;
            font-size: 1.4em;
            margin: 15px 0;
        }
        .buy-btn {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            display: inline-block;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
        }
        .buy-btn:hover {
            background: linear-gradient(45deg, #2980b9, #3498db);
            box-shadow: 0 2px 10px rgba(52, 152, 219, 0.3);
        }
        .empty-state {
            text-align: center;
            padding: 60px;
            color: #95a5a6;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
 
    <div class="container">
        <h1 class="page-title">💎 شحن الجواهر</h1>
 
        @if(isset($products) && count($products) > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div>
                            <!-- اسم المنتج -->
                            <div class="product-title">{{ $product->name ?? 'باقة شحن' }}</div>
                            
                            <!-- وصف المنتج -->
                            <p class="product-desc">{{ $product->description ?? 'شحن فوري وآمن' }}</p>
                            
                            <!-- السعر -->
                            <div class="product-price">{{ number_format($product->price, 2) }} ر.س</div>
                        </div>
                        
                        <!-- زر الشراء -->
                        <!-- نستخدم product->id لأن البيانات قادمة من Query Builder -->
                        <div>
                            <a href="{{ route('website.product.show', $product->id) }}" class="buy-btn">
                                شراء الآن 🛒
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <p>عفواً، لا توجد باقات شحن متاحة حالياً.</p>
            </div>
        @endif
    </div>
 
</body>
</html>