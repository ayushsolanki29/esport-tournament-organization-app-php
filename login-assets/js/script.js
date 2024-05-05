const inputBorders = document.querySelectorAll(".form__input-border"),
  buttonBorders = document.querySelectorAll(".form__button-border"),
  buttonBgFilled = document.querySelectorAll(".filled .form__button-bg");

function clipBorder(element, innerEdgeSize, outerEdgeSize, borderWidth) {
  let elementWidth = element.offsetWidth,
    elementHeight = element.offsetHeight;

  let clipPath = `path("M ${borderWidth},${
    elementHeight - innerEdgeSize - borderWidth
  } L ${innerEdgeSize + borderWidth},${elementHeight - borderWidth} H ${
    elementWidth - borderWidth
  }  V ${innerEdgeSize + borderWidth} L ${
    elementWidth - innerEdgeSize - borderWidth
  },${borderWidth}  H ${borderWidth} V ${
    elementHeight - innerEdgeSize - borderWidth
  } Z M ${
    elementWidth - outerEdgeSize
  },0 L ${elementWidth},${outerEdgeSize} V ${elementHeight} H ${outerEdgeSize} L 0,${
    elementHeight - outerEdgeSize
  } V 0 H ${elementWidth - outerEdgeSize} Z")`;

  element.style.clipPath = clipPath;
}

function clipBg(element, edgeSize) {
  let elementWidth = element.offsetWidth,
    elementHeight = element.offsetHeight;

  let clipPath = `path("M 0,0 V ${
    elementHeight - edgeSize
  } L ${edgeSize},${elementHeight} H ${elementWidth} V ${edgeSize} L ${
    elementWidth - edgeSize
  },0 H 0 Z")`;
  element.style.clipPath = clipPath;
}

function applyClipBorder(elements, innerEdgeSize, outerEdgeSize, borderWidth) {
  if (typeof elements === "string")
    elements = document.querySelectorAll(elements);
  elements.forEach((element) => {
    clipBorder(element, innerEdgeSize, outerEdgeSize, borderWidth);
  });
}

function applyClipBg(elements, edgeSize) {
  if (typeof elements === "string")
    elements = document.querySelectorAll(elements);
  elements.forEach((element) => {
    clipBg(element, edgeSize);
  });
}

window.addEventListener("load", () => {
  applyClipBorder(inputBorders, 16, 17, 2.5);
  applyClipBorder(buttonBorders, 16, 17, 2.5);
  applyClipBorder(".form__checkbox-border", 7, 8, 2.5);
  applyClipBg(buttonBgFilled, 15);
  applyClipBg(".form__checkbox", 8);
});

window.addEventListener("resize", () => {
  applyClipBorder(inputBorders, 16, 17, 2.5);
  applyClipBorder(buttonBorders, 16, 17, 2.5);
  applyClipBg(buttonBgFilled, 15);
});

const appSlider = new Swiper(".app__slider", {
  loop: true,
  effect: "fade",
  allowTouchMove: false,
  autoplay: {
    delay: 6000,
    disableOnInteraction: false,
  },
});

appSlider.on("slideChangeTransitionStart", () => {
  const app = document.querySelector(".app");
  if (app.classList.contains("apex")) app.classList.replace("apex", "valorant");
  else if (app.classList.contains("valorant"))
    app.classList.replace("valorant", "cyberpunk");
  else if (app.classList.contains("cyberpunk"))
    app.classList.replace("cyberpunk", "apex");
});

function showRulesSection() {
  document.querySelector(".entry-fees-section").style.display = "none";
  document.querySelector(".rules-section").style.display = "block";
}

function closePopup() {
  var popupOverlay = document.getElementById("popupOverlay");
  popupOverlay.style.display = "none";
  setCookie("confirmation", "agreed", 1);
}


