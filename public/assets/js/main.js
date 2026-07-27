(function () {
  //===== Prealoder

  window.onload = function () {
    window.setTimeout(fadeout, 500);
  };

  function fadeout() {
    const preloader = document.querySelector(".preloader");
    if (!preloader) return;
    preloader.style.opacity = "0";
    preloader.style.display = "none";
  }

  /*=====================================
    Sticky
    ======================================= */
  window.onscroll = function () {
  const header_navbar = document.querySelector(".navbar-area");
  if (!header_navbar) return;

  const sticky = header_navbar.offsetTop;

  if (window.pageYOffset > sticky) {
    header_navbar.classList.add("sticky");
  } else {
    header_navbar.classList.remove("sticky");
  }

  // show or hide the back-to-top button
  // sekaligus atur posisi tombol dark mode
  const backToTop = document.querySelector(".scroll-top");
  const darkModeToggle = document.getElementById("landingDarkModeToggle");

  const isScrolled =
    document.body.scrollTop > 50 ||
    document.documentElement.scrollTop > 50;

  if (backToTop) {
    if (isScrolled) {
      backToTop.style.display = "flex";

      if (darkModeToggle) {
        darkModeToggle.classList.add("back-to-top-visible");
      }
    } else {
      backToTop.style.display = "none";

      if (darkModeToggle) {
        darkModeToggle.classList.remove("back-to-top-visible");
      }
    }
  }
};

  // for menu scroll
  const pageLink = document.querySelectorAll(".page-scroll");

  pageLink.forEach((elem) => {
    elem.addEventListener("click", (e) => {
      const targetSelector = elem.getAttribute("href");
      const target = targetSelector ? document.querySelector(targetSelector) : null;
      if (!target) return;
      e.preventDefault();

      // Kalkulasi posisi scroll dikurangi tinggi navbar (sekitar 85px)
      const headerOffset = 85;
      const elementPosition = target.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

      window.scrollTo({
           top: offsetPosition,
           behavior: "smooth"
      });
    });
  });

  // section menu active
  function onScroll(event) {
    const sections = document.querySelectorAll(".page-scroll");
    const scrollPos =
      window.pageYOffset ||
      document.documentElement.scrollTop ||
      document.body.scrollTop;

    sections.forEach((currLink) => {
      const val = currLink.getAttribute("href");
      const refElement = val ? document.querySelector(val) : null;
      if (!refElement) return;

      // Kalkulasi posisi absolut elemen dari ujung atas dokumen (mengabaikan relative parent)
      const refElementTop = refElement.getBoundingClientRect().top + window.pageYOffset;
      const refElementBottom = refElementTop + refElement.offsetHeight;
      const scrollOffset = scrollPos + 90; // Toleransi tinggi navbar

      // Tambahkan class active jika posisi layar sedang berada di elemen ini
      if (refElementTop <= scrollOffset && refElementBottom > scrollOffset) {
        currLink.classList.add("active");
      } else {
        currLink.classList.remove("active");
      }
    });
  }

  window.document.addEventListener("scroll", onScroll);

  //===== Membuka dan Menutup Navbar di Mobile (MANUAL 100%)
  let btnNav = document.getElementById("btn-nav-mobile");
  let navContent = document.getElementById("navbarSupportedContent");

  if (btnNav && navContent) {
    // 1. Fungsi klik tombol garis tiga
    btnNav.onclick = function (e) {
        e.preventDefault();
        this.classList.toggle("active");
        navContent.classList.toggle("show");
    };

    // 2. Fungsi klik isi navbar otomatis tutup
    document.querySelectorAll(".page-scroll, .tng-navbar-cta").forEach((link) => {
        link.onclick = function () {
            btnNav.classList.remove("active");
            navContent.classList.remove("show");
        };
    });

    // 3. TAMBAHAN BARU: Fungsi klik di luar navbar otomatis tutup
    document.addEventListener('click', function (event) {
        // Cek apakah menu sedang terbuka
        let isMenuOpen = btnNav.classList.contains("active") || navContent.classList.contains("show");

        // Jika menu terbuka DAN yang diklik BUKAN isi menu DAN BUKAN tombol toggle
        if (isMenuOpen && !navContent.contains(event.target) && !btnNav.contains(event.target)) {
            btnNav.classList.remove("active");
            navContent.classList.remove("show");
        }
    });
  }

  // WOW active
if (typeof WOW !== "undefined") {
  new WOW().init();
}

// ======================================
// LANDING PAGE DARK MODE
// ======================================

const landingDarkModeToggle = document.getElementById("landingDarkModeToggle");
const themeIcon = document.getElementById("themeIcon");

function updateLandingThemeIcon(isDark) {
  if (!themeIcon) return;

  themeIcon.className = isDark
    ? "lni lni-sun"
    : "lni lni-night";
}

const isLandingDark =
  localStorage.getItem("theme") === "dark";

updateLandingThemeIcon(isLandingDark);

if (landingDarkModeToggle) {
  landingDarkModeToggle.addEventListener("click", function () {

    const isDark = document.documentElement.classList.toggle("dark-mode");

    localStorage.setItem(
      "theme",
      isDark ? "dark" : "light"
    );

    updateLandingThemeIcon(isDark);
  });
}

})();
