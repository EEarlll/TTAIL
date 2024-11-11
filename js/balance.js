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

  if (!isValid) {
    alert("Please fill in all required fields.");
    return;
  }

  // If validation passes, proceed with form submission
  var formData = new URLSearchParams();
  formControls.forEach(function (element) {
    formData.append(element.id, element.value);
  });
  return formData;
}

function callProcess(formData, process, file = false) {
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
    if (xhr.status === 401) {
      alert("Insufficient balance for transaction.");
    }
  };
  xhr.send(formData.toString());
}

document.getElementById("Add").addEventListener("click", function (e) {
  e.preventDefault();
  document.getElementById("transaction_type").value = "deposit";
  let formData = getFormData();
  callProcess(formData, "process/balance.php");
  document.getElementById("newBalance").value = "";
  document.getElementById("student_no").value = "";
  document.getElementById("student_no").focus();
});

document.getElementById("Minus").addEventListener("click", function (e) {
  e.preventDefault();
  document.getElementById("transaction_type").value = "withdrawal";
  let formData = getFormData();
  callProcess(formData, "process/balance.php");
  document.getElementById("newBalance").value = "";
  document.getElementById("student_no").value = "";
  document.getElementById("student_no").focus();
});

document.getElementById("Info").addEventListener("click", function (e) {
  e.preventDefault();
  var userInput = document.getElementById("student_no").value;
  var newUrl = "balance.php?id=" + userInput;
  window.location.href = newUrl;
});
