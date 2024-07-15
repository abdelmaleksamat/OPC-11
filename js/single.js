//Le script est exécuté lorsque le contenu de la page est complètement chargé. (Événement DOMContentLoaded)
window.addEventListener("DOMContentLoaded", () => {

    //Récupération de la Catégorie de l'Article
    const postCategory =  document.querySelector('.post_category').childNodes[1].innerText
    const postReference =  document.querySelector('.hidden-id').innerText
    console.log(postCategory, postReference);

    // lightbox
    const carouselOverlay = document.getElementById("carousel-overlay"); // Sélectionne l'overlay du carrousel.
    const imgThumbnail = document.getElementById("imgThumbnail"); // Sélectionne l'image affichée dans le carrousel.
    const lightbox__ref = document.querySelector(".lightbox__ref"); // Sélectionnent les éléments pour afficher ...
    const lightbox__cat = document.querySelector(".lightbox__cat"); // les informations associées à l'image (référence et catégorie).
    const prevButton = document.querySelector("#carousel-prev"); // Sélectionnent les boutons pour naviguer entre ... 
    const nextButton = document.querySelector("#carousel-next"); // les images du carrousel.
    const closeButton = document.getElementById("carousel-close"); // Sélectionne le bouton pour fermer le carrousel.

    let currentIndex = 0;
    let posts = [];


    //Préparation des Données pour AJAX
    const form_data = new FormData()
    form_data.append("action", "charger_les_photos_associe")
    form_data.append("categorie", postCategory)
    form_data.append("reference", postReference)


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

    //  Fonction pour Mettre à Jour le Carrousel
    function updateCarousel(index) {
        const post = posts[index];
        imgThumbnail.src = post.postImg;
        lightbox__ref.innerText = post.postCat;
        lightbox__cat.innerText = post.postRef;
    }


     // Extraction des Données des Cartes
     function extractCardData() {
        posts = [];
        const card_list = document.querySelectorAll(".card-suggestions");
        card_list.forEach((card) => {
            const cardData = {
                postImg: card.querySelector(".post_img").src,
                postRef: card.querySelector(".post_img").getAttribute("data-imgid"),
                postCat: card.querySelector("span").innerText,
            };
            posts.push(cardData);      
        });
        // rajoute mes donnes du main post
        // const cardData = {
        //     postImg: document.querySelector(".img-single").src,
        //     postRef: document.querySelector(".post_reference").innerText,
        //     postCat: postCategory,
        // };
        // ajouter a la liste de posts
        posts.push(cardData);  


        console.log(posts);
    }

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

    // Gestion des Boutons de Navigation et de Fermeture

    closeButton.addEventListener("click", hideCarousel);

    //Envoi de la Requête AJAX
    fetch(ajax_admin.ajax_url, {
        method: "POST",
        body: form_data,
    }).then(res=>{
        res.text().then(data=>{
            // console.log(data);
            const divPhotos = document.querySelector('.photo-suggestions')
            divPhotos.innerHTML += data
            extractCardData()

                //Gestion du lightbox
                // on attend la réponse du serveur avant ajouter eventListener ...
            const icon_fullscreen_list =  document.querySelectorAll('.icon-fullscreen')
            icon_fullscreen_list.forEach((icon,i)=>{
                icon.addEventListener('click', (e)=>{
                    extractCardData()
                    showCarousel(i)
                })

            })
            
            
        })
    })



    //Gestion des Flèches Gauche et Droite
    const left_arrow = document.getElementById('arrow-left')
    const right_arrow = document.getElementById('arrow-right')

    //Interaction avec la Flèche Gauche
    if(left_arrow){
        left_arrow.addEventListener('mouseenter', ()=>{
            document.querySelectorAll('.wp-post-image')[1].style.opacity = 1
        })
        
        left_arrow.addEventListener('mouseleave', ()=>{
            document.querySelectorAll('.wp-post-image')[1].style.opacity = 0
        })
    }
    
    //Interaction avec la Flèche Droite
    if(right_arrow){        
        right_arrow.addEventListener('mouseenter', ()=>{
            document.querySelectorAll('.wp-post-image')[2].style.opacity = 1
        })


        right_arrow.addEventListener('mouseleave', ()=>{
            document.querySelectorAll('.wp-post-image')[2].style.opacity = 0
        })
    }

})
