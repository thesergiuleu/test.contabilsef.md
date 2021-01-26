const menu =
    `
					<ul>
						<li><a href="#ofer">Despre revistă</a></li>
						<li><a href="#why-we">Beneficii</a></li>
						<li><a href="#subscription">Abonamente</a></li>
						<li><a href="#contacts">Contacte</a></li>
					</ul>
				`;

document.querySelector('.menu-desktop').innerHTML = menu;
document.querySelector('.menu-mobile').innerHTML = menu;
const hamburger = document.getElementById("hamburger");
const mob_nav = document.getElementById("mob_nav");
const nav_mobile = document.getElementById("nav_mobile");
hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("is-active");
    mob_nav.classList.toggle("is-active");
    nav_mobile.classList.toggle("is-active");
});

const reviewBtn = document.querySelectorAll('.review-more');
const modalBody = document.getElementById('modalBody');
const modalTitle = document.getElementById('modalTitle');
for (let i = 0; i < reviewBtn.length; i++) {
    reviewBtn[i].addEventListener("click", () => {
        modalTitle.innerHTML = reviewBtn[i].nextElementSibling.textContent  + `<span style="margin-left: 12px; font-style: italic; font-size: 13px;">review</span>`;
        modalBody.innerText = reviewBtn[i].previousElementSibling.textContent;
    })
}

const collapseIcons = document.querySelectorAll(".icon-collapse");
for (let i = 0; i < collapseIcons.length; i++) {
    collapseIcons[i].addEventListener("click", () => {
        collapseIcons[i].classList.toggle("active");
    })
}

const collapseTitle = document.querySelectorAll(".guaranty-title");
for (let i = 0; i < collapseTitle.length; i++) {
    collapseTitle[i].addEventListener("click", () => {
        collapseIcons[i].classList.toggle("active");
    })
}
$(document).ready(() => {
    $("#datepicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });
    $('#reviews-carousel').slick({
        slidesToShow: 3,
        slidesToScroll: 3,
        centerMode: true,
        focusOnSelect: true,
        centerPadding: '10px',
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
})
