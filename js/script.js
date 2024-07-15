//Gestion de la modale

// Fonction pour Afficher le Carrousel


window.addEventListener("DOMContentLoaded", () => {    
 

    let icon_fullscreen_list =  document.querySelectorAll('.icon-fullscreen')
    const modal_btn_close = document.querySelector(".modal-close");
    const contact_btn_menu_mobile = document.querySelector(".contact_btn_menu_mobile")
    const modal_form = document.getElementById("modal-form");
    const contact_btn_menu = document.querySelector(".contact_btn_menu");

    // fermer la modale
    modal_btn_close.addEventListener("click", () => {
        modal_form.style.display = "none"
    });
    
    
    contact_btn_menu.addEventListener("click", () => {
        modal_form.style.display = "block";
        modal_form.classList.add('fadeInClass')
    });



    // menu mobile et animation mobile
    contact_btn_menu_mobile.addEventListener('click', ()=>{
        modal_form.style.display = "block"
        modal_form.classList.add('slideInClass')
    })

    window.addEventListener("click", (e) => {
        if (e.target.classList.contains("modal-ext")) {
            modal_form.classList.remove('fadeInClass')
            modal_form.style.display = "none";
        }
    });
});

// Chargement Dynamique de Contenu (Bouton "Load More")

window.addEventListener("DOMContentLoaded", () => {
    const carouselOverlay = document.getElementById("carousel-overlay")
    let posts = [];

    function showCarousel(index) {
        currentIndex = index;
        carouselOverlay.style.display = "flex";
        updateCarousel(index);
    }

    //  Fonction pour Mettre à Jour le Carrousel
    function updateCarousel(index) {
        const post = posts[index];
        imgThumbnail.src = post.postImg;  // Met à jour l'image et les informations affichées dans le carrousel en fonction de l'index donné.
        lightbox__ref.innerText = post.postCat;
        lightbox__cat.innerText = post.postRef;
    }

    // Sélectionne le bouton "Load More"
    const load_more_btn = document.getElementById('load_more');

    if (load_more_btn) {
        // Ajoute un écouteur d'événement "click" au bouton "Load More"
        load_more_btn.addEventListener('click', () => {
            // Sélectionne le conteneur où les résultats seront affichés
            const div_container = document.querySelector('.filter');
            // Crée une nouvelle instance de FormData pour envoyer les données de la requête
            const form_data = new FormData();
            form_data.append("action", "charger_plus");

            // Effectue une requête POST vers le serveur pour charger plus de contenu
            fetch(ajax_admin.ajax_url, {
                method: "POST",
                body: form_data,
            })
            .then((res) => {
                // Vérifie si la réponse est correcte
                if (res.ok) {
                    res.text().then(data => {
                        // Ajoute le nouveau contenu au conteneur
                        div_container.innerHTML += data;
                        // relancer les ecuteru de click
                        // on attend la réponse du serveur avant ajouter eventListener ...
                        icon_fullscreen_list =  document.querySelectorAll('.icon-fullscreen')
                        const carouselOverlay = document.getElementById("carousel-overlay")
                        const imgThumbnail = document.getElementById("imgThumbnail"); 
                        const lightbox__ref = document.querySelector(".lightbox__ref"); 
                        const lightbox__cat = document.querySelector(".lightbox__cat");
                        const prevButton = document.querySelector("#carousel-prev"); 
                        const nextButton = document.querySelector("#carousel-next"); 
                        const closeButton = document.getElementById("carousel-close"); 
                        const card_list = document.querySelectorAll(".card");
                        
                        // Extraction des Données des Cartes
                            card_list.forEach((card) => {
                                const cardData = {
                                    postImg: card.querySelector(".post_img").src,
                                    postRef: card.querySelector(".post_img").getAttribute("data-imgid"), // Extrait les informations de chaque carte (image, référence, catégorie) et les stocke dans le tableau posts.
                                    postCat: card.querySelector("span").firstChild.innerText,
                                };
                                posts.push(cardData);
                            });
                        console.log(icon_fullscreen_list);
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

                        // Extraction des Données des Cartes
                        
                        
                        icon_fullscreen_list.forEach((icon,i)=>{
                            icon.addEventListener('click', (e)=>{
                                extractCardData()
                                showCarousel(i)
                            })

                        })
                        
                        
                        // Cache le bouton "Load More"
                        load_more_btn.style.display = "none";
                    });
                } else {
                    throw Error('Pas de réponse ...');
                }
            })
            .catch((error) => {
                // Affiche une erreur en cas de problème avec la requête
                console.error("Error:", error);
            });
        });
    }
});

// Extraction des Données des Cartes
function extractCardData() {
    posts = [];
    const card_list = document.querySelectorAll(".card");
    card_list.forEach((card) => {
        const cardData = {
            postImg: card.querySelector(".post_img").src,
            postRef: card.querySelector(".post_img").getAttribute("data-imgid"),
            postCat: card.querySelector("span").innerText,
        };
        posts.push(cardData);      
    });
    // rajoute mes donnes du main post
    const cardData = {
        postImg: document.querySelector(".post_img").src,
        // postRef: document.querySelector(".post_reference").innerText,
        // postCat: postCategory,
    };
    // ajouter a la liste de posts
    posts.push(cardData);  


    console.log(posts);
}


