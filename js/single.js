//Le script est exécuté lorsque le contenu de la page est complètement chargé. (Événement DOMContentLoaded)
window.addEventListener("DOMContentLoaded", () => {

    //Récupération de la Catégorie de l'Article
    const postCategory =  document.querySelector('.post_category').childNodes[1].innerText
    console.log(postCategory, ajax_admin.ajax_url);

    //Préparation des Données pour AJAX
    const form_data = new FormData()
    form_data.append("action", "charger_les_photos_associe")
    form_data.append("categorie", postCategory)

    //Envoi de la Requête AJAX
    fetch(ajax_admin.ajax_url, {
        method: "POST",
        body: form_data,
    }).then(res=>{
        res.text().then(data=>{
            // console.log(data);
            const divPhotos = document.querySelector('.photo-suggestions')
            divPhotos.innerHTML += data
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
