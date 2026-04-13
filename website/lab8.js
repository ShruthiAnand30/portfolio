$(document).ready(function () {

  // AJAX call: fetch lab8.json from the same folder as labs.html
  $.getJSON("lab8.json", function (data) {

    // Hide the "Loading..." message once data arrives
    $("#lab-loading").hide();

    // Loop through each lab item and build its HTML entry
    $.each(data.menuItem, function (index, item) {

      var entryHTML =
        '<div class="entry" style="display:none">' +
          '<div class="entry-head">' +
            '<span>' + item.lab + '</span>' +
            '<span>' + item.subtitle + '</span>' +
          '</div>' +
          '<div class="entry-sub">' + item.description + '</div>' +
          '<a class="button open-lab" href="#"' +
             ' data-lab="' + item.lab + '"' +
             ' data-results="' + item.results + '"' +
             ' data-refs="' + item.refs + '"' +
             ' title="Open options for ' + item.lab + '">' +
            'Open ' + item.lab + ' Options' +
          '</a>' +
        '</div>';

      // Add to the page and fade each card in with a slight delay
      $("#lab-list").append(entryHTML);
      $("#lab-list .entry:last").delay(index * 80).fadeIn(300);
    });

    // jQueryUI tooltips on the buttons (shows the title attribute on hover)
    $(".open-lab").tooltip({
      position: { my: "left+10 center", at: "right center" }
    });

    // Wire up the modal after entries are in the DOM
    attachModalHandlers();

  }).fail(function () {
    // Show an error if the JSON file couldn't be fetched
    $("#lab-loading").text(
      "Could not load labs. Make sure lab8.json is in the website/ folder."
    ).css("color", "red");
  });

});


/*
 * attachModalHandlers()
 * Opens/closes the modal for dynamically built .open-lab buttons.
 */
function attachModalHandlers() {

  var backdrop   = $("#modalBackdrop");
  var titleEl    = $("#modalTitle");
  var btnResults = $("#modalResults");
  var btnRefs    = $("#modalRefs");
  var btnClose   = $("#modalClose");

  // Open modal on button click
  $(document).on("click", ".open-lab", function (e) {
    e.preventDefault();
    titleEl.text($(this).data("lab") + " Options");
    btnResults.attr("href", $(this).data("results"));
    btnRefs.attr("href",    $(this).data("refs"));
    backdrop.fadeIn(200).attr("aria-hidden", "false");
  });

  // Close when clicking the dark backdrop area
  backdrop.on("click", function (e) {
    if (e.target === this) closeModal();
  });

  // Close button
  btnClose.on("click", function (e) {
    e.preventDefault();
    closeModal();
  });

  // Close on Escape key
  $(document).on("keydown", function (e) {
    if (e.key === "Escape") closeModal();
  });

  function closeModal() {
    backdrop.fadeOut(150).attr("aria-hidden", "true");
  }
}