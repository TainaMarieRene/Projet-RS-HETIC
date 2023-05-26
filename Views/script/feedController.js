import { getElement, display, displayCta, hideCta } from './feedFunction.js';

const textarea = document.querySelector(".commentContent");

textarea.addEventListener("input", function () {
  textarea.style.height = "auto";
  const newHeight = textarea.scrollHeight / 12;
  textarea.style.height = newHeight + "vw";
});


let reactionEmojiArray = [];
let emoji = 0;
while (true) {
  const reactionEmoji = document.getElementById("reactionEmoji" + emoji);
  if (!reactionEmoji) {
    break;
  }
  reactionEmojiArray.push(reactionEmoji);
  emoji++;
}
reactionEmojiArray.forEach((emoji) => {
  console.log(emoji)
  if (emoji.classList[1] === "react1") {
    emoji.src = "../Views/assets/icons/smiley-bad.svg";
  } else if (emoji.classList[1] === "react2") {
    emoji.src = "../Views/assets/icons/smiley-crying-rainbow.svg";
  } else if (emoji.classList[1] === "react3") {
    emoji.src = "../Views/assets/icons/smiley-drop.svg";
  } else if (emoji.classList[1] === "react4") {
    emoji.src = "../Views/assets/icons/smiley-in-love.svg";
  } else {
    emoji.src = "../Views/assets/icons/smiley-lol-sideways.svg";
  }
});

let id = 0;
while (true) {
  let likeButton = document.getElementById("likeButton" + id);
  let reactionCta = document.getElementById("reactionCta" + id);
  if (!likeButton || !reactionCta) {
    break;
  }
  reactionCta.classList.add("reactionCta");
  displayCta(likeButton, reactionCta);
  hideCta(likeButton, reactionCta);
  id++;
}


let displayFormComment = getElement("displayForm", "comment")
display(displayFormComment[0], displayFormComment[1], "hideCta")

let displayComment = getElement("commentButton", "displayComment")
display(displayComment[0], displayComment[1], "hideCta")

let displayReaction = getElement("reactionButton", "displayReaction")
display(displayReaction[0], displayReaction[1], "hideCta")


// let displayFriendsReaction = getElement("reactionEmoji", "")
// displayFriendsReaction.splice(1)
// console.log(displayFriendsReaction)

// console.log(displayFriendsReaction[0])
// displayFriendsReaction[0].forEach((emoji) => {
//   if (emoji.react1) {
//     emoji.src = "../Views/assets/icons/smiley-bad.svg";
//   } else if (emoji.react2) {
//     emoji.src = "../Views/assets/icons/smiley-crying-rainbow.svg";
//   } else if (emoji.react3) {
//     emoji.src = "../Views/assets/icons/smiley-drop.svg";
//   } else if (emoji.react4) {
//     emoji.src = "../Views/assets/icons/smiley-in-love.svg";
//   } else {
//     emoji.src = "../Views/assets/icons/smiley-lol-sideways.svg";
//   }

// })

