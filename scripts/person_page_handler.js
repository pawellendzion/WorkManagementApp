class PersonPageHandler {
    static domElement = document.getElementById("wrapper-person-page");
    static currentID = undefined;
    static type = undefined;

    static toggle(type, id)
    {
        if (this.domElement.style.display == "none")
        {
            this.domElement.style.display = "block";
            this.currentID = id;
            this.type = type;
            getPersonInfo(type, id, this.showInfo);
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

    static showInfo(json)
    {
        const nameElem = document.querySelector("#person-name");
        nameElem.setAttribute("value", json["Name"] + " " + json["Lastname"]);
        
        const createTableRow = function(label, value, colspan = false) {
            const tr = document.createElement("tr");

            let td = document.createElement("td");
            td.innerHTML = label;
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
                input.readOnly = true;
                input.setAttribute("value", value);
                input.classList.add("editable");

                let pattern = /date|contact/i;
                if (label.match(pattern))
                {
                    input.type = "date";
                }

                td.appendChild(input);
                tr.appendChild(td);
            }

            return tr;
        }

        const InfosElem = document.querySelector("#person-infos table#infos");

        InfosElem.appendChild(createTableRow("CONTACT", "", true));
        InfosElem.appendChild(createTableRow("Email:", json["Email"]));
        InfosElem.appendChild(createTableRow("Phone:", json["Phone"]));

        InfosElem.appendChild(createTableRow("OTHER INFO", "", true));
        const arrOfKeys = Object.keys(json);
        for (let i = 5; i < arrOfKeys.length; i++)
        InfosElem.appendChild(createTableRow(arrOfKeys[i] + ":", json[arrOfKeys[i]]));
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

    }

    static editAction()
    {
        this.edit.style.display = "none";
        this.close.style.display = "none";

        this.save.style.display = "inline-block";
        this.cancel.style.display = "inline-block";

        let editableInputs = document.querySelectorAll(".editable");
        editableInputs.forEach(function(elem) { 
            elem.readOnly = false;
            elem.style.border = "1px solid black";
        });
    }

    static closeAction()
    {
        PersonPageHandler.toggle();
    }

    static cancelAction()
    {
        this.edit.style.display = "inline-block";
        this.close.style.display = "inline-block";

        this.save.style.display = "none";
        this.cancel.style.display = "none";

        let editableInputs = document.querySelectorAll(".editable");
        editableInputs.forEach(function(elem) {
            elem.readOnly = true;
            elem.value = elem.getAttribute("value");
            elem.style.border = "1px solid #fff";
        });
    }
}