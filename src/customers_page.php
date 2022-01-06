<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <?php require_once "global_style_links.html" ?>
    <link rel="stylesheet" href="../css/customers_and_employees_style.css">

    <script>
        //some config
        const maxRecords = 15;
    </script>
    
    <title>Work Manage App</title>
</head>
<body onload="highlightMenu('customers'); getRecords('customers', 1); getRecordsCount('customers')">
    <?php require_once "menu_panel.html" ?>
    <div class="wrapper">
        <div>
            <p>Customers <span id="recordsCount"></span></p>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th id="name">
                                CUSTOMER NAME
                            </th>
                            <th id="email">
                                EMAIL
                            </th>
                            <th id="phone">
                                PHONE
                            </th>
                            <th id="last-contact">
                                LAST CONTACT
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="buttons">
                <button onclick="customersRecordHandler.previousPage(getRecords, 'customers');"><</button>
                <span id="currentPage"></span>/<span id="recordsPages"></span>
                <button onclick="customersRecordHandler.nextPage(getRecords, 'customers');">></button>
            </div>
        </div>
    </div>

    <script src="../scripts/get_data.js"></script>
    <script src="../scripts/record_page.js"></script>
    <script>
        let customersRecordHandler;
        (async() => {
            while(recordsCount == null)
                await new Promise(resolve => setTimeout(resolve, 200));
            customersRecordHandler = new RecordPageHandler(recordsCount, maxRecords);
        })();
    </script>
</body>
</html>