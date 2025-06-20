(() => {
  "use strict";

  document.addEventListener("DOMContentLoaded", () => {
    const printButton = document.getElementById("printListBtn");
    if (printButton) {
      printButton.addEventListener("click", () => {
        window.print();
      });
    }
  });
})();
