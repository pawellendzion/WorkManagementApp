function toggleMenu()
{
    const menu = document.getElementById("menu");
    if (menu.classList.contains("expanded"))
        menu.classList.remove("expanded")
    else
        menu.classList.add("expanded")
}

function highlightMenu(menu_part)
{
    document.querySelectorAll("#menu .active").forEach(function(value) {
        value.classList.remove("active");
    });

    switch(menu_part)
    {
        case "home": 
            home.classList.add("active");
            break;
        
        case "tasks": 
            tasks.classList.add("active");
            break;
        
        case "employees": 
            employees.classList.add("active");
            break;
        
        case "customers": 
            customers.classList.add("active");
            break;
    }
}