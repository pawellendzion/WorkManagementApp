//maxRecords has to be defined in template where this script is used

/**
 * @typeOfRecords customers / employees / teams
 */
function getRecords(typeOfRecords, pageNum) 
{
    const http = new XMLHttpRequest();
    http.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            document.querySelector("tbody").innerHTML = this.responseText;
        }
    }
    
    if(!Number.isInteger(pageNum))
    {
        console.warn(`funcion getRecords takes integer but got pageNum=${pageNum}`);
        pageNum = 1;
    }

    let to = pageNum * maxRecords;
    let from = to - maxRecords;

    http.open("GET", `../controller/get_data/get_data_controller.php/${typeOfRecords}?from=${from}&to=${to}`);
    http.send();
}

let recordsCount = null;
/**
 * Once you call this function records count
 * will be stored in variable "recordsCount"
 * @typeOfRecords customers / employees / teams
 */
function getRecordsCount(typeOfRecords) 
{
    const http = new XMLHttpRequest();
    http.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            recordsCount = parseInt(this.responseText);
            document.querySelector("span#recordsCount").innerHTML = `(${this.responseText})`;
            document.querySelector("span#recordsPages").innerHTML = 
                Math.ceil(parseFloat(this.responseText)/parseFloat(maxRecords));
        }
    }
    
    http.open("GET", `../controller/get_data/get_data_controller.php/${typeOfRecords}/count`);
    http.send();

}

/**
 * @ofWhat example: Name, Lastname, Fullname ,Phone, Email, etc.
 * @typeOfRecords customers / employees / teams / leaders
 */
function getList(ofWhat, typeOfRecords, callback)
{
    let args = arguments;
    const http = new XMLHttpRequest();
    http.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            callback(JSON.parse(this.responseText), args);
        }
    }

    http.open("GET", 
        `../controller/get_data//get_data_controller.php/list?ofWhat=${ofWhat}&type=${typeOfRecords}`);
    http.send();
}

function getTasks()
{
    const http = new XMLHttpRequest();
    http.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            let a = JSON.parse(this.responseText);

            for(let status in a)
            {
                for(let id in a[status])
                {
                    // containet for all below
                    let div = document.createElement("div");
                    div.className = "elem";
                    div.id = "task-" + id;
                    
                    // leading block
                    let div2 = document.createElement("div");
                    div2.innerHTML = a[status][id]["Title"] + "<br>" + a[status][id]["Deadline"];
                    div2.addEventListener('click', function() {
                        expand(document.querySelector("#" + div.id));}, false);
                    div.appendChild(div2);
                    
                    //#region hidden block
                    
                    // infos

                    let divOfDivs = document.createElement("div");

                    let div3 = document.createElement("div");
                    div3.innerHTML = 
                    "<table>" +

                    "<tr><td>Customer:</td><td>" + a[status][id]["Customer"] + "</td></tr>" +
                    "<tr><td>Leader:</td><td>" + (a[status][id]["Leader"] ?? "Not assign") + "</td></tr>" +
                    "<tr><td>Team:</td><td>" + (a[status][id]["Team_name"] ?? "Not assign") + "</td></tr>" + 

                    "</table>";
                    
                    // buttons
                    let div4 = document.createElement("div");
                    let but1 = document.createElement("button");
                    let but2 = document.createElement("button");
                    
                    but1.textContent = "EDIT";
                    but1.className = "edit";
                    but1.setAttribute("tabindex", -1);
                    but1.addEventListener("click", function(){
                        toggleEditPage(id);
                    });

                    but2.textContent = "DELETE";
                    but2.className = "delete";
                    but2.setAttribute("tabindex", -1);
                    but2.addEventListener("click", function(){
                        deleteTask(id);
                        div.style.display = "none";
                    });

                    div4.appendChild(but1);
                    div4.appendChild(but2);

                    divOfDivs.appendChild(div4);
                    divOfDivs.appendChild(div3);
                    div.appendChild(divOfDivs);

                    //#endregion

                    document.querySelector("#" + status).appendChild(div);
                }
            }
        }
    }

    http.open("GET", `../controller/get_data/get_data_controller.php/tasks`);
    http.send();
}

function getTask(id, callback)
{
    const http = new XMLHttpRequest();
    http.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            callback(JSON.parse(this.responseText));
        }
    }

    http.open("GET", `../controller/get_data/get_data_controller.php/task?id=${id}`);
    http.send();
}

/**
 * @param {*} type - leader / team
 * @param {*} id - id of leader / team
 */
function getLeader_Team(type, id, callback)
{
    const http = new XMLHttpRequest();
    http.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            callback(JSON.parse(this.responseText));
        }
    }

    http.open("GET", `../controller/get_data/get_data_controller.php/leader-team?id=${id}&type=${type}`);
    http.send();
}

function getPersonInfo(type, id, callback)
{
    const http = new XMLHttpRequest();
    
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
        {
            callback(JSON.parse(this.responseText));
        }
    }

    http.open("GET", `../controller/get_data/get_data_controller.php/person?id=${id}&type=${type}`);
    http.send();
}

function getTeamInfo(id, callback)
{
    const http = new XMLHttpRequest();
    
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
        {
            callback(JSON.parse(this.responseText));
        }
    }

    http.open("GET", `../controller/get_data/get_data_controller.php/team?id=${id}`);
    http.send();
}