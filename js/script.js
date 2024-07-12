//Gestion de la modale

window.addEventListener("DOMContentLoaded", () => {
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
    const load_more_btn = document.getElementById('load_more');

    if (load_more_btn) {
        load_more_btn.addEventListener('click', () => {
            const div_container = document.querySelector('.filter');
            const form_data = new FormData();
            form_data.append("action", "charger_plus");

            fetch(ajax_admin.ajax_url, {
                method: "POST",
                body: form_data,
            })
                .then((res) => {
                    if (res.ok) {
                        res.text().then(data => {
                            div_container.innerHTML += data;
                            load_more_btn.style.display = "none";
                        });
                    } else {
                        throw Error('pas de response  ...');
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    }
});

// Gère l'affichage des filtres

window.addEventListener("DOMContentLoaded", () => {
    const customSelectArray = document.querySelectorAll(".select");
    
    customSelectArray.forEach((selectBtn, i) => {
        selectBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            selectBtn.children[1].style.display = "block";
            selectBtn.style.borderColor = "#215AFF";
        });
    });

    window.addEventListener("click", () => {
        customSelectArray.forEach((element) => {
            element.children[1].style.display = "none";
            element.style.borderColor = "#b8bbc2";
        });
    });
});

//Filtrage et Chargement des Données

document.addEventListener("DOMContentLoaded", () => {
    const li_array = document.querySelectorAll(".select-li");
    const div_container = document.querySelector('.filter');
    const form_data = new FormData();

    function recouper_donne(filter_name, filter_type) {
        form_data.append(filter_type, filter_name);
        form_data.append("action", "filter");

        fetch(ajax_admin.ajax_url, {
            method: "POST",
            body: form_data,
        })
            .then((res) => {
                if (res.ok) {
                    res.text().then(data => {
                        div_container.innerHTML = "";
                        document.querySelector("#load_more").style.display = "none";
                        div_container.innerHTML += data;
                    });
                } else {
                    throw Error('pas de response  ...');
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }

    li_array.forEach((li) => {
        li.addEventListener("click", (e) => {
            e.stopPropagation()
            recouper_donne(e.target.getAttribute("data-value"), e.target.getAttribute("data-filter"));
            const parentNode = e.target.parentNode 
            parentNode.style.display = "none"

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

//Modale pour Référence de Post

document.addEventListener("DOMContentLoaded", function () {
    const openModalButton = document.getElementById('open-modal');
    const modal = document.getElementById('modal-form');
    const closeModalButton = modal.querySelector('.modal-close');

    function showModal() {
        modal.style.display = 'block';
        const post_ref = document.querySelector('.post_reference').innerText;
        const ref_input = document.querySelectorAll('.wpcf7-text')[2];
        ref_input.value = post_ref;
    }

    function hideModal() {
        modal.style.display = 'none';
    }

    if (openModalButton) openModalButton.addEventListener('click', showModal);
    closeModalButton.addEventListener('click', hideModal);

    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            hideModal();
        }
    });
});
