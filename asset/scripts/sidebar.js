(() => {
  try {
    if (
      window.matchMedia("(max-width: 760px)").matches &&
      localStorage.getItem("expense-sidebar-mobile") !== "open"
    ) {
      document.documentElement.classList.add("sidebar-mobile-hidden");
    }
  } catch (error) {
    if (window.matchMedia("(max-width: 760px)").matches) {
      document.documentElement.classList.add("sidebar-mobile-hidden");
    }
  }

  const toggle = document.querySelector(".user-sidebar-toggle");
  const overlay = document.querySelector(".user-sidebar-overlay");
  const layout = document.querySelector(".user-layout");
  const sidebar = document.querySelector("#user-sidebar");
  const sidebarLinks = document.querySelectorAll(".user-nav-link");

  if (!toggle || !overlay || !layout || !sidebar) {
    return;
  }

  const mobile = window.matchMedia("(max-width: 760px)");

  if (document.documentElement.classList.contains("sidebar-mobile-hidden")) {
    layout.classList.add("sidebar-collapsed");
    sidebar.setAttribute("aria-hidden", "true");
    toggle.setAttribute("aria-expanded", "false");
  }

  const setOpen = (open) => {
    layout.classList.toggle("sidebar-collapsed", !open);
    document.documentElement.classList.toggle(
      "sidebar-mobile-hidden",
      mobile.matches && !open,
    );
    sidebar.setAttribute("aria-hidden", String(!open));
    toggle.setAttribute("aria-expanded", String(open));
    toggle.setAttribute("aria-label", open ? "Hide sidebar" : "Show sidebar");
    toggle.title = open ? "Hide sidebar" : "Show sidebar";
    toggle.innerHTML = `<i class="${open ? "ri-layout-left-line" : "ri-layout-right-line"}" aria-hidden="true"></i>`;
    overlay.setAttribute("aria-hidden", String(!mobile.matches || !open));

    if (mobile.matches) {
      try {
        localStorage.setItem(
          "expense-sidebar-mobile",
          open ? "open" : "closed",
        );
      } catch (error) {
        // Ignore localStorage failures.
      }
    }
  };

  sidebarLinks.forEach((link) => {
  link.addEventListener("click", () => {
    if (mobile.matches) {
      setOpen(false);
    }
  });
});

  toggle.addEventListener("click", () =>
    setOpen(layout.classList.contains("sidebar-collapsed")),
  );
  overlay.addEventListener("click", () => setOpen(false));

  document.addEventListener("keydown", (event) => {
    if (
      event.key === "Escape" &&
      mobile.matches &&
      !layout.classList.contains("sidebar-collapsed")
    ) {
      setOpen(false);
    }
  });

  mobile.addEventListener("change", () => {
    let open = true;
    if (mobile.matches) {
      try {
        open = localStorage.getItem("expense-sidebar-mobile") === "open";
      } catch (error) {
        open = false;
      }
    }
    setOpen(open);
  });

  overlay.setAttribute(
    "aria-hidden",
    String(!mobile.matches || layout.classList.contains("sidebar-collapsed")),
  );
})();
