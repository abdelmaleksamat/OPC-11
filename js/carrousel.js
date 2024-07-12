// Le script est exécuté lorsque le contenu de la page est complètement chargé.
document.addEventListener("DOMContentLoaded", function () {

    // Sélection des Éléments DOM
    const fullscreenIcons = document.querySelectorAll(".icon-fullscreen"); // Sélectionne toutes les icônes de plein écran.
    const card_list = document.querySelectorAll(".card"); // Sélectionne toutes les cartes contenant des images.
    const carouselOverlay = document.getElementById("carousel-overlay"); // Sélectionne l'overlay du carrousel.
    const imgThumbnail = document.getElementById("imgThumbnail"); // Sélectionne l'image affichée dans le carrousel.
    const lightbox__ref = document.querySelector(".lightbox__ref"); // Sélectionnent les éléments pour afficher ...
    const lightbox__cat = document.querySelector(".lightbox__cat"); // les informations associées à l'image (référence et catégorie).
    const prevButton = document.querySelector("#carousel-prev"); // Sélectionnent les boutons pour naviguer entre ... 
    const nextButton = document.querySelector("#carousel-next"); // les images du carrousel.
    const closeButton = document.getElementById("carousel-close"); // Sélectionne le bouton pour fermer le carrousel.

    // Initialisation des Variables
    let currentIndex = 0; // Index de l'image actuellement affichée dans le carrousel.
    let posts = []; // Tableau qui stocke les informations des images.

    //  Fonction pour Mettre à Jour le Carrousel
    function updateCarousel(index) {
        const post = posts[index];
        imgThumbnail.src = post.postImg;  // Met à jour l'image et les informations affichées dans le carrousel en fonction de l'index donné.
        lightbox__ref.innerText = post.postCat;
        lightbox__cat.innerText = post.postRef;
    }

// Fonction pour Afficher le Carrousel

    function showCarousel(index) {
        currentIndex = index;
        carouselOverlay.style.display = "flex";
        updateCarousel(index);
    }

// Fonction pour Cacher le Carrousel

    function hideCarousel() {
        carouselOverlay.style.display = "none";
    }

// Gestion des Événements de Plein Écran

    fullscreenIcons.forEach((icon, index) => {
        icon.addEventListener("click", function (e) {
            e.preventDefault();
            showCarousel(index);
        });
    });

    // Gestion des Boutons de Navigation et de Fermeture

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

    // Fermeture du Carrousel en Cliquant à l'Extérieur

    carouselOverlay.addEventListener("click", (e) => {
        if (e.target === carouselOverlay) {
            hideCarousel();
        }
    });
   0// Extraction des Données des Cartes
    card_list.forEach((card) => {
        const cardData = {
            postImg: card.querySelector(".post_img").src,
            postRef: card.querySelector(".post_img").getAttribute("data-imgid"), // Extrait les informations de chaque carte (image, référence, catégorie) et les stocke dans le tableau posts.
            postCat: card.querySelector("span").firstChild.innerText,
        };
        posts.push(cardData);
    });
});