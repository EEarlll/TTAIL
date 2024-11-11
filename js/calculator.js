function handleCalculator() {
  const inputElement = document.getElementById("Cash");
  const historyElement = document.getElementById("history");

  try {
    const currentInput = inputElement.value.trim();
    if (currentInput) {
      // Calculate the result
      const result = eval(currentInput);
      document.getElementById("newBalance").value = result;

      // Add the result to the history
      const historyItem = document.createElement("p");
      historyItem.style.fontSize = "1rem";
      historyItem.textContent = `${currentInput} = ${result}`;
      historyElement.appendChild(historyItem);

      // Limit to last 10 entries
      if (historyElement.childElementCount > 1) {
        historyElement.removeChild(historyElement.firstChild);
      }

      // Clear the input field and set focus for new entry
      inputElement.value = "";
      inputElement.focus();
    }
  } catch (error) {
    alert("Invalid input. Please enter a valid expression.");
    inputElement.value = "";
    inputElement.focus();
  }
}

// Add event listener for Enter key to trigger calculation
document.getElementById("Cash").addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    handleCalculator();
  }
});
