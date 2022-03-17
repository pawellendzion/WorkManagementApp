class PersonPageHandler 
{
    static domElement = document.getElementById("wrapper-person-page");
    static currentID = undefined;
    static type = undefined;
    static showed = false;

    static toggle(type, id)
    {
        if (this.domElement.style.display == "none")
        {
            document.querySelector("input#save").setAttribute("onclick", "PersonPageButtonsHandler.saveAction()")
            document.querySelector("input#delete").setAttribute("onclick", "PersonPageButtonsHandler.deleteAction()")

            this.domElement.style.display = "block";
            this.currentID = id;
            this.type = type;
            getPersonInfo(type, id, this.showInfo);

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
            this.type = undefined;

            //Clear fields
            document.querySelector("#person-name").setAttribute("value", "");
            document.querySelector("#person-infos table#infos").innerHTML = "";
        }
    }

    static showInfo = (json) =>
    {
        const nameElem = document.querySelector("#person-name");
        nameElem.setAttribute("value", json["Name"] + (json["ID"] ? " " : "") + json["Lastname"]);
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
                
                let input = document.createElement("input");
                input.required = true;

                if (label.match(/date|contact/i))
                {
                    input.type = "date";
                    if (this.type == "customer") input.required = false;
                }
                else if (label.match(/phone/i))
                {
                    input.pattern = "[0-9]{3}-[0-9]{3}-[0-9]{3}";
                    input.placeholder = "XXX-XXX-XXX";
                }
                else if (label.match(/email/i))
                {
                    input.type = "email";
                    input.placeholder = "example@email.com";
                }
                else if (label.match(/salary/i))
                {
                    input.type = "number";
                }

                if (label.match(/team/i))
                {
                    input = document.createElement("select");
                    
                    const fillSelect = function(json2){
                        let opt = document.createElement("option");
                        opt.value = "NULL";
                        input.setAttribute("value", "NULL");
                        opt.innerHTML = "Not assign";
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

                    getList("Name", "teams", fillSelect);
                    input.disabled = true;
                }
                else input.setAttribute("value", value);

                input.readOnly = true;
                input.classList.add("editable");
                input.setAttribute("name", label);
                input.autocomplete = "off";

                td.appendChild(input);
                tr.appendChild(td);
            }

            return tr;
        }

        const InfosElem = document.querySelector("#person-infos table#infos");

        InfosElem.appendChild(createTableRow("CONTACT", "", true));
        InfosElem.appendChild(createTableRow("Email", json["Email"]));
        InfosElem.appendChild(createTableRow("Phone", json["Phone"]));

        InfosElem.appendChild(createTableRow("OTHER INFO", "", true));
        const arrOfKeys = Object.keys(json);
        for (let i = 5; i < arrOfKeys.length; i++)
        InfosElem.appendChild(createTableRow(arrOfKeys[i], json[arrOfKeys[i]]));

        this.showed = true;
    }
}

class PersonPageButtonsHandler
{
    static save = document.querySelector("#buttons #save");
    static edit = document.querySelector("#buttons #edit");
    static close = document.querySelector("#buttons #close");
    static cancel = document.querySelector("#buttons #cancel");

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
            firstname: formElem["name"].value.substring(0, formElem["name"].value.search(" ")),
            lastname: formElem["name"].value.substring(formElem["name"].value.search(" ") + 1),
            phone: formElem["Phone"].value,
            email: formElem["Email"].value
        };

        for (let i = 3; i < keys.length - 5; i++)
            josnToSend[i - 3] = formElem[i].value;
        
        const http = new XMLHttpRequest();
        http.onreadystatechange = function()
        {
            if (this.readyState == 4 && this.status == 200)
            {
                console.log(this.responseText);
                location.reload();
            }
        }

        if (PersonPageHandler.currentID == 0)
            http.open("POST", `../controller/send_data/send_data_controller.php/${PersonPageHandler.type}/insert`);
        else
            http.open("POST", 
                "../controller/send_data/send_data_controller.php/" +
                `${PersonPageHandler.type}/update?id=${PersonPageHandler.currentID}`);
       
        http.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        http.send(JSON.stringify(josnToSend));
    }

    static toggleEdiatbles(onOffBool)
    {
        let editableInputs = document.querySelectorAll(".editable");
        editableInputs.forEach(function(elem) {
            elem.readOnly = !onOffBool;
            if (!onOffBool)
            { 
                elem.value = elem.getAttribute("value");
                elem.style.border = "1px solid #fff";
            }
            else
            {
                elem.style.border = "1px solid black";
            }
            if (elem.nodeName == "SELECT") elem.disabled = !onOffBool;
        });
    }

    static setupForNew()
    {
        this.edit.style.display = "none";
        this.cancel.style.display = "none";
        
        this.save.style.display = "inline-block";
        this.close.style.display = "inline-block";

        this.toggleEdiatbles(true);
    }

    static editAction()
    {
        this.edit.style.display = "none";
        this.close.style.display = "none";

        this.save.style.display = "inline-block";
        this.cancel.style.display = "inline-block";

        this.toggleEdiatbles(true);
    }

    static closeAction()
    {
        PersonPageHandler.toggle();

        this.edit.style.display = "inline-block";
        this.close.style.display = "inline-block";

        this.save.style.display = "none";
        this.cancel.style.display = "none";

        PersonPageHandler.showed = false;

        let editableInputs = document.querySelector("#person-name.editable");
        editableInputs.style.border = "1px solid #fff";
        editableInputs.readOnly = true;
    }

    static cancelAction()
    {
        this.edit.style.display = "inline-block";
        this.close.style.display = "inline-block";

        this.save.style.display = "none";
        this.cancel.style.display = "none";

        this.toggleEdiatbles(false);
    }

    static deleteAction()
    {
        if (confirm("Are you sure to delete this person"))
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
                      `${PersonPageHandler.type}/delete?id=${PersonPageHandler.currentID}`);
            http.send();
        }
    }
}