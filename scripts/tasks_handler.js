function addNew()
{
    const toDoPanel = document.getElementById("to-do");
    let div = document.createElement("div");
    div.className = "elem";
    toDoPanel.appendChild(div);
}