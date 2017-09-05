// Description Modal Popup
$(document).on("click", ".open-description-modal", function () {
    var descriptionTitle = document.getElementById('descriptionTitle');
    var descriptionText = document.getElementById('descriptionText');
    descriptionTitle.innerHTML = "";
    descriptionText.innerHTML = "";
    descriptionTitle.innerHTML += $(this).data('title');
    descriptionText.innerHTML += $(this).data('description');
});