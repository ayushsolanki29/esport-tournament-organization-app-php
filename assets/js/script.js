"use strict";

document.querySelector("body").insertAdjacentHTML(
  "beforeend",
  `
    <div class="loader_box">
    <div class="ui-abstergo">
    <div class="abstergo-loader">
      <div></div>
      <div></div>
      <div></div>
    </div>
    <div class="ui-text">
      Just a moment...
      <div class="ui-dot"></div>
      <div class="ui-dot"></div>
      <div class="ui-dot"></div>
    </div>
  </div>
    </div>
    `
);

// Remove the loader when the window is fully loaded
window.addEventListener("load", function () {
  const loader = document.querySelector(".loader_box");
  if (loader) {
    loader.remove();
  }
});

const elemToggleFunc = function (elem) {
  elem.classList.toggle("active");
};

/**
 * navbar variables
 */

const navbar = document.querySelector("[data-nav]");
const navOpenBtn = document.querySelector("[data-nav-open-btn]");
const navCloseBtn = document.querySelector("[data-nav-close-btn]");
const overlay = document.querySelector("[data-overlay]");

const navElemArr = [navOpenBtn, navCloseBtn, overlay];

for (let i = 0; i < navElemArr.length; i++) {
  navElemArr[i].addEventListener("click", function () {
    elemToggleFunc(navbar);
    elemToggleFunc(overlay);
    elemToggleFunc(document.body);
  });
}

/**
 * go top
 */

const goTopBtn = document.querySelector("[data-go-top]");

window.addEventListener("scroll", function () {
  if (window.scrollY >= 800) {
    goTopBtn.classList.add("active");
  } else {
    goTopBtn.classList.remove("active");
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const accordionTitles = document.querySelectorAll('.accordion-title');

  accordionTitles.forEach(title => {
      title.addEventListener('click', function () {
          // Toggle the active class for the clicked accordion item
          this.parentNode.classList.toggle('active');

          // Find the accordion content relative to the clicked accordion title
          const content = this.parentNode.querySelector('.accordion-content');
          // Toggle the display of the accordion content
          if (content && (content.style.display === 'block' || content.style.display === '')) {
              content.style.display = 'none';
          } else if (content) {
              content.style.display = 'block';
          }
      });
  });
});



function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  let expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}



function leterjoin() {
  const jounwacard = document.getElementById("jounwacard");
  if (jounwacard.style.display === "none") {
    jounwacard.style.display = "block";
  } else {
    jounwacard.style.display = "none";
  }
}