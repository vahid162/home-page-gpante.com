(() => {
  "use strict";

  const tabButtons = Array.from(document.querySelectorAll("[data-tab]"));
  const tabPanels = Array.from(document.querySelectorAll(".hp-tab-panel"));

  function activateTab(button) {
    const targetId = button.dataset.tab;

    tabButtons.forEach((item) => {
      const active = item === button;
      item.classList.toggle("is-active", active);
      item.setAttribute("aria-selected", String(active));
      item.tabIndex = active ? 0 : -1;
    });

    tabPanels.forEach((panel) => {
      const active = panel.id === targetId;
      panel.classList.toggle("is-active", active);
      panel.hidden = !active;
    });
  }

  tabButtons.forEach((button, index) => {
    button.addEventListener("click", () => activateTab(button));

    button.addEventListener("keydown", (event) => {
      if (!["ArrowLeft", "ArrowRight", "Home", "End"].includes(event.key)) {
        return;
      }

      event.preventDefault();

      let nextIndex = index;
      if (event.key === "ArrowLeft") nextIndex = (index + 1) % tabButtons.length;
      if (event.key === "ArrowRight") nextIndex = (index - 1 + tabButtons.length) % tabButtons.length;
      if (event.key === "Home") nextIndex = 0;
      if (event.key === "End") nextIndex = tabButtons.length - 1;

      tabButtons[nextIndex].focus();
      activateTab(tabButtons[nextIndex]);
    });
  });

  const categoryToggle = document.querySelector("[data-category-toggle]");
  const categoryGrid = document.querySelector("[data-category-grid]");

  if (categoryToggle && categoryGrid) {
    categoryToggle.addEventListener("click", () => {
      const expanded = categoryToggle.getAttribute("aria-expanded") === "true";
      categoryToggle.setAttribute("aria-expanded", String(!expanded));
      categoryGrid.classList.toggle("is-expanded", !expanded);
      categoryToggle.textContent = expanded ? "نمایش دسته‌های بیشتر" : "نمایش دسته‌های کمتر";
    });
  }

  const searchForm = document.querySelector("[data-prototype-search]");

  if (searchForm) {
    searchForm.addEventListener("submit", (event) => {
      event.preventDefault();
      const input = searchForm.querySelector("input[type='search']");
      const query = input?.value.trim();

      if (!query) {
        input?.focus();
        return;
      }

      const productsSection = document.getElementById("products");
      productsSection?.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  }

  const contactForm = document.querySelector("[data-contact-form]");

  if (contactForm) {
    const input = contactForm.querySelector("input[name='mobile']");
    const status = document.getElementById("mobile-status");

    contactForm.addEventListener("submit", (event) => {
      event.preventDefault();

      if (!input || !status) return;

      const normalized = input.value.replace(/\D/g, "");
      const valid = /^09\d{9}$/.test(normalized);

      status.classList.remove("is-error", "is-success");

      if (!valid) {
        status.textContent = "شماره موبایل را به شکل 09xxxxxxxxx وارد کنید.";
        status.classList.add("is-error");
        input.setAttribute("aria-invalid", "true");
        input.focus();
        return;
      }

      input.removeAttribute("aria-invalid");
      status.textContent = "Prototype: شماره معتبر است؛ هیچ اطلاعاتی ارسال نشد.";
      status.classList.add("is-success");
    });
  }
})();
