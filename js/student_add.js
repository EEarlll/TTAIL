// upload file
document.getElementById("uploadfile").addEventListener("change", function (e) {
  var formData = new FormData(document.getElementById("pic-upload"));

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "process/upload.php", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      var result = JSON.parse(xhr.responseText);
      if (result.ok) {
        document.getElementById("Pic2").src = result.temp_path;
        document.getElementById("pic_path").value = result.temp_path;
      } else {
        alert("Error occurred");
      }
    }
  };

  xhr.send(formData);
});

// save
document.addEventListener("DOMContentLoaded", function () {
  // Save Form
  document.getElementById("save").addEventListener("click", function (e) {
    e.preventDefault();

    // Validate all required inputs
    var formControls = document.querySelectorAll(".form-control");
    var isValid = true;

    formControls.forEach(function (element) {
      if (element.hasAttribute("required") && element.value.trim() === "") {
        isValid = false;
        // Optionally, you can add visual indication for the user, e.g., highlight the field
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

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process/student_add.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        var result = JSON.parse(xhr.responseText);
        if (result.ok) {
          var frm = document.getElementById("form-student");
          frm.reset();
          document.getElementById("Pic2").src = "Images/circle.png";
          alert("Data successfully added!");
        } else {
          alert(result.error);
        }
      }
    };

    xhr.send(formData.toString());
  });
});

// update
document.getElementById("update").addEventListener("click", function (e) {
  e.preventDefault();
  // Validate all required inputs
  var formControls = document.querySelectorAll(".form-control");
  var isValid = true;

  formControls.forEach(function (element) {
    if (element.hasAttribute("required") && element.value.trim() === "") {
      isValid = false;
      // Optionally, you can add visual indication for the user, e.g., highlight the field
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

  console.log(formData);
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "process/student_update.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      var result = JSON.parse(xhr.responseText);
      if (result.ok) {
        alert("Data successfully Updated!");
      }
    }
  };
  xhr.send(formData.toString());
});
