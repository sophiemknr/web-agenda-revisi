let list = document.querySelectorAll(".navigation li");

function activeLink() {
    list.forEach((item) => {
        item.classList.remove("hovered");
    });
    this.classList.add("hovered");
}

document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll(".navigation ul li a");

    navLinks.forEach((link) => {
        if (link.getAttribute("href") === currentPath) {
            link.classList.add("active");
        }
    });
});

list.forEach((item) => item.addEventListener("mouseover", activeLink));

let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");
let logoutButton = document.querySelector(".logout-button");

toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
    logoutButton.classList.toggle("active");
};

document.getElementById("dropdown-icon").addEventListener("click", function () {
    var dropdownContent = document.getElementById("dropdown-content");
    if (dropdownContent.style.display === "flex") {
        dropdownContent.style.display = "none";
    } else {
        dropdownContent.style.display = "flex";
    }
});

window.addEventListener("click", function (event) {
    if (
        !event.target.matches("#dropdown-icon") &&
        !event.target.matches(".administrator-text")
    ) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.style.display === "flex") {
                openDropdown.style.display = "none";
            }
        }
    }
});

let lastScrollTop = 0;
const navbar = document.querySelector(".topbar");

window.addEventListener(
    "scroll",
    function () {
        let scrollTop =
            window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop > lastScrollTop && scrollTop > navbar.offsetHeight) {
            navbar.classList.add("hide");
        } else {
            navbar.classList.remove("hide");
        }
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    },
    false
);
