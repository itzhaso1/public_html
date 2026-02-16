@php
    $sessionKey = 'unlocked_client_' . ($product->id ?? '0');
    $isUnlocked = session($sessionKey, false);
@endphp
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="mt-3 text-center">
    <div class="client-box bg-[#111] border border-[#2b2b2b] rounded-lg p-2 shadow-sm inline-block w-full max-w-xs">

        <div class="flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-300 flex items-center gap-1">
                <i class="bi bi-person-vcard text-yellow-400"></i> رقم العميل
            </h3>

            @if(!$isUnlocked)
                <button id="unlockBtn"
                    class="px-2 py-1 rounded-md bg-[#222] hover:bg-yellow-500 hover:text-black text-gray-200 text-xs font-semibold transition-all duration-200">
                    🔒 عرض الرقم
                </button>
            @endif
        </div>

        @if($isUnlocked)
            <div class="flex items-center justify-between mt-2 bg-[#1a1a1a] rounded-md px-2 py-1">
                <span id="clientNumber"
                      class="text-yellow-400 font-mono text-xs select-text truncate">
                    {{ $product->client_number ?? '—' }}
                </span>

                <button id="copyBtn"
                    class="text-[11px] px-2 py-1 bg-[#333] hover:bg-yellow-500 hover:text-black text-gray-300 rounded-md flex items-center gap-1 transition-all duration-200">
                    <i class="bi bi-clipboard"></i> نسخ
                </button>
            </div>

            <div id="copyAlert"
                 class="hidden fixed top-5 right-5 bg-green-600 text-white px-3 py-1.5 rounded-lg shadow-lg text-xs animate-fade-in">
                ✅ تم النسخ بنجاح
            </div>
        @endif
    </div>
</div>

@if(!$isUnlocked)
    <div id="unlockModal" class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex items-center justify-center">
        <div class="bg-[#111] text-gray-100 rounded-xl shadow-xl w-72 p-5 border border-gray-700">
            <h3 class="text-lg font-bold mb-3 text-center text-yellow-400">أدخل كلمة السر</h3>

            <form id="unlockForm" action="{{ route('product.unlock.client', $product->id) }}">

                @csrf
                <input 
    type="tel"
    name="client_password"
    inputmode="numeric"
    pattern="[0-9]*"
    autocomplete="off"
    placeholder="أدخل الرقم السري"
    class="w-full bg-[#1a1a1a] border border-gray-600 rounded-md p-2 text-gray-200 placeholder-gray-500 text-sm focus:ring-2 focus:ring-yellow-500 text-center"
    required
>


                <div class="mt-4 flex justify-between">
                    <button type="button" id="cancelUnlock"
                        class="px-3 py-1.5 rounded-md bg-[#333] hover:bg-gray-500 text-white text-sm">
                        إلغاء
                    </button>

                    <button type="submit"
                        class="px-3 py-1.5 rounded-md bg-yellow-500 hover:bg-yellow-400 text-black font-semibold text-sm">
                        تأكيد
                    </button>
                </div>
            </form>
        </div>
    </div>
    <style>
/* ✨ حركة ظهور الرقم */
@keyframes fade-in {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.3s ease-out;
}

/* 🚨 حركة اهتزاز عند الخطأ */
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  20%, 60% { transform: translateX(-5px); }
  40%, 80% { transform: translateX(5px); }
}
.shake {
  animation: shake 0.4s;
  border-color: #f87171 !important;
}
</style>

@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const unlockBtn = document.getElementById('unlockBtn');
    const modal = document.getElementById('unlockModal');
    const cancelBtn = document.getElementById('cancelUnlock');
    const unlockForm = document.getElementById('unlockForm');

    // فتح المودال
    if (unlockBtn) unlockBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    // إغلاق المودال
    if (cancelBtn) cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

    // إرسال كلمة السر عبر AJAX بدون تحديث الصفحة
    if (unlockForm) {
        unlockForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(unlockForm);
            const submitBtn = unlockForm.querySelector('button[type="submit"]');
            const input = unlockForm.querySelector('input[name="client_password"]');
            const originalText = submitBtn.innerHTML;

            // 🚀 عرض "جاري التحقق..."
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> جاري التحقق...';

            try {
                const response = await fetch(unlockForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest' // 👈 مهم جدًا حتى يفهم Laravel أنه AJAX
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    modal.classList.add('hidden');

                    // ✅ عرض رقم العميل مباشرة
                    const container = document.querySelector('.client-box');

                    container.innerHTML = `
                        <div class="flex items-center justify-between mt-2 bg-[#1a1a1a] rounded-md px-2 py-1 animate-fade-in">
                            <span id="clientNumber" class="text-yellow-400 font-mono text-xs select-text truncate">
                                ${data.client_number}
                            </span>
                            <button id="copyBtn" class="text-[11px] px-2 py-1 bg-[#333] hover:bg-yellow-500 hover:text-black text-gray-300 rounded-md flex items-center gap-1 transition-all duration-200">
                                <i class="bi bi-clipboard"></i> نسخ
                            </button>
                        </div>
                        <div id="copyAlert" class="hidden fixed top-5 right-5 bg-green-600 text-white px-3 py-1.5 rounded-lg shadow-lg text-xs animate-fade-in">
                            ✅ تم النسخ بنجاح
                        </div>
                    `;

                    // 🔄 تفعيل النسخ مباشرة
                    const copyBtn = document.getElementById('copyBtn');
                    const copyAlert = document.getElementById('copyAlert');
                    copyBtn.addEventListener('click', () => {
                        navigator.clipboard.writeText(data.client_number).then(() => {
                            copyBtn.innerHTML = '✅ تم النسخ';
                            copyBtn.classList.add('bg-green-600', 'text-white');
                            copyAlert.classList.remove('hidden');
                            setTimeout(() => {
                                copyBtn.innerHTML = '<i class="bi bi-clipboard"></i> نسخ';
                                copyBtn.classList.remove('bg-green-600', 'text-white');
                                copyAlert.classList.add('hidden');
                            }, 1500);
                        });
                    });
                } else {
                    // ❌ كلمة سر خاطئة
                    input.classList.add('shake');
                    setTimeout(() => input.classList.remove('shake'), 500);
                }
            } catch (error) {
                console.error('❌ خطأ في الاتصال:', error);
                alert('حدث خطأ أثناء الاتصال بالسيرفر.');
            } finally {
                // استرجاع الزر لحالته
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
});
</script>



