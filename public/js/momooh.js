var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
})

$(document).ready(function() {
    $('select.picker').selectpicker();

    $( ".cards .card-img-top-a .refresh" ).click(function() {
        var src = $(this).attr("data-refresh");
        window.location.href = src;
        return false;
    });
});