// Admin modul pro zabránění kolizím s jinými knihovnami
(() => {
  "use strict";

  // Privátní funkce pro potvrzení mazání knihy
  const confirmDeleteBook = (bookId, bookTitle) => {
    if (confirm(`Opravdu chcete smazat knihu "${bookTitle}"?`)) {
      // Vytvoříme a odešleme formulář
      const form = document.createElement("form");
      form.method = "POST";
      form.action = `/admin/books/${bookId}/delete`;
      document.body.appendChild(form);
      form.submit();
    }
  };

  // Privátní funkce pro inicializaci formulářů
  const initializeForms = () => {
    // Nastavení aktuálního roku pro nové knihy
    const yearInput = document.getElementById("publication_year");
    if (yearInput && !yearInput.value) {
      yearInput.value = new Date().getFullYear();
    }
  };

  // Privátní funkce pro inicializaci delete buttonů
  const initializeDeleteButtons = () => {
    const deleteButtons = document.querySelectorAll("[data-delete-book]");
    deleteButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        e.preventDefault();
        const { bookId, bookTitle } = button.dataset;
        confirmDeleteBook(bookId, bookTitle);
      });
    });
  };

  // Hlavní inicializační funkce
  const init = () => {
    initializeForms();
    initializeDeleteButtons();
  };

  // Spuštění při načtení stránky
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
