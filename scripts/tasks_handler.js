function addNew()
{
    toggleEditPage(0);

    let today = new Date();
    // add 0 before number if it's length is equal 1
    let currentMonth = ((today.getMonth()+1) < 10 ? "0" : "") + (today.getMonth()+1);
    let date = today.getFullYear()+'-'+(currentMonth)+'-'+today.getDate();

    let json = {
        "Status": "to do",
        "Customer": null,
        "Team": null,
        "Leader": null,
        "Title": null,
        "Deadline": date
    };
    showDataOfCurrentTask(json);
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

let idOfCurrnetTask = undefined;
function toggleEditPage(id)
{
    const editPage = document.querySelector("#edit-wrapper");
    if (editPage.style.display == "none")
    {
        idOfCurrnetTask = id; 
        editPage.style.display = "block";
        if (id > 0)
            getTask(parseInt(id), showDataOfCurrentTask);
    }
    else
    {
        editPage.style.display = "none";
        idOfCurrnetTask = undefined;
    }
}

function showDataOfCurrentTask(json)
{
    document.querySelector("#edit-title").value = json["Title"];
    document.querySelector("#edit-deadline").value = json["Deadline"];

    const fillSelect = function (json, args)
    {
        const select = document.querySelector("#edit-" + args[3] + "-select");
    
        // set default value
        if (args[3] != "status")
        {
            let optElem = document.createElement("option");
                optElem.value = "";
                optElem.innerHTML = "Not assign";
                optElem.selected = true;
                select.appendChild(optElem);
        }
    
        // add values from database and overwrite default value
        for (id in json)
        {
            let optElem = document.createElement("option");

            if (args[3] != "status")
                optElem.value = id;
            else
                optElem.value = json[id];
            
            optElem.innerHTML = json[id];
            optElem.selected = json[id] == args[4];
            select.appendChild(optElem);
        }    
    }

    getList("Fullname", "customers", fillSelect, "customer", json["Customer"]);
    getList("Fullname", "leaders", fillSelect, "leader", json["Leader"]);
    getList("Name", "teams", fillSelect, "team", json["Team"]);
    // nulls are placeholders becouse when we invoke it by getList it gain 3 aditional args
    // and fiilSelect is prepare for this case
    fillSelect({1: "to do", 2: "working on", 3: "completed"}, [null, null, null, "status", json["Status"]]);
}

function matchLeaderTeam(type, whereMatch, id)
{
    const DOMElem = document.querySelector("#edit-" + whereMatch + "-select");
    if (document.querySelector("#edit-" + type + "-select").value == 0)
    {
        DOMElem.value = 0;
        return;
    }
    
    const changeLeaderTeam = function(json)
    {
        DOMElem.value = json[whereMatch + "_ID"];
    }

    getLeader_Team(type, parseInt(id), changeLeaderTeam);
}

function saveData()
{
    const form = document.querySelector("#edit-form");
    const title = form["title"].value;
    const customer = form["customer"].value;
    const team = form["team"].value;
    const deadline = form["deadline"].value;
    const status = form["status"].value;
    const id = parseInt(idOfCurrnetTask);

    const http = new XMLHttpRequest();
    http.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            console.log(this.responseText);
        }
    }

    const josnToSend = {"id": id, "title": title, "customer": customer, "team": team, "deadline": deadline, "status": status};
    if (id == 0)
        http.open("POST", "../controller/send_data/send_data_controller.php/task/insert");
    else
        http.open("POST", "../controller/send_data/send_data_controller.php/task/update");
    http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    http.send(JSON.stringify(josnToSend));
}

function checkRequirementsAndSend()
{
    const form = document.querySelector("#edit-form");
    let valid = false;

    if (form["title"].value && form["customer"].value)
        valid = true;
    
    if (valid)
    {
        saveData(); 
        toggleEditPage();
    }
}