/* PrintShopEld — storefront behavior */

(function () {
  'use strict';

  /* Header: solid background after scroll */
  var header = document.getElementById('psHeader');
  if (header) {
    var onScroll = function () {
      header.classList.toggle('ps-header--solid', window.scrollY > 120);
      var top = document.querySelector('.ps-top');
      if (top) top.classList.toggle('is-visible', window.scrollY > 400);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* Mobile nav */
  var burger = document.getElementById('psBurger');
  var mobileNav = document.getElementById('psMobileNav');
  if (burger && mobileNav) {
    burger.addEventListener('click', function () {
      var open = mobileNav.classList.toggle('is-open');
      if (header) header.classList.toggle('ps-header--menu-open', open);
      burger.setAttribute('aria-expanded', String(open));
    });
    mobileNav.addEventListener('click', function (e) {
      if (e.target.closest('a')) {
        mobileNav.classList.remove('is-open');
        if (header) header.classList.remove('ps-header--menu-open');
        burger.setAttribute('aria-expanded', 'false');
      }
    });
  }

  /* Account dropdown */
  var account = document.getElementById('psAccountMenu');
  if (account) {
    var toggle = document.getElementById('psAccountToggle');
    var close = function (e) {
      if (e && account.contains(e.target)) return;
      account.classList.remove('is-open');
      if (toggle) toggle.setAttribute('aria-expanded', 'false');
    };
    toggle.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = account.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', String(open));
    });
    document.addEventListener('click', close);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
  }

  /* Wishlist toggle (requires auth; silently posts to wishlist route) */
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-wishlist]');
    if (!btn) return;
    var id = btn.getAttribute('data-wishlist');
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '/wishlist/' + encodeURIComponent(id);
    form.innerHTML = '<input type="hidden" name="_token" value="' + (document.querySelector('meta[name="csrf-token"]') || {}).content + '">' +
                     '<input type="hidden" name="product_id" value="' + id + '">';
    document.body.appendChild(form);
    form.submit();
  });

  /* Product detail: gallery thumbs + swatches + size chips + qty stepper */
  var stage = document.querySelector('.ps-pdp__stage img');
  document.querySelectorAll('.ps-pdp__thumbs [data-full]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var img = btn.getAttribute('data-full');
      if (stage && img) {
        stage.src = img;
        stage.alt = btn.getAttribute('data-alt') || stage.alt;
      }
      document.querySelectorAll('.ps-pdp__thumbs [data-full]').forEach(function (b) { b.classList.toggle('active', b === btn); });
    });
  });
  document.querySelectorAll('[data-swatch-group]').forEach(function (group) {
    group.addEventListener('click', function (e) {
      var btn = e.target.closest('.ps-swatch');
      if (!btn) return;
      group.querySelectorAll('.ps-swatch').forEach(function (s) { s.classList.toggle('active', s === btn); });
      var input = document.querySelector('[data-swatch-input]');
      if (input) input.value = btn.getAttribute('data-value') || '';
    });
  });
  document.querySelectorAll('[data-size-group]').forEach(function (group) {
    group.addEventListener('click', function (e) {
      var btn = e.target.closest('.ps-size');
      if (!btn) return;
      group.querySelectorAll('.ps-size').forEach(function (s) { s.classList.toggle('active', s === btn); });
      var input = document.querySelector('[data-size-input]');
      if (input) input.value = btn.getAttribute('data-value') || '';
    });
  });
  var qty = document.querySelector('[data-qty]');
  if (qty) {
    var input = qty.querySelector('input');
    qty.querySelector('[data-qty-dec]').addEventListener('click', function () { input.value = Math.max(1, parseInt(input.value || '1', 10) - 1); });
    qty.querySelector('[data-qty-inc]').addEventListener('click', function () { input.value = Math.min(99, parseInt(input.value || '1', 10) + 1); });
  }

  /* Catalog: client-side search + sort (no backend dependency) */
  var search = document.querySelector('#catalogSearch');
  var sort = document.querySelector('#catalogSort');
  var grid = document.querySelector('#catalogGrid');
  if (grid && (search || sort)) {
    var cards = Array.prototype.slice.call(grid.querySelectorAll('.catalog-item'));
    var apply = function () {
      var q = (search && search.value ? search.value : '').trim().toLowerCase();
      cards.forEach(function (card) {
        var text = (card.textContent || '').toLowerCase();
        card.style.display = (!q || text.indexOf(q) !== -1) ? '' : 'none';
      });
    };
    if (search) search.addEventListener('input', apply);
    if (sort) {
      sort.addEventListener('change', function () {
        var val = sort.value;
        cards.sort(function (a, b) {
          var pa = parseFloat((a.querySelector('[data-price]') || {}).dataset ? a.querySelector('[data-price]').dataset.price : 0);
          var pb = parseFloat((b.querySelector('[data-price]') || {}).dataset ? b.querySelector('[data-price]').dataset.price : 0);
          if (val === 'price-asc') return pa - pb;
          if (val === 'price-desc') return pb - pa;
          if (val === 'name') return (a.textContent || '').localeCompare(b.textContent || '');
          return 0;
        });
        cards.forEach(function (card) { grid.appendChild(card); });
      });
    }
  }

  /* Reveal on scroll */
  if ('IntersectionObserver' in window) {
    var reveal = document.querySelectorAll('[data-reveal]');
    if (reveal.length) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-revealed');
            io.unobserve(entry.target);
          }
        });
      }, { threshold: 0.12 });
      reveal.forEach(function (el) { io.observe(el); });
    }
  } else {
    document.querySelectorAll('[data-reveal]').forEach(function (el) { el.classList.add('is-revealed'); });
  }
})();
