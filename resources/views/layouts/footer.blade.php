<footer class="ps-footer">
    <div class="ps-container">
        <div class="row gy-4">
            <div class="col-md-4">
                <a href="{{ url('/') }}" class="ps-brand" style="margin-bottom:.8rem">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="PrintShopEld" style="height:34px">
                    <span style="font-size:1.1rem">PrintShop</span>
                </a>
                <p style="color:var(--text-2); font-size:.9rem; max-width:36ch">Bespoke print and embroidery in Kenya — tees, hoodies, caps, polos and uniforms, printed to order with M-Pesa checkout.</p>
                <div style="display:flex; gap:.5rem; margin-top:.9rem">
                    <a href="https://www.instagram.com/" class="ps-icon-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.facebook.com/" class="ps-icon-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.tiktok.com/" class="ps-icon-btn" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    <a href="https://wa.me/254700000000" class="ps-icon-btn" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <h6>Shop</h6>
                <a href="{{ route('catalog') }}">Catalog</a><br>
                <a href="{{ route('catalog.category', 'men') }}">Men</a><br>
                <a href="{{ route('catalog.category', 'women') }}">Women</a><br>
                <a href="{{ route('catalog.category', 'kids') }}">Kids</a><br>
                <a href="{{ route('catalog.category', 'caps') }}">Caps</a>
            </div>
            <div class="col-6 col-md-2">
                <h6>Support</h6>
                <a href="{{ url('/contacts') }}">Contact us</a><br>
                <a href="{{ url('/blog') }}">Stories</a><br>
                <a href="{{ route('profile.index') }}">Track order</a>
            </div>
            <div class="col-md-4">
                <h6>Newsletter</h6>
                <p style="color:var(--text-2); font-size:.88rem">Drops, care tips and print stories — once a month.</p>
                <form action="#" method="post" onsubmit="event.preventDefault(); document.querySelector('.ps-newsletter-msg').textContent='Asante — you are on the list.'; this.querySelector('input[type=email]').value='';" style="display:flex; gap:.6rem; flex-wrap:wrap">
                    <label class="visually-hidden" for="psFooterEmail">Email</label>
                    <input id="psFooterEmail" type="email" required placeholder="you@example.com" style="flex:1 1 180px; background:var(--bg-2); border:1px solid var(--border-strong); border-radius:var(--r-md); padding:.6rem .8rem; color:var(--text)">
                    <button type="submit" class="ps-btn" style="padding:.6rem 1.1rem; box-shadow:none">Join</button>
                </form>
                <p class="ps-newsletter-msg" style="color:var(--ok); font-size:.82rem; margin-top:.45rem"></p>
            </div>
        </div>
        <div class="ps-footer__bottom">
            <span>&copy; {{ date('Y') }} PrintShopEld. All rights reserved.</span>
            <span>Crafted in Nairobi · M-Pesa · Pay on delivery where available</span>
        </div>
    </div>
</footer>
