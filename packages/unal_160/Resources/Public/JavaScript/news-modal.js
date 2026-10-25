(function () {
  'use strict';
  // Delegación independiente de Splide y del orden de carga de Bootstrap.
  document.addEventListener('click', function (event) {
    var button = event.target.closest('[data-news-content]');
    if (!button) return;
    var root = button.closest('[data-unal-year]');
    if (!root) return;
    var source = document.getElementById(button.dataset.newsContent);
    var modal = document.getElementById(root.dataset.newsModal);
    if (!source || !source.content || !root.contains(source) || !modal) return;
    if (!window.bootstrap || typeof window.bootstrap.Modal !== 'function') {
      console.error('Año 160: el modal de texto requiere Bootstrap 5.');
      return;
    }
    event.preventDefault();
    // Fuera de las secciones ocultas y los contenedores transformados del sitio.
    if (modal.parentNode !== document.body) document.body.appendChild(modal);
    modal.querySelector('[data-news-modal-title]').textContent = source.dataset.newsTitle;
    var body = modal.querySelector('[data-news-modal-body]');
    body.replaceChildren(source.content.cloneNode(true));
    body.scrollTop = 0;
    modal.unalNewsTrigger = button;
    if (!modal.dataset.newsEventsReady) {
      modal.dataset.newsEventsReady = 'true';
      modal.addEventListener('hidden.bs.modal', function () {
        body.replaceChildren();
        var trigger = modal.unalNewsTrigger;
        if (trigger && trigger.isConnected) trigger.focus();
      });
    }
    var instance = window.bootstrap.Modal.getInstance(modal) || new window.bootstrap.Modal(modal);
    instance.show(button);
  });
})();