// Gère l'affichage des filtres

window.addEventListener("DOMContentLoaded", () => {
    // Sélectionne tous les éléments avec la classe "select"
    const customSelectArray = document.querySelectorAll(".select");
    
    // Ajoute un écouteur d'événement "click" à chaque élément de la liste
    customSelectArray.forEach((selectBtn) => {
        selectBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            // Affiche les options de sélection et change la couleur de la bordure
            selectBtn.children[1].style.display = "block";
            selectBtn.style.borderColor = "#215AFF";
        });
    });

    // Ajoute un écouteur d'événement "click" à la fenêtre
    window.addEventListener("click", () => {
        // Masque les options de sélection et réinitialise la couleur de la bordure
        customSelectArray.forEach((element) => {
            element.children[1].style.display = "none";
            element.style.borderColor = "#b8bbc2";
        });
    });
});


// Filtrage et Chargement des Données

document.addEventListener("DOMContentLoaded", () => {
    // Sélectionne tous les éléments de la liste avec la classe "select-li"
    const li_array = document.querySelectorAll(".select-li");
    // Sélectionne le conteneur où les résultats filtrés seront affichés
    const div_container = document.querySelector('.filter');
    // Crée une nouvelle instance de FormData pour stocker les données du formulaire
    const form_data = new FormData();

    // Fonction pour récupérer et afficher les données filtrées
    function recouper_donne(filter_name, filter_type) {
        // Ajoute les filtres au form_data
        form_data.append(filter_type, filter_name);
        form_data.append("action", "filter");

        // Effectue une requête POST vers le serveur pour obtenir les données filtrées
        fetch(ajax_admin.ajax_url, {
            method: "POST",
            body: form_data,
        })
        .then((res) => {
            // Vérifie si la réponse est correcte
            if (res.ok) {
                res.text().then(data => {
                    // Vide le conteneur et cache le bouton "load more"
                    div_container.innerHTML = "";
                    document.querySelector("#load_more").style.display = "none";
                    // Ajoute les nouvelles données dans le conteneur
                    div_container.innerHTML += data;
                });
            } else {
                throw Error('Pas de réponse ...');
            }
        })
        .catch((error) => {
            // Affiche une erreur en cas de problème avec la requête
            console.error("Error:", error);
        });
    }

    // Ajoute un écouteur d'événement "click" à chaque élément de la liste
    li_array.forEach((li) => {
        li.addEventListener("click", (e) => {
            e.stopPropagation();
            // Appelle la fonction pour récupérer et afficher les données filtrées
            recouper_donne(e.target.getAttribute("data-value"), e.target.getAttribute("data-filter"));
            // Cache la liste des options après la sélection
            const parentNode = e.target.parentNode;
            parentNode.style.display = "none";
        });
    });
});


// Ouverture et Fermeture du menu burger
function openNav() {
    document.getElementById("myNav").style.width = "100%";
}

function closeNav() {
    document.getElementById("myNav").style.width = "0";
}

// Modale pour Référence de Post

document.addEventListener("DOMContentLoaded", function () {
    // Sélectionne le bouton pour ouvrir la modale
    const openModalButton = document.getElementById('open-modal');
    // Sélectionne la modale
    const modal = document.getElementById('modal-form');
    // Sélectionne le bouton pour fermer la modale
    const closeModalButton = modal.querySelector('.modal-close');

    // Fonction pour afficher la modale
    function showModal() {
        modal.style.display = 'block';
        // Récupère la référence du post
        const post_ref = document.querySelector('.post_reference').innerText;
        // Sélectionne le champ d'entrée pour la référence dans le formulaire
        const ref_input = document.querySelectorAll('.wpcf7-text')[2];
        // Remplit le champ d'entrée avec la référence du post
        ref_input.value = post_ref;
    }

    // Fonction pour cacher la modale
    function hideModal() {
        modal.style.display = 'none';
    }

    // Ajoute un écouteur d'événement pour ouvrir la modale au clic
    if (openModalButton) openModalButton.addEventListener('click', showModal);
    // Ajoute un écouteur d'événement pour fermer la modale au clic
    closeModalButton.addEventListener('click', hideModal);

    // Ajoute un écouteur d'événement pour fermer la modale au clic en dehors de celle-ci
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            hideModal();
        }
    });
});

    document.addEventListener("DOMContentLoaded", function() {
        var currentUrl = window.location.href;
        var sectionToHide = document.querySelector('.suggested-photo-container');

        if (currentUrl === 'http://nathalie-mota.local/photo/jour-de-match/' && sectionToHide) {
            sectionToHide.style.display = 'none';
        }
    });

