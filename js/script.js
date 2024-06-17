window.addEventListener("DOMContentLoaded", () => {
    const modal_btn_close = document.querySelector(".modal-close")
    const modal_form = document.getElementById("modal-form")
    const contact_btn_menu = document.querySelector(".contact_btn_menu")


    const load_more_btn = document.getElementById('load_more')

    ///    verifier si le bouton "load more" est sur la page ...
    if(load_more_btn){
            load_more_btn.addEventListener('click', ()=>{

                const div_container = document.querySelector('.filter')
                const form_data = new FormData()

                // accion a executer dans le function.php (charger pluse)
                form_data.append("action", "charger_plus")

                fetch(ajax_admin.ajax_url, {
                    method: "POST",
                    body: form_data,
                })
                    .then((res) => {
                        // check tout ok
                        if(res.ok){
                            res.text().then(data=>{
                                // rajouter les donnes ...
                                div_container.innerHTML += data
                                load_more_btn.style.display = "none"
                            })
                        }else{
                            throw Error('pas de response  ...')
                        }
                    })
                    
                    .catch((error) => {
                        console.error("Error:", error)
                    })
                

            })
        }

    // button select
    const customSelectArray = document.querySelectorAll(".select")
    customSelectArray.forEach((selectBtn, i) => {
        selectBtn.addEventListener("click", (e) => {
            e.stopPropagation()
            selectBtn.children[1].style.display = "block"
            selectBtn.style.borderColor = "#215AFF"
        })
    })

    // close the select
    window.addEventListener("click", () => {
        const customSelectArray = document.querySelectorAll(".select")
        customSelectArray.forEach((element) => {
            element.children[1].style.display = "none"
            element.style.borderColor = "#b8bbc2"
        })
    })

    modal_btn_close.addEventListener("click", () => {
        console.log("click sur btn close !!!")
        modal_form.style.display = "none"
    })

    contact_btn_menu.addEventListener("click", () => {
        modal_form.style.display = "block"
    })

    window.addEventListener("click", (e) => {
        if (e.target.classList.contains("modal-ext")) {
            modal_form.style.display = "none"
        }
    })
})

function openNav() {
    document.getElementById("myNav").style.width = "100%"
}

function closeNav() {
    document.getElementById("myNav").style.width = "0%"
}

document.addEventListener("DOMContentLoaded", () => {

    // sélectionner tous les éléments "li"
    const li_array = document.querySelectorAll(".select-li")
    const select_array = document.querySelectorAll(".select-options")
    const div_container = document.querySelector('.filter')

    const filter_data = {
        categorie: "",
        format: "",
        date: ""

    }

    //preparer le donnes pour les envoie vers le backoffice
    const form_data = new FormData()


    // Fonction pour récupérer les donnes 
    function recouper_donne(filter_name, filter_type){

        if(filter_type === "categorie"){
            form_data.append("categorie", filter_name)
        }
        if(filter_type === "format"){
            form_data.append("format", filter_name)
        }

        if(filter_type === "date"){
            form_data.append("date", filter_name)
        }

        // accion a executer dans le function.php
        form_data.append("action", "filter")

        fetch(ajax_admin.ajax_url, {
            method: "POST",
            body: form_data,
        })
            .then((res) => {
                // console.log(res);
                // check tout ok
                if(res.ok){
                    res.text().then(data=>{
                        // console.log(data);
                        div_container.innerHTML = ""
                       document.querySelector("#load_more").style.display="none"
                        div_container.innerHTML += data
                    })
                }else{
                    throw Error('pas de response  ...')
                }
            })
            // .then((data) => {
            //     console.log(data)
            // })
            .catch((error) => {
                console.error("Error:", error)
            })

    } 

    li_array.forEach((li) => {
        li.addEventListener("click", (e) => {
            // console.log(e.target.getAttribute("data-filter"))
            recouper_donne(e.target.getAttribute("data-value"), e.target.getAttribute("data-filter"))
        })
    })

    // Fonction pour récupérer les images filtrées par Ajax
    function fetchImages(filterValue) {
        fetch(
            "http://nathalie-mota.local/wp-admin/admin-ajax.php?action=filter_images&filter=" +
                filterValue
        )
            .then((response) => response.json())
            .then((data) => {
                // Effacer la galerie existante
                gallery.innerHTML = ""

                // Ajouter les nouvelles images filtrées à la galerie
                data.forEach((image) => {
                    gallery.innerHTML += `
                            <article class="card">
                                <img class="post_img" src="${image.url}" alt="${image.alt}" data-imgId="${image.id}">
                                <h3 class="title">${image.title}</h3>
                                <span>${image.category}</span>
                            </article>
                        `
                })
            })
            .catch((error) =>
                console.error("Erreur lors de la récupération des images:", error)
            )
    }
})

document.addEventListener("DOMContentLoaded", function () {
    const openModalButton = document.getElementById('open-modal');
    const modal = document.getElementById('modal-form');
    const closeModalButton = modal.querySelector('.modal-close');

    // Function to show the modal
    function showModal() {
        modal.style.display = 'block';
        const post_ref = document.querySelector('.post_reference').innerText
        console.log(post_ref);
        const ref_input = document.querySelectorAll('.wpcf7-text')[2]
        ref_input.value = post_ref
    }

    // Function to hide the modal
    function hideModal() {
        modal.style.display = 'none';
    }

    // Event listener for the open modal button
    if(openModalButton) openModalButton.addEventListener('click', showModal);

    // Event listener for the close modal button
    closeModalButton.addEventListener('click', hideModal);

    // Event listener to close the modal when clicking outside of the modal content
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            hideModal();
        }
    });
});
