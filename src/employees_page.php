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
    
    <title>Work Management App</title>
</head>
<body onload="highlightMenu('employees'); getRecords('employees', 1); getRecordsCount('employees')">
    <?php require_once "menu_panel.html" ?>
    <?php require_once "person_info_page.html" ?>

    <div class="wrapper">
        <div>
            <p>Employees <span id="recordsCount"></span></p>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>
                                EMPLOYEES NAME
                            </th>
                            <th>
                                EMAIL
                            </th>
                            <th>
                                PHONE
                            </th>
                            <th>
                                EMPLOYMENT DATE
                            </th>
                            <th>
                                TEAM
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="buttons">
                <button onclick="employeesListHandler.previousPage(getRecords, 'employees');"><</button>
                <span id="currentPage">1</span>/<span id="recordsPages"></span>
                <button onclick="employeesListHandler.nextPage(getRecords, 'employees');">></button>
            </div>
        </div>
    </div>

    <script src="../scripts/get_data.js"></script>
    <script src="../scripts/record_page.js"></script>
    <script src="../scripts/person_page_handler.js"></script>
    <script>
        let employeesListHandler;
        (async() => {
            while(recordsCount == null)
                await new Promise(resolve => setTimeout(resolve, 200));
            employeesListHandler = new RecordPageHandler(recordsCount, maxRecords);
        })();
    </script>
</body>
</html>