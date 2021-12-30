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
    const home = document.getElementById("home");
    const tasks = document.getElementById("tasks");
    const employees = document.getElementById("employees");
    const customers = document.getElementById("customers");

    home.classList.remove("active");
    tasks.classList.remove("active");
    employees.classList.remove("active");
    customers.classList.remove("active");

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