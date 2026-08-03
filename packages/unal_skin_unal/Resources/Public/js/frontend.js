$( window ).load(function() {
  /***************************************************************/
  /* Script para el funcionamiento de acordeones de gridelements */
  /***************************************************************/
  
  
  $('*[id^="collapse"]').removeClass("show");
  $('*[data-parent^="#accordion"]').click(function() {
    var card = $(this).parents(':eq(1)').next();
    $('*[id^="collapse"]').not(card).removeClass("show");
    card.toggleClass("show", 1000);
  });
  
  /****************************************************************/
  /* Para el funcionamiento de la pestaña de servicios con el tab */
  /****************************************************************/

  /****************************************************/
  /* Colorcitos en acordeón de página de convergencia */
  /****************************************************/

  $("#accordion-472 button").click(function(){

    $('div[class*="color-collapse"]').not($(this).parents().eq(2)).removeClass(function (index, css) {
      return (css.match (/(^|\s)color-collapse\S+/g) || []).join(' ');
    });

    $(this).parents().eq(2).toggleClass("color-"+$(this).attr("aria-controls"));

  });

  /*****************************************/
  /* Popover de las imágenes del histórico */
  /*****************************************/

  $('[data-toggle="popover"]').popover({
        placement : 'bottom',
        trigger : 'click'
    });

  /*****************************************/
  /* Popover de las imágenes del histórico */
  /*****************************************/

  $('.nav-item.nav-link').click(function() {
    $(this).siblings().removeClass("active");
    $(this).addClass("active");
    var idContent = $(this).attr("id").match(/\d+/);
    $("#nav-c"+idContent[0]).addClass("show active");
    $("#nav-c"+idContent[0]).siblings().removeClass("show active");
  });
  
  /********************************************/
  /* Home: títulos de noticias a 58 caracteres */
  /********************************************/
    var newsHeaders = document.getElementsByClassName("news-header-span");
    var newsHeadersMaxLenght = 50;
    for (i = 0; i <= newsHeaders.length; i++){
        if (newsHeaders[i].innerText.length > newsHeadersMaxLenght) {
            var trimmedString = newsHeaders[i].innerText.substr(0, newsHeadersMaxLenght);
            newsHeaders[i].innerText = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" "))) + "...";
        }
    }

    // REPRODUCTOR DE AUDIO
    const controls = [
            'rewind',
            'play',
            'fast-forward',
            'current-time',
            'duration',
            'progress',
            'volume',
            'mute'
    ];
    const player = new Plyr('#player', { controls });
    
  
});

