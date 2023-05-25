
const accountTypeRadio = () => {
    document.getElementsByName("accountType").forEach(type => {
        if (type.checked) {
            const currentView = document.getElementById(type.value)
            currentView.classList.remove("hide")
            console.log(type.value)
        } else {
            const invisibleView = document.getElementById(type.value)
            invisibleView.classList.add("hide")
        }
    })
}
document.getElementsByName("accountType").forEach(type => {
    type.addEventListener("change", accountTypeRadio)
})

accountTypeRadio();

