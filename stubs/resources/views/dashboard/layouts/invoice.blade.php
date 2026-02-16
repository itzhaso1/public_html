<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="utf-8" />
		<title>فاتوره {{ $order?->order_number . '-' . $order?->user->name}}</title>

		<style>
            body{
                font-family: 'almarai', sans-serif;
            }
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'almarai', sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'almarai', sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}

            @page {
                header: page-header;
                footer: page-footer;
            }
		</style>
	</head>

	<body>
        <div class="invoice-box rtl">
            <table cellpadding="0" cellspacing="0">
                {{-- رأس الفاتورة --}}
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="text-end">
                                    رقم الطلب: {{ $order->order_number }}<br />
                                    @php
                                        $formattedTime = $order->created_at->format('Y-m-d h:i');
                                        $period = $order->created_at->format('A') === 'AM' ? 'صباحًا' : 'مساءً';
                                    @endphp
                                    تم الإنشاء: {{ $formattedTime . ' ' . $period }}<br />
                                    الدفع: {{ $data['payment_type'] }}
                                </td>
                                <td class="title text-end">
                                    <img src="{{ $logo }}" style="width: 100%; max-width: 200px" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- معلومات عامة --}}
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    {{ $order->user?->name }}<br />
                                    {{ $order->user?->phone }}<br />
                                    {{ $order->user?->email }}
                                </td>
                                <td>
                                    {{ $settings?->name }}<br />
                                    {{ $settings?->address }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- وسيلة الدفع --}}
                <tr class="heading">
                    <td>نوع الطلب</td>
                    <td>طريقة الدفع</td>
                </tr>
                <tr class="details">
                    <td class="text-end">{{ $order->is_delivery ? 'توصيل' : 'استلام من الفرع' }}</td>
                    <td class="text-end">{{ $data['payment_type'] }}</td>
                </tr>
                {{-- عناوين الأعمدة --}}
                <tr class="heading">
                    <td>المنتج</td>
                    <td>السعر</td>
                </tr>
                {{-- تفاصيل المنتجات --}}
                @foreach ($order->products as $product)
                    <tr class="item">
                        <td>
                            {{ $product->name }}<br />
                            الكمية: {{ $product->pivot->quantity }}<br />
                            الحجم: {{ $product->pivot->detail?->size?->name }} ({{ $product->pivot->detail?->size_price . ' ' . $settings?->currency }} )<br />
                            النوع: {{ $product->pivot->detail?->type?->name }} ({{ $product->pivot->detail?->type_price . ' ' . $settings?->currency }} )<br />
                            الإضافات:
                            <ul>
                                @foreach ($product->pivot->extras as $extra)
                                    <li>{{ $extra->extra?->name }} ({{ $extra->price . ' ' . $settings?->currency }} )</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $product->pivot->price * $product->pivot->quantity . ' ' . $settings?->currency }} </td>
                    </tr>
                @endforeach
                <tr class="">
                    <td>العنوان : {{$order?->order_location}}</td>
                    <td></td>
                </tr>
                {{-- الإجمالي --}}
                <tr class="total">
                    <td></td>
                    <td>الإجمالي: {{ $order->total_price . ' ' . $settings?->currency }} </td>
                </tr>
            </table>
        </div>
    </body>

</html>
