(function () {
  'use strict';
  function init() {
    document.querySelectorAll('[data-unal-year]').forEach(function (root) {
      if (root.dataset.ready) return;
      if (typeof window.Splide !== 'function') {
        console.error('Año 160: cargar Splide antes de year.js.');
        return;
      }
      root.dataset.ready = 'true';
      // Verificar disponibilidad también al inicializar la navegación.
      root.querySelectorAll('[data-month]').forEach(function (button) {
        button.disabled = !root.querySelector('[data-month-panel="' + button.dataset.month + '"]');
      });
      var instances = new Map();
      var i18n = {prev:'Anterior', next:'Siguiente', first:'Primera tarjeta', last:'Última tarjeta', slideX:'Ir a la tarjeta %s', pageX:'Ir a la página %s', carousel:'Carrusel', slide:'Tarjeta', select:'Seleccionar', slideLabel:'%s de %s'};
      function mountCards(panel) {
        panel.querySelectorAll('[data-card-carousel]').forEach(function (element) {
          if (element.closest('[data-content-panel]').hidden) return;
          if (instances.has(element)) { instances.get(element).refresh(); return; }
          var splide = new window.Splide(element, {type:'slide',perPage:3,perMove:1,gap:'24px',pagination:false,autoplay:false,breakpoints:{991:{perPage:2},575:{perPage:1}},i18n:i18n,reducedMotion:{speed:0,rewindSpeed:0}});
          splide.mount(); instances.set(element, splide);
        });
      }
      function selectContent(panel, id) {
        panel.querySelectorAll('[data-content-tab]').forEach(function (button) {
          var selected = button.dataset.contentTab === id;
          button.setAttribute('aria-selected', String(selected));
          button.tabIndex = selected ? 0 : -1;
        });
        panel.querySelectorAll('[data-content-panel]').forEach(function (element) {
          element.hidden = element.dataset.contentPanel !== id;
        });
        mountCards(panel);
      }
      function selectMonth(id) {
        root.querySelectorAll('[data-month]').forEach(function (button) {
          button.setAttribute('aria-pressed', String(button.dataset.month === id));
        });
        root.querySelectorAll('[data-month-panel]').forEach(function (panel) {
          panel.hidden = panel.dataset.monthPanel !== id;
          if (!panel.hidden) {
            var selected = panel.querySelector('[data-content-tab][aria-selected="true"]') || panel.querySelector('[data-content-tab]');
            selectContent(panel, selected.dataset.contentTab);
          }
        });
      }
      root.addEventListener('click', function (event) {
        var month = event.target.closest('[data-month]');
        if (month && !month.disabled) selectMonth(month.dataset.month);
        var tab = event.target.closest('[data-content-tab]');
        if (tab) selectContent(tab.closest('[data-month-panel]'), tab.dataset.contentTab);
      });
      root.addEventListener('keydown', function (event) {
        var tab = event.target.closest('[data-content-tab]');
        if (!tab || !['ArrowLeft','ArrowRight','Home','End'].includes(event.key)) return;
        event.preventDefault();
        var panel = tab.closest('[data-month-panel]');
        var tabs = Array.from(panel.querySelectorAll('[data-content-tab]'));
        var index = tabs.indexOf(tab);
        index = event.key === 'Home' ? 0 : event.key === 'End' ? tabs.length-1 : (index + (event.key === 'ArrowRight' ? 1 : -1) + tabs.length) % tabs.length;
        selectContent(panel, tabs[index].dataset.contentTab); tabs[index].focus();
      });
      var first = root.querySelector('[data-month][aria-pressed="true"]');
      selectMonth(first ? first.dataset.month : '');
      var monthSlider = new window.Splide(root.querySelector('[data-month-carousel]'), {type:'slide',perPage:4,perMove:1,gap:'12px',pagination:false,autoplay:false,breakpoints:{991:{perPage:3},767:{perPage:2},575:{perPage:1}},i18n:i18n,reducedMotion:{speed:0,rewindSpeed:0}});
      monthSlider.mount();
      if (first) monthSlider.go(Array.from(root.querySelectorAll('[data-month]')).indexOf(first));
    });
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
