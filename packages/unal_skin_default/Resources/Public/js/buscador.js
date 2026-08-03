function checkBck() {
    $(".gsc-input input").attr("placeholder", "Buscar en la Universidad");
    if (!jQuery(".gsc-search-button input").attr("src")) {
        window.setTimeout(function() {
            checkBck();
        }, 100);
    }
}
checkBck();