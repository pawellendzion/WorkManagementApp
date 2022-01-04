<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <?php require_once "global_style_links.html" ?>
    <link rel="stylesheet" href="../css/customers_style.css">

    <script>
        //some config
        const maxCustomersOnPage = 15;
    </script>
    
    <title>Work Manage App</title>
</head>
<body onload="highlightMenu('customers'); getCustomers(1); getCustomersCount()">
    <?php require_once "menu_panel.html" ?>
    <div class="wrapper">
        <div>
            <p>Customers <span id="customersCount"></span></p>
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
                <button onclick="customersListHandler.previousPage(getCustomers);"><</button>
                <span id="currentPage"></span>/<span id="customersPages"></span>
                <button onclick="customersListHandler.nextPage(getCustomers);">></button>
            </div>
        </div>
    </div>

    <script src="../scripts/get_data.js"></script>
    <script src="../scripts/customers_list.js"></script>
    <script>
        let customersListHandler;
        (async() => {
            while(customersCount == null)
                await new Promise(resolve => setTimeout(resolve, 200));
            customersListHandler = new CustomersListHandler(customersCount, maxCustomersOnPage);
        })();
    </script>
</body>
</html>