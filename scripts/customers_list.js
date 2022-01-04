class CustomersListHandler
{
    constructor(customersCount, maxCustomersOnPage)
    {
        this._maxCustomersOnPage = parseInt(maxCustomersOnPage);
        this._currentPage = 1;
        this._customersCount = parseInt(customersCount);
        
        this._currentPageHtmlElem = document.querySelector("span#currentPage");
        this._currentPageHtmlElem.innerHTML = this._currentPage;
    }

    nextPage(callback)
    {
        if (this._currentPage * this._maxCustomersOnPage < this._customersCount)
        {
            this._currentPage += 1;
            this._currentPageHtmlElem.innerHTML = this._currentPage;
            callback(this._currentPage);
        }
    }
    previousPage(callback)
    {
        if (this._currentPage > 1)
        {
            this._currentPage -= 1;
            this._currentPageHtmlElem.innerHTML = this._currentPage;
            callback(this._currentPage);
        }
    }
}