//
// !!! marge it all with person_page_handler !!!
//

class TeamsHandler
{
    static domElement = document.getElementById("wrapper-person-page");
    static recodDomElem = undefined;
    static currentID = undefined;
    static showed = false;

    static toggle(id, recodDomElem)
    {
        if (this.domElement.style.display == "none")
        {
            this.showed = false;
            document.querySelector("input#save").setAttribute("onclick", "TeamPageButtonsHandler.saveAction()")
            document.querySelector("input#delete").setAttribute("onclick", "TeamPageButtonsHandler.deleteAction()")

            this.domElement.style.display = "block";
            this.currentID = id;
            this.recodDomElem = recodDomElem;
            getTeamInfo(id, this.showInfo);

            if (id == 0) 
                (async() => {
                    while(this.showed == false)
                        await new Promise(resolve => setTimeout(resolve, 100));
                    PersonPageButtonsHandler.setupForNew();
                })();
        }
        else 
        {
            this.domElement.style.display = "none";
            this.currentID = undefined;
            this.recodDomElem = undefined;

            //Clear fields
            document.querySelector("#person-name").setAttribute("value", "");
            document.querySelector("#person-infos table#infos").innerHTML = "";
        }
    }

    static showInfo = (json) =>
    {
        const nameElem = document.querySelector("#person-name");
        nameElem.setAttribute("value", json["Name"] ?? "");
        nameElem.value = nameElem.getAttribute("value");
        
        const createTableRow = (label, value, colspan = false) => {
            const tr = document.createElement("tr");

            let td = document.createElement("td");
            td.innerHTML = label + ":";
            if (colspan) 
            {
                td.colSpan = 2;
                td.style.textAlign = "center";
                td.classList.add("info-title");
            }
            tr.appendChild(td);

            if (!colspan)
            {
                td = document.createElement("td");

                let input = document.createElement("select");
                
                const fillSelect = (json2) => {
                    let opt = document.createElement("option");
                    if (this.currentID != 0)
                    {
                        const getEmployee = (json3) =>
                        {
                            opt.value = json3["ID"];
                            input.setAttribute("value", json3["ID"]);
                            opt.innerHTML = json3["Name"] + " " + json3["Lastname"];
                        }
                        
                        let tempId = (TeamsHandler.recodDomElem.id.match(/-([0-9]{1})$/i))[1];
                        getPersonInfo("employee", tempId, getEmployee, false);
                    }
                    else
                    {
                        opt.value = "";
                        input.setAttribute("value", "");
                        opt.innerHTML = "Not assign";
                    }
                    
                    opt.selected = true;
                    input.appendChild(opt);
                    for (let id in json2)
                    {
                        opt = document.createElement("option");
                        opt.value = id;
                        opt.innerHTML = json2[id];
                        if (json2[id] == value)
                        {
                            opt.selected = true;
                            input.setAttribute("value", id);
                        }
                        input.appendChild(opt);
                    } 
                }

                getList("Fullname", "notLeader", fillSelect);

                input.disabled = true;

                input.setAttribute("value", value);

                input.readOnly = true;
                input.classList.add("editable");
                input.setAttribute("name", label);
                input.autocomplete = "off";
                input.required = true;

                td.appendChild(input);
                tr.appendChild(td);
            }

            return tr;  
        }

        const InfosElem = document.querySelector("#person-infos table#infos");

        InfosElem.appendChild(createTableRow("Leader", json["Fullname"]));

        this.showed = true;
    }
}

class TeamPageButtonsHandler 
{
    static saveAction()
    {
        const formElem = document.forms["person-edit-form"];
        if (!formElem.checkValidity()) return;
        const keys = Object.keys(formElem);

        //Check if form has changed
        let changed = false;
        for (let i = 0; i < keys.length; i++)
        {
            if (formElem[keys[i]].value != formElem[keys[i]].getAttribute("value"))
            {
                changed = true;
                break;
            }
        }
        if (!changed) return;

        const josnToSend = {
            team: formElem["name"].value,
            leader: formElem["Leader"].value
        };

        const http = new XMLHttpRequest();
        http.onreadystatechange = function()
        {
            if (this.readyState == 4 && this.status == 200)
            {
                console.log(this.responseText);
                location.reload();
            }
        }

        if (TeamsHandler.currentID == 0)
            http.open("POST", `../controller/send_data/send_data_controller.php/team/insert`);
        else
            http.open("POST", 
                "../controller/send_data/send_data_controller.php/" +
                `team/update?id=${TeamsHandler.currentID}`);
       
        http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        http.send(JSON.stringify(josnToSend));
    }

    static deleteAction()
    {
        if (confirm("Are you sure to delete this team"))
        {
            const http = new XMLHttpRequest();
            http.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200)
                {
                    console.log(this.responseText);
                    location.reload();
                }
            }

            http.open("POST", "../controller/send_data/send_data_controller.php/"+
                      `team/delete?id=${TeamsHandler.currentID}`);
            http.send();
        }
    }
}