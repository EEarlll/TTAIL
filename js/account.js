var isMatching = true;

function checkPasswordMatch() {
  var password = document.getElementById("password").value;
  var confirm_password = document.getElementById("confirm_password").value;
  var message = document.getElementById("message");

  if (password === confirm_password) {
    message.innerHTML = "Matching";
    message.style.color = "green";
    isMatching = true;
  } else {
    message.innerHTML = "Not Matching";
    message.style.color = "red";
    isMatching = false;
  }
  console.log(isMatching);
}

function getFormData() {
  // Validate all required inputs
  var formControls = document.querySelectorAll(".form-control");
  var isValid = true;

  formControls.forEach(function (element) {
    if (element.hasAttribute("required") && element.value.trim() === "") {
      isValid = false;
      element.classList.add("validation-error");
    } else {
      element.classList.remove("validation-error");
    }
  });

  if (!isValid || !isMatching) {
    alert("Please fill the correct required fields.");
    return;
  }

  // If validation passes, proceed with form submission
  var formData = new URLSearchParams();
  formControls.forEach(function (element) {
    formData.append(element.id, element.value);
  });
  console.log(formData);
  return formData;
}

function callProcess(formData, process) {
  if (!formData) {
    return;
  }
  console.log(formData);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", process, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      alert("Process Successful!");
    }
  };
  xhr.send(formData.toString());
}

document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("password")
    .addEventListener("keyup", checkPasswordMatch);
  document
    .getElementById("confirm_password")
    .addEventListener("keyup", checkPasswordMatch);

  document.getElementById("save").addEventListener("click", (e) => {
    e.preventDefault();
    let formData = getFormData();
    callProcess(formData, "process/account.php");
  });
});
