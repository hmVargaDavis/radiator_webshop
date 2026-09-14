(function () {
  'use strict';

  if (!document.body || document.body.dataset.adminSpa !== '1') return;

  var content = document.querySelector('[data-spa-content]');
  var titleEl = document.querySelector('[data-spa-title]');
  var statusEl = document.getElementById('adminSpaStatus');

  function csrf() {
    var el = document.querySelector('meta[name="csrf-token"]');
    return el ? el.content : '';
  }

  function setLoading(on) {
    document.body.classList.toggle('is-loading', !!on);
    if (statusEl) statusEl.classList.toggle('d-none', !on);
  }

  function syncActive(url) {
    var path = new URL(url, window.location.origin).pathname.replace(/\/$/, '') || '/admin';
    document.querySelectorAll('[data-spa-link]').forEach(function (link) {
      try {
        var linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/$/, '');
        var active = path === linkPath || (linkPath !== '/admin' && path.indexOf(linkPath) === 0);
        link.classList.toggle('active', active);
      } catch (e) {}
    });
  }

  function runScripts(doc) {
    var nodes = [];
    doc.querySelectorAll('script').forEach(function (s) {
      if (s.src && s.src.indexOf('admin-spa.js') >= 0) return;
      if (s.src && s.src.indexOf('bootstrap') >= 0) return;
      if (s.src && s.src.indexOf('chart') >= 0) return;
      nodes.push(s);
    });
    // also scripts that were inside content after parse - get from original html content area
    var contentNode = doc.querySelector('[data-spa-content]');
    if (contentNode) {
      contentNode.querySelectorAll('script').forEach(function (s) { nodes.push(s); });
    }

    // Deduplicate by text
    var seen = {};
    nodes.forEach(function (oldScript) {
      var key = (oldScript.src || '') + '|' + (oldScript.textContent || '');
      if (seen[key]) return;
      seen[key] = true;
      var script = document.createElement('script');
      if (oldScript.src) {
        script.src = oldScript.src;
        script.async = false;
      } else {
        script.textContent = oldScript.textContent;
      }
      document.body.appendChild(script);
      if (!oldScript.src) {
        setTimeout(function () { script.remove(); }, 0);
      }
    });
  }

  function bindContent(root) {
    if (!root) return;

    root.querySelectorAll('a[href]').forEach(function (a) {
      if (a.dataset.spaBound === '1') return;
      var href = a.getAttribute('href');
      if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
      if (a.target === '_blank' || a.hasAttribute('download')) return;
      try {
        var u = new URL(href, window.location.origin);
        if (u.origin !== window.location.origin) return;
        if (u.pathname.indexOf('/admin') !== 0) return;
        if (u.pathname.indexOf('/admin/login') === 0) return;
        a.dataset.spaBound = '1';
        a.addEventListener('click', function (e) {
          if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
          e.preventDefault();
          navigate(u.href, true);
        });
      } catch (err) {}
    });

    root.querySelectorAll('form').forEach(function (form) {
      if (form.dataset.spaIgnore === '1') return;
      if (form.dataset.spaBound === '1') return;
      form.dataset.spaBound = '1';

      form.addEventListener('submit', function (e) {
        var action = form.getAttribute('action') || window.location.href;
        var method = (form.getAttribute('method') || 'GET').toUpperCase();
        if (method === 'GET') {
          e.preventDefault();
          var qs = new URLSearchParams(new FormData(form)).toString();
          navigate(action + (qs ? (action.indexOf('?') >= 0 ? '&' : '?') + qs : ''), true);
          return;
        }

        e.preventDefault();
        setLoading(true);
        fetch(action, {
          method: method,
          body: new FormData(form),
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-Admin-SPA': '1',
            'Accept': 'text/html',
            'X-CSRF-TOKEN': csrf()
          },
          credentials: 'same-origin',
          redirect: 'follow'
        })
          .then(function (res) {
            return res.text().then(function (html) {
              return { res: res, html: html };
            });
          })
          .then(function (payload) {
            applyHtml(payload.html, payload.res.url, true);
          })
          .catch(function () {
            form.submit();
          })
          .finally(function () {
            setLoading(false);
          });
      });
    });
  }

  function applyHtml(html, url, push) {
    var doc = new DOMParser().parseFromString(html, 'text/html');
    var next = doc.querySelector('[data-spa-content]');

    if (!next) {
      window.location.href = url || '/admin/login';
      return;
    }

    // Destroy previous charts to avoid canvas reuse errors
    if (window.Chart && Chart.getChart) {
      content.querySelectorAll('canvas').forEach(function (c) {
        var existing = Chart.getChart(c);
        if (existing) existing.destroy();
      });
    }

    content.innerHTML = next.innerHTML;

    var nextTitle = doc.querySelector('[data-spa-title]');
    var pageTitle = doc.querySelector('title');
    if (titleEl && nextTitle) titleEl.textContent = nextTitle.textContent.trim();
    if (pageTitle) document.title = pageTitle.textContent;

    if (push && url) history.pushState({ spa: true }, '', url);

    syncActive(url || window.location.href);
    bindContent(content);
    runScripts(doc);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function navigate(url, push) {
    setLoading(true);
    fetch(url, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-Admin-SPA': '1',
        'Accept': 'text/html'
      },
      credentials: 'same-origin'
    })
      .then(function (res) {
        if (res.url && res.url.indexOf('/admin/login') >= 0) {
          window.location.href = res.url;
          return null;
        }
        return res.text().then(function (html) {
          return { html: html, url: res.url };
        });
      })
      .then(function (payload) {
        if (!payload) return;
        applyHtml(payload.html, payload.url || url, push);
      })
      .catch(function () {
        window.location.href = url;
      })
      .finally(function () {
        setLoading(false);
      });
  }

  document.querySelectorAll('[data-spa-link]').forEach(function (link) {
    link.addEventListener('click', function (e) {
      if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
      e.preventDefault();
      navigate(link.href, true);
    });
  });

  window.addEventListener('popstate', function () {
    navigate(window.location.href, false);
  });

  bindContent(content);
  syncActive(window.location.href);
})();
