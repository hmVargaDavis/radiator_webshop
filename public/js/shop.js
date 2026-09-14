(function () {
  'use strict';

  var csrf = function () {
    var el = document.querySelector('meta[name="csrf-token"]');
    return el ? el.content : '';
  };

  var routes = {
    cartAdd: '/kosar/hozzaadas',
    cartUpdate: '/kosar/frissites',
    cartRemove: '/kosar/torles',
    cartDrawer: '/api/kosar/drawer',
    cartSummary: '/api/kosar'
  };

  function toast(message, isError) {
    var el = document.getElementById('cartToast');
    if (!el || !window.bootstrap) {
      if (message) window.alert(message);
      return;
    }
    el.classList.toggle('text-bg-danger', !!isError);
    el.classList.toggle('text-bg-primary', !isError);
    var body = el.querySelector('.toast-body');
    if (body) body.textContent = message;
    bootstrap.Toast.getOrCreateInstance(el).show();
  }

  function updateCartBadges(data) {
    var count = data.count || 0;
    document.querySelectorAll('[data-cart-count]').forEach(function (el) {
      el.textContent = count;
      el.classList.toggle('d-none', !count);
    });
    document.querySelectorAll('[data-cart-total-label]').forEach(function (el) {
      el.textContent = data.label || (count + ' termék');
    });
    // legacy sticky bar (if present)
    var bar = document.getElementById('mobileCartBar');
    if (bar) bar.classList.toggle('d-none', !count);
    if (data.total_formatted) {
      document.querySelectorAll('[data-cart-total]').forEach(function (el) {
        el.textContent = data.total_formatted;
      });
    }
    if (data.subtotal_formatted) {
      document.querySelectorAll('[data-cart-subtotal]').forEach(function (el) {
        el.textContent = data.subtotal_formatted;
      });
    }
    if (data.shipping_formatted) {
      document.querySelectorAll('[data-cart-shipping]').forEach(function (el) {
        el.textContent = data.shipping_formatted;
      });
    }
  }

  function bindQty(root) {
    (root || document).querySelectorAll('.qty-control').forEach(function (wrap) {
      if (wrap.dataset.qtyBound === '1') return;
      wrap.dataset.qtyBound = '1';

      var minus = wrap.querySelector('[data-qty-minus]');
      var plus = wrap.querySelector('[data-qty-plus]');
      var select = wrap.querySelector('select[data-qty-select]');
      var hidden = wrap.querySelector('input[type="hidden"][name="quantity"]');

      if (select && !select.options.length) {
        for (var i = 1; i <= 50; i++) {
          var opt = document.createElement('option');
          opt.value = String(i);
          opt.textContent = String(i);
          select.appendChild(opt);
        }
        select.value = select.dataset.value || '1';
      }

      function clamp(n) {
        n = parseInt(n, 10);
        if (isNaN(n) || n < 1) return 1;
        if (n > 50) return 50;
        return n;
      }

      function sync(n) {
        n = clamp(n);
        if (select) select.value = String(n);
        if (hidden) hidden.value = String(n);
        wrap.dispatchEvent(new CustomEvent('qty:change', { detail: { quantity: n }, bubbles: true }));
      }

      if (minus) minus.addEventListener('click', function () {
        sync((select ? select.value : 1) - 1);
      });
      if (plus) plus.addEventListener('click', function () {
        sync(parseInt(select ? select.value : 1, 10) + 1);
      });
      if (select) select.addEventListener('change', function () {
        sync(select.value);
      });
    });
  }

  function postForm(url, data) {
    var fd = data instanceof FormData ? data : new FormData();
    if (!(data instanceof FormData) && data) {
      Object.keys(data).forEach(function (k) { fd.append(k, data[k]); });
    }
    return fetch(url, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrf()
      },
      body: fd,
      credentials: 'same-origin'
    }).then(function (r) {
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return r.json();
    });
  }

  function refreshDrawerHtml(html) {
    var body = document.querySelector('[data-cart-drawer-body]');
    if (body && html) {
      body.innerHTML = html;
      bindQty(body);
      bindAjaxCartControls(body);
    }
  }

  function refreshCartPage(html) {
    var body = document.querySelector('[data-cart-page-body]');
    if (body && typeof html === 'string') {
      body.innerHTML = html;
      bindQty(body);
      bindAjaxCartControls(body);
    }
  }

  function applyCartResponse(data, opts) {
    opts = opts || {};
    updateCartBadges(data);
    if (data.html) refreshDrawerHtml(data.html);
    if (data.page_html) refreshCartPage(data.page_html);
    if (data.message && opts.toast !== false) toast(data.message);
    if (opts.openDrawer && window.bootstrap) {
      var drawer = document.getElementById('cartDrawer');
      if (drawer) bootstrap.Offcanvas.getOrCreateInstance(drawer).show();
    }
  }

  function bindAddToCart(root) {
    (root || document).querySelectorAll('[data-add-to-cart]').forEach(function (form) {
      if (form.dataset.bound === '1') return;
      form.dataset.bound = '1';
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = form.querySelector('button[type="submit"]');
        if (btn) {
          btn.disabled = true;
          btn.classList.add('is-loading');
        }
        postForm(form.action, new FormData(form))
          .then(function (data) {
            applyCartResponse(data, { openDrawer: true });
          })
          .catch(function () {
            toast('Nem sikerült a kosárba tétel. Próbálja újra.', true);
          })
          .finally(function () {
            if (btn) {
              btn.disabled = false;
              btn.classList.remove('is-loading');
            }
          });
      });
    });
  }

  function bindAjaxCartControls(root) {
    (root || document).querySelectorAll('[data-ajax-qty]').forEach(function (wrap) {
      if (wrap.dataset.ajaxBound === '1') return;
      wrap.dataset.ajaxBound = '1';
      var productId = wrap.getAttribute('data-product-id');
      wrap.addEventListener('qty:change', function (ev) {
        var qty = ev.detail.quantity;
        postForm(routes.cartUpdate, { product_id: productId, quantity: qty })
          .then(function (data) { applyCartResponse(data, { toast: false }); })
          .catch(function () { toast('Kosár frissítés sikertelen.', true); });
      });
    });

    (root || document).querySelectorAll('[data-ajax-remove]').forEach(function (btn) {
      if (btn.dataset.bound === '1') return;
      btn.dataset.bound = '1';
      btn.addEventListener('click', function () {
        var id = btn.getAttribute('data-ajax-remove');
        postForm(routes.cartRemove, { product_id: id })
          .then(function (data) { applyCartResponse(data); })
          .catch(function () { toast('Törlés sikertelen.', true); });
      });
    });
  }

  function bindProductFilters() {
    var form = document.querySelector('[data-ajax-filter]');
    if (!form) return;

    var timer = null;
    var wrap = document.getElementById('productsAjaxWrap');
    var loading = document.getElementById('productsLoading');

    function runFilter(pushUrl) {
      var params = new URLSearchParams(new FormData(form));
      if (loading) loading.classList.remove('d-none');
      if (wrap) wrap.classList.add('is-filtering');

      fetch(form.action + '?' + params.toString(), {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        credentials: 'same-origin'
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          var mobile = document.querySelector('[data-products-mobile]');
          var desktop = document.querySelector('[data-products-desktop]');
          if (mobile && data.list_html) mobile.innerHTML = data.list_html;
          if (desktop && data.html) desktop.innerHTML = data.html;
          var countEl = document.querySelector('[data-filter-count]');
          if (countEl) countEl.textContent = data.count + ' termék';
          bindQty(wrap);
          bindAddToCart(wrap);
          if (pushUrl !== false) {
            history.replaceState({}, '', form.action + '?' + params.toString());
          }
        })
        .catch(function () {
          toast('A szűrés nem sikerült.', true);
        })
        .finally(function () {
          if (loading) loading.classList.add('d-none');
          if (wrap) wrap.classList.remove('is-filtering');
        });
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      runFilter(true);
    });

    form.querySelectorAll('select, input[type="number"]').forEach(function (el) {
      el.addEventListener('change', function () { runFilter(true); });
    });

    var search = form.querySelector('input[type="search"]');
    if (search) {
      search.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () { runFilter(true); }, 350);
      });
    }

    var resetBtn = document.getElementById('resetFilters');
    if (resetBtn) {
      resetBtn.addEventListener('click', function () {
        form.reset();
        form.querySelectorAll('input, select').forEach(function (el) {
          if (el.tagName === 'SELECT') el.selectedIndex = 0;
          else el.value = '';
        });
        runFilter(true);
      });
    }
  }

  function bindReviewForms() {
    document.querySelectorAll('[data-ajax-review]').forEach(function (form) {
      if (form.dataset.bound === '1') return;
      form.dataset.bound = '1';
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        postForm(form.action, new FormData(form))
          .then(function (data) {
            toast(data.message || 'Köszönjük!');
            form.reset();
          })
          .catch(function () {
            toast('Az értékelés küldése nem sikerült. Ellenőrizze a mezőket.', true);
          });
      });
    });
  }

  function bindCartDrawerOpen() {
    var drawer = document.getElementById('cartDrawer');
    if (!drawer) return;
    drawer.addEventListener('show.bs.offcanvas', function () {
      fetch(routes.cartDrawer, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          applyCartResponse(data, { toast: false });
        })
        .catch(function () {});
    });
  }

  function bindMobileCartBar() {
    // bottom nav handles cart on mobile
  }

  .document.addEventListener('DOMContentLoaded', function () {
    bindQty(document);
    bindAddToCart(document);
    bindAjaxCartControls(document);
    bindProductFilters();
    bindReviewForms();
    bindCartDrawerOpen();
    bindMobileCartBar();

    // PWA service worker
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/sw.js').catch(function () {});
    }

    // soft page enter
    var main = document.getElementById('appMain');
    if (main) {
      main.classList.add('app-page-enter');
    }
  });
})();
