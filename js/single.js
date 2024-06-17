window.addEventListener("DOMContentLoaded", () => {

    const postCategory =  document.querySelector('.post_category').childNodes[1].innerText
    console.log(postCategory, ajax_admin.ajax_url);

    const form_data = new FormData()

    // accion a executer dans le function.php (charger pluse)
    form_data.append("action", "charger_les_photos_associe")
    form_data.append("categorie", postCategory)


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

    const left_arrow = document.getElementById('arrow-left')
    const right_arrow = document.getElementById('arrow-right')

    //  affiche son image
    if(left_arrow){
        left_arrow.addEventListener('mouseenter', ()=>{
            document.querySelectorAll('.wp-post-image')[1].style.opacity = 1
        })
        //  cache son image
        left_arrow.addEventListener('mouseleave', ()=>{
            document.querySelectorAll('.wp-post-image')[1].style.opacity = 0
        })
    }
    
    // function guard
    if(right_arrow){        
        right_arrow.addEventListener('mouseenter', ()=>{
            document.querySelectorAll('.wp-post-image')[2].style.opacity = 1
        })


        right_arrow.addEventListener('mouseleave', ()=>{
            document.querySelectorAll('.wp-post-image')[2].style.opacity = 0
        })
    }

})
