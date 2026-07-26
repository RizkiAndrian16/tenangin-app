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

    // show or hide the back-top-top button
    const backToTo = document.querySelector(".scroll-top");
    if (backToTo) {
      if (
        document.body.scrollTop > 50 ||
        document.documentElement.scrollTop > 50
      ) {
        backToTo.style.display = "flex";
      } else {
        backToTo.style.display = "none";
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
      target.scrollIntoView({
        behavior: "smooth",
        offsetTop: 1 - 60,
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

    for (let i = 0; i < sections.length; i++) {
      const currLink = sections[i];
      const val = currLink.getAttribute("href");
      const refElement = val ? document.querySelector(val) : null;
      if (!refElement) continue;
      const scrollTopMinus = scrollPos + 73;
      if (
        refElement.offsetTop <= scrollTopMinus &&
        refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
      ) {
        document.querySelector(".page-scroll").classList.remove("active");
        currLink.classList.add("active");
      } else {
        currLink.classList.remove("active");
      }
    }
  }

  window.document.addEventListener("scroll", onScroll);

  //===== Membuka dan Menutup Navbar di Mobile (MANUAL 100%)
  let btnNav = document.getElementById("btn-nav-mobile");
  let navContent = document.getElementById("navbarSupportedContent");

  if (btnNav && navContent) {
    // Fungsi klik tombol garis tiga
    btnNav.onclick = function (e) {
        e.preventDefault();
        this.classList.toggle("active");
        navContent.classList.toggle("show");
    };

    // Fungsi klik isi navbar otomatis tutup
    document.querySelectorAll(".page-scroll, .tng-navbar-cta").forEach((link) => {
        link.onclick = function () {
            btnNav.classList.remove("active");
            navContent.classList.remove("show");
        };
    });
  }

  // WOW active
  if (typeof WOW !== "undefined") {
    new WOW().init();
  }
})();
