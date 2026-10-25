(function () {
  'use strict';
  function destination(value) {
    var url;
    try { url = new URL(value); } catch (error) { return null; }
    if (!/^https?:$/.test(url.protocol) || url.username || url.password) return null;
    var host = url.hostname.toLowerCase(), id = '', match;
    if (['youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtube-nocookie.com', 'www.youtube-nocookie.com'].indexOf(host) !== -1) {
      if (url.pathname === '/watch') id = url.searchParams.get('v') || '';
      else { match = url.pathname.match(/^\/(?:embed|shorts|live)\/([\w-]{11})\/?$/); id = match ? match[1] : ''; }
    } else if (host === 'youtu.be' || host === 'www.youtu.be') id = url.pathname.slice(1).replace(/\/$/, '');
    if (/^[\w-]{11}$/.test(id)) return {kind:'youtube', src:'https://www.youtube-nocookie.com/embed/' + id + '?autoplay=1&rel=0'};
    if (['instagram.com', 'www.instagram.com', 'm.instagram.com'].indexOf(host) !== -1) {
      match = url.pathname.match(/^\/(p|reel|tv)\/([\w-]+)\/?$/);
      if (match) return {kind:'instagram', src:'https://www.instagram.com/' + match[1] + '/' + match[2] + '/'};
    }
    return null;
  }
  var instagramLoading;
  function instagram() {
    if (window.instgrm && window.instgrm.Embeds) return Promise.resolve();
    if (!instagramLoading) instagramLoading = new Promise(function (resolve, reject) {
      var script = document.createElement('script');
      script.src = 'https://www.instagram.com/embed.js'; script.async = true;
      script.onload = resolve;
      script.onerror = function () { script.remove(); instagramLoading = null; reject(new Error('Instagram no disponible')); };
      document.head.appendChild(script);
    });
    return instagramLoading;
  }
  function modalElement() {
    var modal = document.getElementById('unal-historias-video');
    if (!modal) {
      modal = document.createElement('div');
      modal.id = 'unal-historias-video'; modal.className = 'modal fade'; modal.tabIndex = -1;
      modal.setAttribute('aria-hidden', 'true'); modal.setAttribute('aria-labelledby', 'unal-historias-video-titulo');
      modal.innerHTML = '<div class="modal-dialog modal-fullscreen"><div class="modal-content"><div class="modal-header"><h2 class="modal-title fs-5" id="unal-historias-video-titulo">Ver video</h2><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar video"></button></div><div class="modal-body"></div></div></div>';
    }
    document.body.appendChild(modal);
    if (!modal.dataset.storiesBound) {
      modal.dataset.storiesBound = '1';
      modal.addEventListener('hide.bs.modal', function () { modal.querySelector('.modal-body').replaceChildren(); });
      modal.addEventListener('hidden.bs.modal', function () {
        if (modal.storiesTrigger && modal.storiesTrigger.isConnected) modal.storiesTrigger.focus();
      });
    }
    return modal;
  }
  document.addEventListener('click', function (event) {
    if (!(event.target instanceof Element)) return;
    var trigger = event.target.closest('[data-story-video], [data-youtube-id][data-bs-target="#unal-historias-video"]');
    if (!trigger || trigger.disabled || event.button !== 0 || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
    var legacyId = (trigger.getAttribute('data-youtube-id') || '').trim();
    var url = trigger.hasAttribute('data-story-video') ? trigger.href : (/^[\w-]{11}$/.test(legacyId) ? 'https://www.youtube.com/watch?v=' + legacyId : '');
    var video = destination(url);
    if (!video) return; // Los enlaces ordinarios conservan target=_blank.
    if (!window.bootstrap || !window.bootstrap.Modal) {
      if (!trigger.hasAttribute('href')) { event.preventDefault(); event.stopImmediatePropagation(); window.open(url, '_blank', 'noopener,noreferrer'); }
      return;
    }
    event.preventDefault();
    event.stopImmediatePropagation(); // Evita activar además el manejador automático de Bootstrap.
    var modal = modalElement(), body = modal.querySelector('.modal-body');
    var title = trigger.getAttribute('data-video-title') || trigger.textContent.trim() || 'Ver video';
    modal.storiesTrigger = trigger;
    modal.querySelector('.modal-title').textContent = title;
    body.replaceChildren();
    var container = document.createElement('div'); container.className = 'unal-stories__embed'; body.appendChild(container);
    var fallback = document.createElement('a'); fallback.href = url; fallback.target = '_blank'; fallback.rel = 'noopener noreferrer';
    fallback.className = 'unal-stories__fallback'; fallback.textContent = video.kind === 'instagram' ? 'Ver en Instagram' : 'Ver en YouTube'; body.appendChild(fallback);
    if (video.kind === 'youtube') {
      var frame = document.createElement('iframe'); frame.title = title; frame.src = video.src;
      frame.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen'; frame.allowFullscreen = true;
      frame.referrerPolicy = 'strict-origin-when-cross-origin'; container.appendChild(frame);
    } else {
      var quote = document.createElement('blockquote'); quote.className = 'instagram-media';
      quote.setAttribute('data-instgrm-permalink', video.src); quote.setAttribute('data-instgrm-version', '14');
      container.appendChild(quote);
      instagram().then(function () {
        if (quote.isConnected && window.instgrm && window.instgrm.Embeds) window.instgrm.Embeds.process();
      }).catch(function () { if (quote.isConnected) quote.textContent = 'Abre el enlace para ver esta publicación.'; });
    }
    var instance = window.bootstrap.Modal.getInstance(modal) || new window.bootstrap.Modal(modal);
    instance.show(trigger);
  }, true);
  function init() {
    document.querySelectorAll('[data-stories-carousel]').forEach(function (element) {
      if (element.classList.contains('is-initialized') || typeof window.Splide !== 'function') return;
      var count = element.querySelectorAll('.splide__slide').length;
      var featured = element.closest('.unal-stories').querySelector('.unal-stories__featured');
      function trackHeight() { return Math.max(120, Math.round(featured.getBoundingClientRect().height) - 64); }
      var slider = new window.Splide(element, {type:'slide', direction:'ttb', height:trackHeight(),
        perPage:2, perMove:2, focus:0, trimSpace:false, gap:'16px', pagination:false,
        arrows:count > 2, drag:count > 2, autoplay:false,
        breakpoints:{767:{direction:'ltr',height:'auto'}},
        reducedMotion:{speed:0,rewindSpeed:0},
        i18n:{prev:'Historias anteriores',next:'Historias siguientes',slideLabel:'%s de %s',carousel:'Carrusel',slide:'Historia'}}).mount();
      // Sincroniza el alto vertical con la tarjeta principal al cambiar la columna.
      var lastHeight = trackHeight();
      function resize() {
        var height = trackHeight();
        if (window.innerWidth > 767 && (height !== lastHeight || slider.options.height === 'auto')) {
          lastHeight = height;
          slider.options = {height:height};
        }
      }
      if (window.ResizeObserver) {
        var observer = new ResizeObserver(resize);
        observer.observe(featured);
      }
      window.addEventListener('resize', resize);

    });
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init, {once:true}); else init();
})();
