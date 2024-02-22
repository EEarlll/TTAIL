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
  if (file) {
    xhr.responseType = "arraybuffer";
  }

  xhr.onload = function () {
    if (xhr.status === 200) {
      if (file) {
        var result = xhr.response;
        var blob = new Blob([result], {
          type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });

        var currentMonthSpan =
          document.getElementById("currentMonth").innerText;
        var userName = document.getElementById("Name").value;

        var downloadAnchor = document.createElement("a");
        downloadAnchor.href = window.URL.createObjectURL(blob);
        downloadAnchor.download = userName + " - " + currentMonthSpan + ".xlsx";
        document.body.appendChild(downloadAnchor);
        downloadAnchor.click();
        document.body.removeChild(downloadAnchor);
      } else {
        alert("Process Successful!");
      }
    }
  };
  xhr.send(formData.toString());
}

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
    var formData = getFormData();

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
  let formData = getFormData();
  callProcess(formData, "process/student_update.php");
});

document.getElementById("download").addEventListener("click", (e) => {
  e.preventDefault();
  let formData = getFormData();
  callProcess(formData, "process/spreadsheet.php", true);
});
