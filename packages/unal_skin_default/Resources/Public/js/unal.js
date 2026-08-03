(function() {
    var cx = "008572255874373046644:chip1p1uf-4";
    var gcse = document.createElement("script");
    gcse.type = "text/javascript";
    gcse.async = true;
    gcse.src = (document.location.protocol == "https:" ? "https:" : "http:") + "//www.google.com/cse/cse.js?cx=" + cx;
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(gcse, s);
})();

                //var nav = false;

                function openNav() {
                    document
                        .getElementById("mySidebar")
                        .style
                        .right = "0px";
                    document
                        .getElementById("main")
                        .style
                        .right = "240px";
                    document
                        .getElementById("openbtnId")
                        .style
                        .backgroundPosition = "35px 0";
                    // nav = true;
                    document.getElementById("openbtnId").classList.add('active');
                }

                /* Set the width of the sidebar to 0
		and the left margin of the page content to 0 */

                function closeNav() {
                    document
                        .getElementById("mySidebar")
                        .style
                        .right = "-240px";
                    document
                        .getElementById("main")
                        .style
                        .right = "0px";
                    document
                        .getElementById("openbtnId")
                        .style
                        .backgroundPosition = "0 0";
                    // nav = false;
                    document.getElementById("openbtnId").classList.remove('active');
                }
                function toggleNav() {
                   // nav ? closeNav() : openNav();
                   if (document.getElementById("openbtnId").classList.contains('active')) {
                      closeNav();
                   } else {
                      openNav();
                   }
                }

document.addEventListener("DOMContentLoaded", function() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const currentLang = urlParams.get('_x_tr_tl');
    const languageButton = document.getElementsByClassName("language-button")[0];
    switch (currentLang){
        case 'en': languageButton.textContent = 'ENG'; break;
        case 'fr': languageButton.textContent = 'FRA'; break;
        case 'pt': languageButton.textContent = 'POR'; break;
    }
});
