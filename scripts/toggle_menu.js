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

        case "teams": 
            teams.classList.add("active");
            break;
    }
}