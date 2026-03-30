// Quiz 2

// 1. Alert fires BEFORE the DOM is ready (outside document.ready)
alert("The page is about to load.");

// 2. Function that executes when the document is finished loading
$(document).ready(function () {

  var defaultTitle = "ITWS 1100 - Quiz 2";
  var myTitle = "Shruthi Anandraman - Quiz 2";
  var isDefault = true;

  // Set the default page title
  document.title = defaultTitle;

  // Toggle title when "Go" is clicked
  $("#goBtn").on("click", function () {
    if (isDefault) {
      document.title = myTitle;
      isDefault = false;
    } else {
      document.title = defaultTitle;
      isDefault = true;
    }
  });

  // Hover over last name: add/remove makeItPurple class
  $("#lastName").on("mouseenter", function () {
    $(this).addClass("makeItPurple");
  });

  $("#lastName").on("mouseleave", function () {
    $(this).removeClass("makeItPurple");
  });

});