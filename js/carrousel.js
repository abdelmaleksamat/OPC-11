document.addEventListener("DOMContentLoaded", function () {
    const fullscreenIcons = document.querySelectorAll(".icon-fullscreen");
    const card_list = document.querySelectorAll(".card");
    const carouselOverlay = document.getElementById("carousel-overlay");
    const imgThumbnail = document.getElementById("imgThumbnail");

    const lightbox__ref = document.querySelector(".lightbox__ref");
    const lightbox__cat = document.querySelector(".lightbox__cat");

    const prevButton = document.querySelector("#carousel-prev");
    const nextButton = document.querySelector("#carousel-next");
    const closeButton = document.getElementById("carousel-close");

    let currentIndex = 0;
    let posts = [];

    function updateCarousel(index) {
        const post = posts[index];
        imgThumbnail.src = post.postImg;
        lightbox__ref.innerText = post.postCat;
        lightbox__cat.innerText = post.postRef;
    }

    function showCarousel(index) {
        currentIndex = index;
        carouselOverlay.style.display = "flex";
        updateCarousel(index);
    }

    function hideCarousel() {
        carouselOverlay.style.display = "none";
    }

    fullscreenIcons.forEach((icon, index) => {
        icon.addEventListener("click", function (e) {
            e.preventDefault();
            showCarousel(index);
        });
    });

    closeButton.addEventListener("click", hideCarousel);

    prevButton.addEventListener("click", function (e) {
        e.stopPropagation();
        currentIndex = currentIndex > 0 ? currentIndex - 1 : posts.length - 1;
        updateCarousel(currentIndex);
    });

    nextButton.addEventListener("click", function (e) {
        e.stopPropagation();
        currentIndex = currentIndex < posts.length - 1 ? currentIndex + 1 : 0;
        updateCarousel(currentIndex);
    });

    carouselOverlay.addEventListener("click", (e) => {
        if (e.target === carouselOverlay) {
            hideCarousel();
        }
    });

    card_list.forEach((card) => {
        const cardData = {
            postImg: card.querySelector(".post_img").src,
            postRef: card.querySelector(".post_img").getAttribute("data-imgid"),
            postCat: card.querySelector("span").firstChild.innerText,
        };
        posts.push(cardData);
    });
});
