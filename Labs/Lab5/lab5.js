/* Lab 5 JavaScript File
   Place variables and functions in this file */

function validate(formObj) {
   // Validate all fields are non-blank

   if (formObj.firstName.value == "") {
      alert("You must enter a first name");
      formObj.firstName.focus();
      return false;
   }

   if (formObj.lastName.value == "") {
      alert("You must enter a last name");
      formObj.lastName.focus();
      return false;
   }

   if (formObj.title.value == "") {
      alert("You must enter a title");
      formObj.title.focus();
      return false;
   }

   if (formObj.org.value == "") {
      alert("You must enter an organization");
      formObj.org.focus();
      return false;
   }

   if (formObj.pseudonym.value == "") {
      alert("You must enter a nickname");
      formObj.pseudonym.focus();
      return false;
   }

   if (formObj.comments.value == "" || formObj.comments.value == "Please enter your comments") {
      alert("You must enter a comment");
      formObj.comments.focus();
      return false;
   }

   alert("Form saved successfully!");
   return true;
}

function clearComments(textareaObj) {
   if (textareaObj.value == "Please enter your comments") {
      textareaObj.value = "";
   }
}

function restoreComments(textareaObj) {
   if (textareaObj.value == "") {
      textareaObj.value = "Please enter your comments";
   }
}

function showNickname() {
   var firstName = document.getElementById("firstName").value;
   var lastName = document.getElementById("lastName").value;
   var pseudonym = document.getElementById("pseudonym").value;
   alert(firstName + " " + lastName + " is " + pseudonym);
}