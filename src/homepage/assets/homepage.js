(() => {
  "use strict";

  const section = document.querySelector("[data-products-section]");
  const tabButtons = Array.from(document.querySelectorAll("[data-tab]"));
  const tabPanels = Array.from(document.querySelectorAll(".hp-tab-panel"));
  let bestSellersLoaded = false;
  let bestSellersLoading = false;

  function formatStorePrice(prices) {
    if (!prices || prices.price === undefined || prices.price === null) return "";

    const raw = Number(prices.price);
    const minor = Number(prices.currency_minor_unit || 0);
    if (!Number.isFinite(raw) || !Number.isFinite(minor)) return "";

    const amount = raw / Math.pow(10, minor);
    const formatted = new Intl.NumberFormat("fa-IR", {
      maximumFractionDigits: Math.max(0, minor),
    }).format(amount);

    const prefix = String(prices.currency_prefix || "");
    const suffix = String(prices.currency_suffix || "");
    const symbol = String(prices.currency_symbol || "");

    if (prefix || suffix) return (prefix + formatted + suffix).trim();
    return (formatted + " " + symbol).trim();
  }

  function createBestSellerCard(product) {
    const article = document.createElement("article");
    article.className = "hp-product-card hp-product-card--new";

    const media = document.createElement("a");
    media.className = "hp-product-card__media";
    media.href = String(product.permalink || "#");

    const image = Array.isArray(product.images) ? product.images[0] : null;
    if (image && (image.thumbnail || image.src)) {
      const img = document.createElement("img");
      img.src = String(image.thumbnail || image.src);
      img.alt = String(image.alt || product.name || "");
      img.loading = "lazy";
      img.decoding = "async";
      if (image.srcset) img.srcset = String(image.srcset);
      if (image.sizes) img.sizes = String(image.sizes);
      media.appendChild(img);
    } else {
      const placeholder = document.createElement("span");
      placeholder.className = "hp-product-card__placeholder";
      placeholder.setAttribute("aria-hidden", "true");
      media.appendChild(placeholder);
    }

    if (product.on_sale) {
      const badge = document.createElement("span");
      badge.className = "hp-sale-badge";
      badge.textContent = "تخفیف";
      media.appendChild(badge);
    }

    const body = document.createElement("div");
    body.className = "hp-product-card__body";

    const brand = document.createElement("div");
    brand.className = "hp-product-card__brand";
    brand.textContent = "پانته";

    const heading = document.createElement("h3");
    const titleLink = document.createElement("a");
    titleLink.href = String(product.permalink || "#");
    titleLink.textContent = String(product.name || "");
    heading.appendChild(titleLink);

    const price = document.createElement("div");
    price.className = "hp-price";
    price.textContent = formatStorePrice(product.prices);

    body.append(brand, heading, price);
    article.append(media, body);

    return article;
  }

  async function loadBestSellers() {
    if (!section || bestSellersLoaded || bestSellersLoading) return;

    const endpoint = section.dataset.bestSellersUrl;
    const grid = section.querySelector("[data-best-products-grid]");
    const status = section.querySelector("[data-best-products-status]");

    if (!endpoint || !grid) return;

    bestSellersLoading = true;

    try {
      const response = await fetch(endpoint, {
        method: "GET",
        credentials: "same-origin",
        headers: { Accept: "application/json" },
      });

      if (!response.ok) throw new Error("Store API request failed");

      const products = await response.json();
      if (!Array.isArray(products) || products.length === 0) {
        throw new Error("No bestseller products returned");
      }

      grid.replaceChildren(...products.map(createBestSellerCard));
      bestSellersLoaded = true;
    } catch (error) {
      if (status) {
        status.textContent = "پرفروش‌ترین‌ها فعلاً در دسترس نیستند.";
      }

      const fallbackUrl = section.dataset.bestSellersFallbackUrl;
      if (grid && fallbackUrl && !grid.querySelector("[data-best-fallback]")) {
        const fallback = document.createElement("a");
        fallback.href = fallbackUrl;
        fallback.className = "hp-btn hp-btn--outline";
        fallback.dataset.bestFallback = "true";
        fallback.textContent = "مشاهده پرفروش‌ترین‌ها در فروشگاه";
        grid.appendChild(fallback);
      }
    } finally {
      bestSellersLoading = false;
    }
  }

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

    if (targetId === "best-products") loadBestSellers();
  }

  tabButtons.forEach((button, index) => {
    button.addEventListener("click", () => activateTab(button));

    button.addEventListener("keydown", (event) => {
      if (!["ArrowLeft", "ArrowRight", "Home", "End"].includes(event.key)) return;

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

  const contactForm = document.querySelector("[data-contact-form]");

  if (contactForm) {
    const input = contactForm.querySelector("input[name='mobile']");
    const status = document.getElementById("mobile-status");

    const normalizeDigits = (value) =>
      value
        .replace(/[۰-۹]/g, (d) => String("۰۱۲۳۴۵۶۷۸۹".indexOf(d)))
        .replace(/[٠-٩]/g, (d) => String("٠١٢٣٤٥٦٧٨٩".indexOf(d)))
        .replace(/\D/g, "");

    contactForm.addEventListener("submit", (event) => {
      if (!input || !status) return;

      const normalized = normalizeDigits(input.value);
      status.classList.remove("is-error", "is-success");

      if (!/^09\d{9}$/.test(normalized)) {
        event.preventDefault();
        input.setAttribute("aria-invalid", "true");
        status.textContent = "شماره موبایل را به شکل 09xxxxxxxxx وارد کنید.";
        status.classList.add("is-error");
        input.focus();
        return;
      }

      input.value = normalized;
      input.removeAttribute("aria-invalid");
    });
  }
})();
