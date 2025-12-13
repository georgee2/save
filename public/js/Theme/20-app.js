// COOKIES SCRIPT
const cookieContainer = document.querySelector(".cookie-banner");
const cookieButton = cookieContainer.querySelector(".cookie-btn");
cookieButton.addEventListener("click", () => {
  cookieContainer.classList.remove("active");
  localStorage.setItem("cookieDisplayed", "true");
});
setTimeout(() => {
  if (!localStorage.getItem("cookieDisplayed")) {
    cookieContainer.classList.add("active");
  }
}, 2000);

// ===============================================================

//  SWITCH COLOR THEME
let lightMode = localStorage.getItem("lightMode"),
  textMode = localStorage.getItem("textMode"),
  textModeToggle = $(".theme-mode span"),
  lightModeToggle = $(".theme-mode");

const enableLightMode = () => {
  $("body").addClass("lightmode");
  $(textModeToggle).text("Dark Mode");
  localStorage.setItem("lightMode", "enabled");
  localStorage.setItem("textMode", "enabled");
};
const disableLightMode = () => {
  $("body").removeClass("lightmode");
  $(textModeToggle).text("Light Mode");
  localStorage.setItem("lightMode", null);
  localStorage.setItem("textMode", null);
};
if (lightMode === "enabled" && textMode === "enabled") {
  enableLightMode();
}
$(lightModeToggle).on("click", () => {
  lightMode = localStorage.getItem("lightMode");
  textMode = localStorage.getItem("textMode");
  if (lightMode !== "enabled" && textMode !== "enabled") {
    enableLightMode();
  } else {
    disableLightMode();
  }
});

// =====================================================================

