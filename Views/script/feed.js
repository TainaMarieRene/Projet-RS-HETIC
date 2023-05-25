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

const textarea = document.querySelector('.commentContent');

textarea.addEventListener('input', function() {
  textarea.style.height = 'auto'
  const newHeight= textarea.scrollHeight / 12
  textarea.style.height = newHeight + 'vw'
});

// function handleReactionClick(userId,reactionType,emoji) {
//     console.log("Reaction button clicked");
//     console.log("userId:", userId);
//     console.log("reactionType:", reactionType);
//     console.log("emoji:", emoji);
//     saveReaction(userId, reactionType, emoji);
// }

// function saveReaction(userId, reactionType, emoji) {
//         var xhttp = new XMLHttpRequest()
//         xhttp.onreadystatechange = function() {
//             if (this.readyState == 4 && this.status == 200) {
//                 console.log(this.responseText)
//             }
//         };
//         handleReactionClick(userId, reactionType, emoji)
//         xhttp.open("POST", "http://localhost/Projet-RS-HETIC/views/feed.php", true)
//         xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
//         xhttp.send("userId=" + userId + "&reactionType=" + reactionType + "&emoji=" + emoji)
//     }

  
    
