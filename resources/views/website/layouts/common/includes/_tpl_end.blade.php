<script>
    const menuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
menuButton.addEventListener('click', () => { mobileMenu.classList.toggle('hidden'); });
</script>
<!-- سكربت العملات -->
  <!-- سكربت العملات -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll(".currency-btn");

  buttons.forEach(btn => {
    btn.addEventListener("click", () => {
      const symbol = btn.dataset.symbol;
      const rate = parseFloat(btn.dataset.rate);

      document.querySelectorAll(".product-price").forEach(p => {
        const current = p.querySelector(".current-price");
        const old = p.querySelector(".old-price");
        const base = parseFloat(p.dataset.basePrice);
        const baseOld = parseFloat(p.dataset.baseOld);

        if (current && !isNaN(base)) {
          const converted = (base * rate).toFixed(2).replace(/\.00$/, "");
          current.textContent = `${symbol} ${converted}`;
        }

        if (old && !isNaN(baseOld)) {
          const convertedOld = (baseOld * rate).toFixed(2).replace(/\.00$/, "");
          old.textContent = convertedOld;
        }
      });

      // إبراز الزر النشط
      buttons.forEach(b => b.classList.remove("ring-2", "ring-yellow-500"));
      btn.classList.add("ring-2", "ring-yellow-500");
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
