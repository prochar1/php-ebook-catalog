// Admin modul pro zabránění kolizím s jinými knihovnami
(() => {
  "use strict";

  // Sledování dirty state formuláře
  let isDirty = false;
  let originalFormData = {};
  const dirtyStateMessage =
    "Formulář obsahuje neuložené změny. Opravdu chcete opustit stránku?";

  // Privátní funkce pro potvrzení mazání knihy
  const confirmDeleteBook = (bookId, bookTitle) => {
    if (confirm(`Opravdu chcete smazat knihu "${bookTitle}"?`)) {
      // Resetuj dirty state před smazáním
      isDirty = false;

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

    // Inicializace dirty state trackingu
    initializeDirtyStateTracking();
  };

  // Inicializace sledování dirty state ve formulářích
  const initializeDirtyStateTracking = () => {
    const bookForm = document.querySelector(".book-form");

    if (!bookForm) {
      return;
    }

    // Uložení původních dat
    storeOriginalFormData(bookForm);

    // Sledování změn v polích
    const formFields = bookForm.querySelectorAll("input, textarea, select");
    formFields.forEach((field) => {
      field.addEventListener("input", () => checkDirtyState(bookForm));
      field.addEventListener("change", () => checkDirtyState(bookForm));
    });

    // Resetování dirty state při odeslání formuláře
    bookForm.addEventListener("submit", () => {
      isDirty = false;
    });

    // Varování při opuštění stránky s dirty state
    window.addEventListener("beforeunload", handleBeforeUnload);

    // Varování při kliknutí na odkazy s dirty state
    document.addEventListener("click", handleLinkClick);
  };

  // Uložení původních dat formuláře
  const storeOriginalFormData = (form) => {
    const formData = new FormData(form);
    originalFormData = {};

    for (let [key, value] of formData.entries()) {
      originalFormData[key] = value;
    }
  };

  // Kontrola dirty state formuláře
  const checkDirtyState = (form) => {
    const currentFormData = new FormData(form);
    let formIsDirty = false;

    // Porovnání aktuálních dat s původními
    for (let [key, value] of currentFormData.entries()) {
      if (originalFormData[key] !== value) {
        formIsDirty = true;
        break;
      }
    }

    // Kontrola smazaných polí
    if (!formIsDirty) {
      for (let key in originalFormData) {
        if (!currentFormData.has(key) && originalFormData[key] !== "") {
          formIsDirty = true;
          break;
        }
      }
    }

    isDirty = formIsDirty;
    updateSaveButton(form, formIsDirty);
    updateFormIndicator(form, formIsDirty);
  };

  // Aktualizace tlačítka pro uložení dle dirty state
  const updateSaveButton = (form, formIsDirty) => {
    const saveButton = form.querySelector('button[type="submit"]');

    if (saveButton) {
      if (formIsDirty) {
        saveButton.classList.add("dirty-state");
      } else {
        saveButton.classList.remove("dirty-state");
      }
    }
  };

  // Aktualizace vizuálního indikátoru dirty state
  const updateFormIndicator = (form, formIsDirty) => {
    if (formIsDirty) {
      form.classList.add("dirty-state");
    } else {
      form.classList.remove("dirty-state");
    }
  };

  // Obsluha před opuštěním stránky s dirty state
  const handleBeforeUnload = (e) => {
    if (isDirty) {
      const message = dirtyStateMessage;
      e.preventDefault();
      e.returnValue = message;
      return message;
    }
  };

  // Obsluha kliknutí na odkazy při dirty state
  const handleLinkClick = (e) => {
    if (isDirty && e.target.tagName === "A") {
      // Ignoruj tlačítka a interní akce
      if (
        e.target.classList.contains("btn") ||
        e.target.href.includes("#") ||
        e.target.href.includes("javascript:")
      ) {
        return;
      }

      if (!confirm(dirtyStateMessage)) {
        e.preventDefault();
      } else {
        isDirty = false; // Resetuj dirty state při potvrzení
      }
    }
  };

  // Privátní funkce pro inicializaci delete buttonů
  const initializeDeleteButtons = () => {
    const deleteButtons = document.querySelectorAll("[data-delete-book]");
    deleteButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        e.preventDefault();
        const { bookId, bookTitle } = button.dataset;

        // Pokud je formulář ve dirty state, zeptej se dvakrát
        if (isDirty) {
          if (!confirm(dirtyStateMessage)) {
            return;
          }
        }

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
