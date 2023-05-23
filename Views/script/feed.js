function displayCta(element, reactionCta) {
    element.addEventListener('mouseenter', function(event){
         event.preventDefault()
        reactionCta.classList.remove('hideCta')

    })
}
function hideCta(element, reactionCta) {
    element.addEventListener('mouseleave', function(event){
        setTimeout(() => {
            event.preventDefault()
            reactionCta.classList.add('hideCta')
        }, 1500)
    })
}
let id = 0;
while (true) {
    let likeButton = document.getElementById("likeButton" + id)
    let reactionCta = document.getElementById("reactionCta" + id)
    if (!likeButton || !reactionCta) {
        break
    }
    reactionCta.classList.add("reactionCta")
    displayCta(likeButton, reactionCta)
    hideCta(likeButton, reactionCta)
    id++
}


let i = 0
while (true) {
    let commentButton = document.getElementById("commentButton" + i)
    let commentForm = document.getElementById('comment' + i)
    if(!commentButton && !commentForm){
        break
    }
    commentButton.addEventListener('click',function(event){
        event.preventDefault()
        commentForm.classList.toggle("hideCta")
    })

    i++
}


