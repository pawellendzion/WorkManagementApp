//maxRecords has to be defined in template where this script is used

/**
 * @typeOfRecords customers / employees
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

    http.open("GET", `../controller/get_data/get_data_controller.php?data=${typeOfRecords}&from=${from}&to=${to}`);
    http.send();
}

let recordsCount = null;
/**
 * Once you call this function records count
 * will be stored in variable "recordsCount"
 * @typeOfRecords customers / employees
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

    http.open("GET", `../controller/get_data//get_data_controller.php?data=${typeOfRecords}Count`);
    http.send();

}