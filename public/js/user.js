document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll("input[type='checkbox']");
    const totalPriceElement = document.getElementById("totalPrice");
  
    checkboxes.forEach(function (checkbox) {
      checkbox.addEventListener("change", function () {
        const selectedCheckboxes = document.querySelectorAll(
          "input[type='checkbox']:checked"
        );
  
        if (selectedCheckboxes.length === 3) {
          checkboxes.forEach(function (checkbox) {
            checkbox.disabled = !checkbox.checked;
          });
  
          const price = selectedCheckboxes.length * 10;
          totalPriceElement.textContent = `Precio total: $ ${price.toFixed(2)}`;
        } else {
          checkboxes.forEach(function (checkbox) {
            checkbox.disabled = false;
          });
          totalPriceElement.textContent = "Precio total: $ 0.00";
        }
      });
    });
  });
  