function displayCta(element, reactionCta) {
  element.addEventListener("mouseenter", function (event) {
    event.preventDefault();
    reactionCta.classList.remove("hideCta");
  });
}
function hideCta(element, reactionCta) {
  element.addEventListener("mouseleave", function (event) {
    setTimeout(() => {
      event.preventDefault();
      reactionCta.classList.add("hideCta");
    }, 1500);
  });
}
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

let i = 0;
while (true) {
  let commentButton = document.getElementById("displayForm" + i);
  let commentForm = document.getElementById("comment" + i);
  if (!commentButton && !commentForm) {
    break;
  }
  commentButton.addEventListener("click", function (event) {
    event.preventDefault();
    commentForm.classList.toggle("hideCta");
  });

  i++;
}

const textarea = document.querySelector(".commentContent");

textarea.addEventListener("input", function () {
  textarea.style.height = "auto";
  const newHeight = textarea.scrollHeight / 12;
  textarea.style.height = newHeight + "vw";
});

let b = 0;
while (true) {
  let reactionButton = document.getElementById("reactionButton" + b);
  let displayReaction = document.getElementById("displayReaction" + b);

  if (!reactionButton && !displayReaction) {
    break;
  }
  reactionButton.addEventListener("click", function (event) {
    event.preventDefault();
    displayReaction.classList.toggle("hideCta");
  });
  b++;
}

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

let comment = 0;
while (true) {
  let reactionButton = document.getElementById("commentButton" + comment);
  let displayComment = document.getElementById("displayComment" + comment);

  if (!reactionButton && !displayComment) {
    break;
  }
  reactionButton.addEventListener("click", function (event) {
    event.preventDefault();
    displayComment.classList.toggle("hideCta");
  });
  comment++;
}
