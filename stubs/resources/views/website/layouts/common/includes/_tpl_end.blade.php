<script>
    const menuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
menuButton.addEventListener('click', () => { mobileMenu.classList.toggle('hidden'); });
</script>
<!-- سكربت العملات -->
    <script>
        const currencyButtons = document.querySelectorAll('.currency-btn');
    const productPrices = document.querySelectorAll('.font-semibold');
    productPrices.forEach(p => {
    const priceText = parseFloat(p.textContent.replace(/[^\d]/g,''));
    p.setAttribute('data-base-price', priceText);
    });
    currencyButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const symbol = btn.dataset.symbol;
        const rate = parseFloat(btn.dataset.rate);
        productPrices.forEach(p => {
        const basePrice = parseFloat(p.getAttribute('data-base-price'));
        const newPrice = (basePrice * rate).toFixed(2);
        p.textContent = `${symbol} ${newPrice}`;
        });
    });
    });
    </script>

    <!-- سكربت الشارات -->
    <script>
        document.querySelectorAll('.product').forEach(p => {
    const status = p.dataset.status;
    const discount = p.dataset.discount;
    if (status === "مباع") {
        const badge = document.createElement('div');
        badge.className = "badge badge-sold";
        badge.textContent = "مباع";
        p.prepend(badge);
        const btn = p.querySelector('button');
        btn.disabled = true;
        btn.classList.add("bg-gray-400", "cursor-not-allowed");
        btn.textContent = "مباع";
    }
    if (discount && !status) {
        const badge = document.createElement('div');
        badge.className = "badge badge-sale";
        badge.textContent = `خصم ${discount}%`;
        p.prepend(badge);
        const priceEl = p.querySelector('[data-base-price]');
        const base = parseFloat(priceEl.getAttribute('data-base-price'));
        const newPrice = base - (base * (discount / 100));
        priceEl.textContent = `ر.س ${newPrice.toFixed(2)} (بدلاً من ${base})`;
    }
    });
    </script>

    <!-- ترتيب المنتجات -->
    <script>
        const productsContainer = document.querySelector('.grid.grid-cols-2.md\\:grid-cols-3');
    const products = Array.from(productsContainer.children);
    products.sort((a,b) => {
    const priceA = parseFloat(a.querySelector('p.font-semibold').textContent.replace(/[^\d]/g,''));
    const priceB = parseFloat(b.querySelector('p.font-semibold').textContent.replace(/[^\d]/g,''));
    return priceB - priceA;
    });
    products.forEach(p => productsContainer.appendChild(p));
    </script>

    <!-- سلايدر Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
    loop:true,
    autoplay:{delay:3000},
    slidesPerView:1,
    spaceBetween:0
    });
    </script>
    <!-- header style two End -->
    @stack('js')
    </body>
</html>
