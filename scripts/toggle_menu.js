function toggleMenu()
{
    const menu = document.getElementById("menu");
    if (menu.classList.contains("expanded"))
        menu.classList.remove("expanded")
    else
        menu.classList.add("expanded")
}