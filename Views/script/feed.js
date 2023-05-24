function displayCta(element, reactionCta) {
    element.addEventListener('mouseenter', function (event) {
        event.preventDefault()
        reactionCta.classList.remove('hideCta')

    })
}
function hideCta(element, reactionCta) {
    element.addEventListener('mouseleave', function (event) {
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
    let commentButton = document.getElementById("displayForm" + i)
    let commentForm = document.getElementById('comment' + i)
    if (!commentButton && !commentForm) {
        break
    }
    commentButton.addEventListener('click', function (event) {
        event.preventDefault()
        commentForm.classList.toggle("hideCta")
    })

    i++
}

// const input = document.querySelector('.commentContent');

// input.addEventListener('input', function () {
//     const textLength = input.value.length
//     const newWidth = textLength / 2
//     const newHeight = textLength / 4

//     if(input.style.width < 20 + "vw"){
//         input.style.width = newWidth + 'vw'
//         console.log(input.style.width)


//     }else if(input.style.height < 24 + "vw"){
//         console.log("coucou")
//         input.style.height = newHeight + 'vw'
//         console.log("ceci est height: ", input.style.height)
//     }


// })
const textarea = document.querySelector('.commentContent');

textarea.addEventListener('input', function() {
  textarea.style.height = 'auto'
  const newHeight= textarea.scrollHeight / 12
  textarea.style.height = newHeight + 'vw'
});