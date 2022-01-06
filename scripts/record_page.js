class RecordPageHandler
{
    constructor(recordsCount, maxRecords)
    {
        this._maxRecords = parseInt(maxRecords);
        this._currentPage = 1;
        this._recordsCount = parseInt(recordsCount);
        
        this._currentPageHtmlElem = document.querySelector("span#currentPage");
        this._currentPageHtmlElem.innerHTML = this._currentPage;
    }

    nextPage(getRecordsCallback, typeOfRecords)
    {
        if (this._currentPage * this._maxRecords < this._recordsCount)
        {
            this._currentPage += 1;
            this._currentPageHtmlElem.innerHTML = this._currentPage;
            getRecordsCallback(typeOfRecords, this._currentPage);
        }
    }
    previousPage(getRecordsCallback, typeOfRecords)
    {
        if (this._currentPage > 1)
        {
            this._currentPage -= 1;
            this._currentPageHtmlElem.innerHTML = this._currentPage;
            getRecordsCallback(typeOfRecords, this._currentPage);
        }
    }
}