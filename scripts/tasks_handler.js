function addNew()
{
    const toDoPanel = document.getElementById("to-do");
    let div = document.createElement("div");
    div.className = "elem";
    toDoPanel.appendChild(div);
}

function expand(obj)
{
    if (obj.classList.contains("expanded"))
        obj.classList.remove("expanded");
    else
    {
        document.querySelectorAll(".elem.expanded").forEach(function(value) {
            value.classList.remove("expanded");
        });
        obj.classList.add("expanded");
    }
}