const toggle = document.querySelector("#toggleTheme")
const html = document.querySelector("html")

if (localStorage.getItem("theme") === "dark") {
    html.setAttribute("data-theme", "dark")
    toggle.textContent = "🌞"
    if (document.querySelector("#profile")) {
        document.querySelector("#profile").classList.add("invert-[.80]")
    }
}

toggle.addEventListener("click", () => {
    if (localStorage.getItem("theme") === "dark") {
        html.setAttribute("data-theme", "light")
        toggle.textContent = "🌚"
        localStorage.setItem("theme", "light")
        if (document.querySelector("#profile")) {
            document.querySelector("#profile").classList.remove("invert-[.80]")
        }
    } else {
        html.setAttribute("data-theme", "dark")
        if (document.querySelector("#profile")) {
            document.querySelector("#profile").classList.add("invert-[.80]")
        }
        toggle.textContent = "🌞"
        localStorage.setItem("theme", "dark")
    }
})