// READY JQUERY FUNCTION
$(document).ready(function () {
  // REGISTER GSAP PLUGINS //
  gsap.registerPlugin(
    ScrollTrigger,
    CustomEase,
    ExpoScaleEase,
    DrawSVGPlugin,
    SplitText
  );

  // =======================================================================

  // LOCOMOTIVE SCROLL INIT
  const locoScroll = new LocomotiveScroll({
    el: document.querySelector(".smooth-scroll"),
    smooth: true,
    // lerp: .1
  });
  // each time Locomotive Scroll updates, tell ScrollTrigger to update too (sync positioning)
  locoScroll.on("scroll", ScrollTrigger.update);

  // tell ScrollTrigger to use these proxy methods for the ".smooth-scroll" element since Locomotive Scroll is hijacking things
  ScrollTrigger.scrollerProxy(".smooth-scroll", {
    scrollTop(value) {
      return arguments.length
        ? locoScroll.scrollTo(value, 0, 0)
        : locoScroll.scroll.instance.scroll.y;
    }, // we don't have to define a scrollLeft because we're only scrolling vertically.
    getBoundingClientRect() {
      return {
        top: 0,
        left: 0,
        width: window.innerWidth,
        height: window.innerHeight,
      };
    },
    // LocomotiveScroll handles things completely differently on mobile devices - it doesn't even transform the container at all! So to get the correct behavior and avoid jitters, we should pin things with position: fixed on mobile. We sense it by checking to see if there's a transform applied to the container (the LocomotiveScroll-controlled element).
    pinType: document.querySelector(".smooth-scroll").style.transform
      ? "transform"
      : "fixed",
  });

  // =======================================================================

  //  SHOW/HIDE SCROLL UP BUTTON SCRIPT
  locoScroll.on("scroll", function () {
    $(".go-to-up").addClass("show");
  });

  //  GO TO TOP PAGE BUTTON
  $(".go-to-up").click(function () {
    locoScroll.scrollTo(0);
  });

  // ==================================================================

  //  INIT ALL GLOBAL VARIABLES
  let cursor = $(".cursor"),
    follower = $(".cursor__follower"),
    link = $(".navbar-links > .navbar-link"),
    innerLink = $(link).find("span"),
    burger = $(".hamburger-menu span.burger"),
    momMenu = $("header .mom-menu"),
    menu = $("header .menu"),
    exitMenu = $("header .menu .exit-menu"),
    barOne = $("header #bar-1"),
    barTwo = $("header #bar-2"),
    line = $(".navbar-links .line"),
    contactBlock = $(".menu .contact-block");

  // =======================================================================

  //  CUSTOM CURSOR SCRIPT
  $(this).mouseout(function () {
    $(cursor).css({ width: 0, height: 0 });
    $(follower).css({ width: 0, height: 0 });
  });

  $(this).mousemove(function (e) {
    $(".hovered-cursor").css({
      top: e.clientY - 8,
      left: e.clientX - 8,
    });
    $(cursor).css({
      width: "15px",
      height: "15px",
      transform: `translate3d(${e.clientX - 10}px, ${e.clientY - 10}px, 0)`,
    });
    $(follower).css({
      width: "6px",
      height: "6px",
      transform: `translate3d(${e.clientX - 10}px, ${e.clientY - 10}px, 0)`,
    });
  });

  $(".hover-this").mouseover(function () {
    $(".hovered-cursor").addClass("hover");
    $(cursor).hide();
  });
  $(".hover-this").mouseout(function () {
    $(".hovered-cursor").removeClass("hover");
    $(cursor).show();
  });

  $(".not-hoverable").mouseover(function () {
    $(cursor).hide();
  });
  $(".not-hoverable").mouseout(function () {
    $(cursor).show();
  });

  // =======================================================================

  //  ANIMATE NAVBAR LINKS ON HOVER
  let animateit = function (e) {
    let span = this.querySelector("span"),
      x = (e.offsetX / this.offsetWidth) * (20 * 2) - 20,
      y = (e.offsetY / this.offsetHeight) * (20 * 2) - 20;

    $(span).css("transform", ` translate( ${x}px, ${y}px ) `);
    $(this).css("overflow", "visible");

    if (e.type === "mouseleave") {
      $(span).css("transform", "");
      $(this).css("overflow", "hidden");
    }
  };

  $(link).on("mousemove", animateit);
  $(link).on("mouseleave", animateit);

  // =======================================================================

  //  TIMELINE ANIMATION FOR NAVBAR MENU
  let toggleMenu = gsap.timeline({ defaults: { duration: 1 } });

  toggleMenu
    .to(".hamburger-menu", {
      duration: 0.5,
      autoAlpha: 0,
      ease: "power1.inOut",
    })
    .to(barOne, {
      duration: 0.5,
      scaleX: 0,
      transformOrigin: "right",
      ease: "power1.inOut",
    })
    .to(
      barTwo,
      { duration: 0.5, height: "100vh", ease: "power2.inOut" },
      "-=.4"
    )
    .to(momMenu, { duration: 0, autoAlpha: 1, ease: "none" }, "-=.4")
    .to(menu, { duration: 1, x: 0, ease: "power3.inOut" }, "-=.4")
    .fromTo(
      innerLink,
      { y: 50, autoAlpha: 0 },
      { stagger: 0.1, y: "0", autoAlpha: 1, ease: "expo.out" },
      "-=.4"
    )
    .from(
      contactBlock,
      { y: 30, stagger: 0.1, autoAlpha: 0, ease: "expo.out" },
      "<"
    )
    .from(
      ".social-links li",
      { stagger: 0.1, autoAlpha: 0, y: 30, ease: "expo.out" },
      "<"
    )
    .to(
      line,
      {
        duration: 0.5,
        scaleX: 1,
        transformOrigin: "left",
        ease: "power2.inOut",
      },
      1.1
    );

  toggleMenu.reverse();
  $(burger).click(function () {
    toggleMenu.play();
  });
  $(exitMenu).click(function () {
    toggleMenu.reverse();
  });

  // =======================================================================

  // ANCHOR SCROLL SMOOTH

  $("a.navbar-link").on("click", function (event) {
    event.preventDefault();
    var id = $(this).attr("href");
    locoScroll.scrollTo(id);
    toggleMenu.reverse();
  });

  // ============================================================

  let splashScreen = $("#splash-screen"),
    senergicLogo = $("#main-logo"),
    logoCirc = $(".senergic-logo .logo-chars.circle"),
    circle = $(".scroll-down .circle"),
    dot = $(".scroll-down .dots .dot"),
    scrollText = $(".scroll-down-wrapper .text"),
    innerHeadline = $("h1.headline > span"),
    splitHeadline = new SplitText(innerHeadline, { type: "words" }),
    SplitScrollText = new SplitText(scrollText, { type: "words,chars" });

  CustomBounce.create("myBounce", { strength: 0.8, squash: 4 });

  function splashAnimate() {
    let tl = gsap.timeline();
    tl.to(senergicLogo, {
      keyframes: [{ duration: 1, autoAlpha: 1, ease: "power1.inOut" }],
    })
      .fromTo(
        ".senergic-logo .logo-chars",
        { drawSVG: "50% 50%" },
        {
          duration: 1.5,
          drawSVG: "0% 100%",
          stagger: { amount: 1 },
          ease: "expo.out",
        }
      )
      .from(logoCirc, { duration: 1, y: 10, x: 120, ease: "expo" }, "-=.5")
      .to(logoCirc, { duration: 2, y: 0, ease: "myBounce" }, "+=.5")
      .to(
        logoCirc,
        {
          duration: 2,
          scaleY: 0.7,
          scaleX: 1.3,
          transformOrigin: "bottom",
          ease: "myBounce-squash",
        },
        "<"
      )
      .to(splashScreen, {
        duration: 1,
        transformOrigin: "top",
        scaleY: 0,
        ease: "expo.inOut",
      })
      .to(
        senergicLogo,
        { duration: 1, top: "5rem", zIndex: 10, ease: "expo.inOut" },
        "<"
      )
      .to("#main-logo svg", { duration: 1, z: 0, ease: "expo.inOut" }, "<")
      .to(
        ".senergic-logo .logo-chars",
        {
          duration: 1,
          stroke: "transparent",
          fill: "#ca2026",
          ease: "expo.in",
        },
        "-=1.3"
      )
      .to("body", {
        duration: 0,
        position: "static",
        cursor: "none",
        ease: "none",
      });
    return tl;
  }
  function bannerAnimate() {
    let tl = gsap.timeline();
    tl.fromTo(
      ".hamburger-menu",
      { y: 10, autoAlpha: 0 },
      { y: 0, autoAlpha: 1, ease: "power1.inOut" }
    )
      .fromTo(
        ".spinner",
        { autoAlpha: 0 },
        { autoAlpha: 1, ease: "power1.inOut" }
      )
      .to(
        barOne,
        {
          duration: 0.5,
          transformOrigin: "right",
          scaleX: 1,
          ease: "power4.inOut",
        },
        "<"
      )
      .to(
        barTwo,
        {
          duration: 0.5,
          transformOrigin: "top",
          scaleY: 1,
          ease: "power4.inOut",
        },
        "<"
      )
      .to(
        "#tsparticles",
        { duration: 0.8, scale: 1, ease: "power4.inOut" },
        "<"
      )
      .to(".switch-site", { duration: 0.8, autoAlpha: 1 }, "<")
      .to(".live-chat", { duration: 0.8, autoAlpha: 1 }, "<")
      .fromTo(
        lightModeToggle,
        { y: 10, autoAlpha: 0 },
        { duration: 0.5, y: 0, autoAlpha: 1, ease: "back.out" },
        "<"
      )
      .to(
        splitHeadline.words,
        {
          duration: 1,
          css: { clipPath: "polygon(100% 0, 0 0, 0 100%, 100% 100%)" },
          stagger: 0.1,
          ease: "power3.inOut",
          onComplete: allDone,
        },
        "<"
      )
      .to("h1.headline .before-title", {
        duration: 0.7,
        scaleX: 1,
        ease: "power1.inOut",
      });
    function allDone() {
      splitHeadline.revert();
    }
    return tl;
  }
  function scrollDownInit() {
    let tl = gsap.timeline();
    tl.fromTo(
      circle,
      { scale: 0 },
      { duration: 0.2, scale: 1, ease: "expo.inOut" }
    )
      .set(dot, { className: "dot active" })
      .from(
        SplitScrollText.chars,
        {
          duration: 0.5,
          opacity: 0,
          force3D: true,
          stagger: { each: 0.015, from: "center" },
          ease: "power1.inOut",
          onComplete: allDone,
        },
        "<"
      );
    function allDone() {
      SplitScrollText.revert();
    }
    // x: gsap.utils.wrap([-40, 40]),
    return tl;
  }
  function scrollDownAnimate() {
    let dotsWrap = $(".scroll-down .dots");
    let dotsWrapHeight = $(dotsWrap).height();
    let tl = gsap.timeline();
    tl.to(circle, { duration: 0.3, scale: 0.4, ease: "power1.inOut" }, 0.8)
      .to(
        dotsWrap,
        { duration: 0.8, height: 0, ease: "power3.inOut" },
        "-=0.18"
      )
      .to(circle, { duration: 0.5, scale: 1, ease: "power1.inOut" }, "+=.24")
      .to(
        dotsWrap,
        { duration: 1, height: dotsWrapHeight, ease: "power1.inOut" },
        "-=0.01"
      );
    return tl;
  }
  function repeatCircleAnim() {
    let tl = gsap
      .timeline({ repeat: -1, repeatDelay: 3 })
      .to(logoCirc, { y: -35 })
      .to(logoCirc, { duration: 2, y: 0, ease: "myBounce" })
      .to(
        logoCirc,
        {
          duration: 2,
          scaleY: 0.7,
          scaleX: 1.3,
          transformOrigin: "bottom",
          ease: "myBounce-squash",
        },
        "<"
      );
    return tl;
  }

  let masterTL = gsap.timeline();
  masterTL
    .add(splashAnimate())
    .add(bannerAnimate())
    .add(scrollDownInit())
    .add(scrollDownAnimate().repeat(-1))
    .add(repeatCircleAnim(), "lab");

  //  DEAR MY FRIEND (BACKEND DEVELOPER) RELEASE THIS LINE DOWN BELLOW FROM ITS COMMENT
  // ( LINE 250 )
  //  IF YOU LIKE TO SKIP SPLASH SCREEN ANIMATION DURING YOUR WORK
  // masterTL.seek('lab');
  // masterTL.timeScale(15);

  // masterTL.play();
  // masterTL.duration(8); // set duration
  // console.log(masterTL.duration()); // get duration
  // console.log(masterTL.isActive());
  // console.log(masterTL.progress());

  // gsap.ticker.add(myFunction);
  // function myFunction() {
  //   console.log('bla bla bla')
  // }
  // this function will run every time that GSAP updates

  // gsap.getProperty(element, "x")

  // ===========================================================================

  // ANIMATE WHY US SECTION STUFF ON SCROLL

  let whyUs = $(".why-us"),
    whyTitle = $(".svg-drawing svg#why-us-title > path"),
    whyItems = $(".why-us .why-items li span");

  let animwhyUs = gsap
    .timeline()
    .fromTo(
      whyTitle,
      { drawSVG: "50% 50%" },
      { duration: 1, drawSVG: "0% 105%", stagger: { amount: 1 } }
    )
    .to(
      whyItems,
      {
        duration: 1,
        autoAlpha: 1,
        y: 0,
        stagger: { each: 0.03, from: "start" },
        ease: "power1.out",
      },
      "<"
    )
    .to(
      ".why-us .down-arrow .vert-line",
      { transformOrigin: "top", scaleY: 1 },
      "-=1"
    )
    .to(".why-us .down-arrow .vert-line .arr-1", { y: 0, opacity: 1 }, "-=.5");

  let whyAnimTxt = $(".why-us .animated-txt li"),
    splitAnimTxt = new SplitText(whyAnimTxt, { type: "words,chars" });
  let slideTxt = gsap
    .timeline({ repeat: -1 })
    .to(".animated-txt li", { opacity: 1 })
    .from(splitAnimTxt.chars, { duration: 0, autoAlpha: 0, stagger: 0.022 })
    .to(splitAnimTxt.chars, { duration: 1, autoAlpha: 0, delay: 2 });

  ScrollTrigger.create({
    trigger: whyUs,
    animation: animwhyUs,
    scroller: ".smooth-scroll",
    start: "top 75%",
    end: "bottom top",
    toggleActions: "play complete none reverse",
    // toggleActions: 'onEnter, onLeave, onEnterBack, onLeaveBack',
    // The default is play none none none
    // keywords for each action: "play", "pause", "resume", "reset", "restart", "complete", "reverse", and "none".
    // markers: true,
    // anticipatePin: 1,
    // toggleClass: 'active',
    // toggleClass: { targets: promotion, className: 'shrink'},
    // pinSpacing: false
    // snap: 0.1,
    // snap: (value) => Math.round(value / 0.2) * 0.2,
    // snap: {snapTo: "labels", duration: {min: 0.2, max: 3}, delay: 0.1, ease: "power1.inOut"}
  });

  ScrollTrigger.create({
    trigger: whyUs,
    animation: slideTxt,
    scroller: ".smooth-scroll",
    start: "top 75%",
    end: "bottom top",
    toggleActions: "restart restart restart restart",
  });

  // =================================================================

  // ANIMATE PROMOTION SECTION ON SCROLL

  let promotion = $("section.promotion"),
    promotionMap = $(".promotion svg path"),
    lampImg = $(".promotion .lamp");

  let animpromotion = gsap.timeline();
  animpromotion
    .to(lampImg, { y: 0, ease: "power1.in" })
    .to(lampImg, { opacity: 1, ease: "power1.in" })
    .fromTo(
      promotionMap,
      { drawSVG: "50% 50%" },
      { duration: 1, drawSVG: "0% 100%" }
    )
    .to(".promotion ul.slide-text li span", {
      autoAlpha: 1,
      y: 0,
      stagger: 0.1,
    });

  ScrollTrigger.create({
    trigger: promotion,
    scroller: ".smooth-scroll",
    animation: animpromotion,
    start: "top center",
    end: "bottom top",
    toggleActions: "play complete none reverse",
    // scrub: true,
    // pin: promotion,
    // anticipatePin: 1,
    // pinSpacing: false
    // markers: true,
  });

  // ANIMATE VISION SECTION STUFF ON SCROLL

  let visionBlock = $("section.vision"),
    entranceSvgScene = $("section.vision .entrance-scene svg"),
    VisionContent = $("section.vision .vision-content");

  let animVision = gsap
    .timeline()
    .to(entranceSvgScene, { scale: 30 })
    .to("section.vision .entrance-scene", { display: "none" }, "<")
    // .to('section.vision .vision-video .overlay', { opacity: 1 }, '-=.5')
    .to(VisionContent, { yPercent: -100, ease: "none" })
    .to("section.vision h2.head-title", { className: "head-title active" });
  // .to('.vision-content p', { className: 'active' })

  ScrollTrigger.create({
    trigger: visionBlock,
    animation: animVision,
    scroller: ".smooth-scroll",
    start: "top top",
    end: "+=200%",
    scrub: true,
    pin: visionBlock,
    // anticipatePin: 1,
    // pinSpacing: false
    // markers: true,
  });

  // ===========================================================================

  // ANIMATE TECHNOLOGY SECTION STUFF ON SCROLL

  gsap.to("section.our-technology h2.head-title", {
    className: "head-title active",
    scrollTrigger: {
      trigger: "section.our-technology",
      scroller: ".smooth-scroll",
      start: "top center",
      toggleActions: "play complete none reverse",
      // markers: true
    },
  });

  gsap.set(".banner__inner--a", { perspectiveOrigin: "center -100vh" });
  gsap.set(".banner__inner--b", { perspectiveOrigin: "right -100vh" });
  gsap.set(".banner__inner--c", { perspectiveOrigin: "center -100vh" });
  gsap.set(".banner__inner--d", { perspectiveOrigin: "right -100vh" });

  gsap.to(".banner__inner--a", {
    scrollTrigger: {
      trigger: ".banner__inner--a",
      scroller: ".smooth-scroll",
      scrub: true,
      start: "top bottom",
      end: "bottom top",
    },
    perspectiveOrigin: "center 100vh",
    ease: "none",
  });

  gsap.to(".banner__inner--b", {
    scrollTrigger: {
      trigger: ".banner__inner--b",
      scroller: ".smooth-scroll",
      scrub: true,
      start: "top bottom",
      end: "bottom top",
    },
    perspectiveOrigin: "right 100vh",
    ease: "none",
  });

  gsap.to(".banner__inner--c", {
    scrollTrigger: {
      trigger: ".banner__inner--c",
      scroller: ".smooth-scroll",
      scrub: true,
      start: "top bottom",
      end: "bottom top",
    },
    perspectiveOrigin: "center 100vh",
    ease: "none",
  });

  gsap.to(".banner__inner--d", {
    scrollTrigger: {
      trigger: ".banner__inner--d",
      scroller: ".smooth-scroll",
      scrub: true,
      start: "top bottom",
      end: "bottom top",
    },
    perspectiveOrigin: "right 100vh",
    ease: "none",
  });

  // ===========================================================================

  // ANIMATE OUR TEAM SECTION STUFF ON SCROLL

  gsap.to("section.teams h2.head-title", {
    className: "head-title active",
    scrollTrigger: {
      trigger: "section.teams",
      scroller: ".smooth-scroll",
      start: "top center",
      toggleActions: "play complete none reverse",
      // markers: true
    },
  });

  // ===========================================================================

  // ANIMATE RESERVATION SECTION STUFF ON SCROLL

  let reservation = $("section.reservation"),
    ctaBtn = $(reservation).find(".cta");
  let animreservation = gsap.timeline();
  animreservation.to(ctaBtn, { duration: 1, x: 0, ease: "power1.in" });
  ScrollTrigger.create({
    trigger: reservation,
    scroller: ".smooth-scroll",
    animation: animreservation,
    start: "top bottom",
    end: "bottom bottom",
    scrub: true,
  });

  // gsap.utils.toArray('.reservation .cta').forEach(function (btn) {
  let ctaWord = ctaBtn.find(".cta__text"),
    splitCtaWord = new SplitText(ctaWord, { type: "words,chars" });

  let animCtaBtn = gsap.timeline({ paused: true });
  animCtaBtn.to(splitCtaWord.chars, {
    duration: 1.5,
    rotationX: 360,
    stagger: 0.025,
    ease: "expo.out",
  });

  ctaBtn.on("mouseenter", function () {
    animCtaBtn.play();
  });
  ctaBtn.on("mouseleave", function () {
    animCtaBtn.reverse();
  });
  // })

  // ANIMATE FOOTER SECTION ON SCROLL

  gsap.to("footer.footer", {
    duration: 0.2,
    autoAlpha: 1,
    position: "sticky",
    scrollTrigger: {
      trigger: "footer.footer",
      scroller: ".smooth-scroll",
      start: "top bottom",
      end: "bottom center",
      toggleActions: "play complete none reverse",
      // toggleActions: 'onEnter, onLeave, onEnterBack, onLeaveBack',
      // markers: true
    },
  });

  // $(window).on("resize", function () {
  //   animVision.seek(0).invalidate().restart();
  //   animServices.seek(0).invalidate().restart();
  //   animpromotion.seek(0).invalidate().restart();
  //   animwhyUs.seek(0).invalidate().restart();
  // })

  // each time the window updates, we should refresh ScrollTrigger and then update LocomotiveScroll.
  ScrollTrigger.addEventListener("refresh", () => locoScroll.update());

  // after everything is set up, refresh() ScrollTrigger and update LocomotiveScroll because padding may have been added for pinning, etc.
  ScrollTrigger.refresh();
});
