//maxCustomersOnPage is definded in src/customers_list.php in head tag

function getCustomers(pageNum) 
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
        console.error(`funcion getCustomers takes integer but got pageNum=${pageNum}`);
        pageNum = 1;
    }

    let to = pageNum * maxCustomersOnPage;
    let from = to - maxCustomersOnPage;

    http.open("GET", `../controller/get_data//get_data_controller.php?data=customers&from=${from}&to=${to}`);
    http.send();
}

let customersCount = null;
/**
 * Once you call this function customers count
 * will be stored in variable "customersCount"
 */
function getCustomersCount() 
{
    const http = new XMLHttpRequest();
    http.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            customersCount = parseInt(this.responseText);
            document.querySelector("span#customersCount").innerHTML = `(${this.responseText})`;
            document.querySelector("span#customersPages").innerHTML = 
                Math.ceil(parseFloat(this.responseText)/parseFloat(maxCustomersOnPage));
        }
    }

    http.open("GET", "../controller/get_data//get_data_controller.php?data=customersCount");
    http.send();

}