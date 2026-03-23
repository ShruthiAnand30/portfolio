Lab 6 - jQuery Introduction
Shruthi Anandraman
Intro to ITWS

Question 5 Answer
When you add a new list item and try to click it, nothing happens. This is because jQuery only attached the click handler to the list items that were already on the page when it loaded. The fix is using .on() on the parent element instead, which keeps listening for clicks on any list item inside it, even ones added later.