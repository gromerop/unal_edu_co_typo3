document.addEventListener('DOMContentLoaded', function () {
    const eventContainer = document.getElementById("c3098");
    if (eventContainer) {
        const eventItems = eventContainer.getElementsByClassName('cop16-event');
        for (var k = 0; k < eventItems.length; k++) {
            eventItems[k].addEventListener("click", function(e){
                var eventBody = e.target.closest('.cop16-event').querySelector('.news-body');
                var modalBody = document.getElementById("eventModal").querySelector('.modal-body');
                modalBody.innerHTML = eventBody.innerHTML;
            });
        }
    }
}, false);


document.addEventListener('DOMContentLoaded', function () {
    const agendaItems = document.getElementById("c3110").getElementsByClassName('article');
    for (var l = 0; l < agendaItems.length; l++) {
        agendaItems[l].addEventListener("click", function(e){
            var eventBody = e.target.closest('.article').querySelector('.news-body');
            var modalBody = document.getElementById("eventModal").querySelector('.modal-body');
            modalBody.innerHTML = eventBody.innerHTML;
        });
    }
}, false);
