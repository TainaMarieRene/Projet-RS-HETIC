function displayCta(element, reactionCta){
    element.addEventListener('mouseenter',()=>{
    reactionCta.classList.remove('hideCta')

})
}
function hideCta(element, reactionCta){
    element.addEventListener('mouseleave',()=>{
    setTimeout(()=>{reactionCta.classList.add('hideCta')
    },1500)
})
}
let id = 0;
while (true) {
let likeButton = document.getElementById("likeButton" + id);
let reactionCta = document.getElementById("reactionCta" + id);
if (!likeButton || !reactionCta) {
  break;
}
reactionCta.classList.add("reactionCta")
displayCta(likeButton, reactionCta);
hideCta(likeButton, reactionCta);
id++;
}


