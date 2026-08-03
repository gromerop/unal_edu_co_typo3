(function() {

    function loadScript(js, key) {
		
		var script = document.createElement("script");
        script.src = js;
        script.type = 'text/javascript';
		script.onload = onloadFile;
        totalFiles++;
        document.getElementsByTagName("head")[0].appendChild(script);
    }

    function checkIfCssLibraryExist(substr){
        let listStyles = document.styleSheets;
        for (let i = 0; i < listStyles.length; i++) {
          let styleSheet = listStyles[i];
          if(styleSheet.href != null && styleSheet.href.indexOf(substr) !== -1){
            return true;
          }
        }
        return false;
    }
    function loadCss(css) {
        var link = document.createElement("link");
        link.type = 'text/css';
        link.rel = 'stylesheet';
        link.href = css;
        totalFiles++
        link.onload = onloadFile;
        document.getElementsByTagName("head")[0].appendChild(link);
    }

    if (!window.jQuery) {
        loadScript('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
    }


    var numFiles = 0;
    var totalFiles = 0;
    function onloadFile() {
        numFiles++;
    }

    var checkReady = function(callback) {
        if (window.jQuery) {
            callback(jQuery)
        } else {
            window.setTimeout(function() {
                checkReady(callback)
            }, 100)
        }
    };

    function startSlider() {
        if (numFiles < totalFiles) {
            window.setTimeout(function() {
                startSlider()
            }, 100)
        } else {
            if(typeof jQuery.fn.slick != 'function'){
                loadCss("/typo3conf/ext/unal_convergence_module/Resources/Public/Css/slick/slick.min.css");
                loadCss("/typo3conf/ext/unal_convergence_module/Resources/Public/Css/slick/slick-theme.css");
                loadScript('/typo3conf/ext/unal_convergence_module/Resources/Public/JavaScript/slick/slick.min.js');
                startSlider();
            }else{
                let dots = jQuery('.slider-content-cvng').attr('data-dots');
                if(dots == '1'){
                    dots = true;
                }else{
                    dots = false;
                }
                let arrows = jQuery('.slider-content-cvng').attr('data-arrows');
                if(arrows == '1'){
                    arrows = true;
                }else{
                    arrows = false;
                }
                let slidestoshow = parseInt(jQuery('.slider-content-cvng').attr('data-slidestoshow'));
                let slidestoscroll = parseInt(jQuery('.slider-content-cvng').attr('data-slidestoscroll'));
                jQuery('.slider-content-cvng').slick({
                    dots: dots,
                    infinite: false,
                    arrows : arrows,
                    speed: 300,
                    slidesToShow: slidestoshow,
                    slidesToScroll: slidestoscroll
                });
            }
        }
    }

    checkReady(function(jQuery) {

        if(typeof jQuery.fn.slick != 'function'){
            loadCss("/typo3conf/ext/unal_convergence_module/Resources/Public/Css/slick/slick.min.css");
            loadCss("/typo3conf/ext/unal_convergence_module/Resources/Public/Css/slick/slick-theme.css");
            loadScript('/typo3conf/ext/unal_convergence_module/Resources/Public/JavaScript/slick/slick.min.js');
        }

        startSlider();
    })

})();