export function getElement(element1, element2) {
    let i = 0
    let value1Array = []
    let value2Array = []

    while (true) {
        let value1 = document.getElementById(element1 + i)
        let value2 = document.getElementById(element2 + i)
        if (!value1 && !value2) {
            break;
        }
        value1Array.push(value1)
        value2Array.push(value2)
        i++
    }
    return [value1Array, value2Array]

}
export function display(button, toDisplay, className) {
    for (let i = 0; i < button.length; i++) {
        button[i].addEventListener('click', function (event) {
            event.preventDefault()
            toDisplay[i].classList.toggle(className);
        });
    }
}


export function displayCta(element, reactionCta) {
    element.addEventListener("mouseenter", function (event) {
        event.preventDefault();
        reactionCta.classList.remove("hideCta");
    });
}
export function hideCta(element, reactionCta) {
    element.addEventListener("mouseleave", function (event) {
        setTimeout(() => {
            event.preventDefault();
            reactionCta.classList.add("hideCta");
        }, 1500);
    });
}