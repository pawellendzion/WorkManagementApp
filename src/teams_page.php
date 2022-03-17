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
<body onload="highlightMenu('teams'); getRecords('teams', 1); getRecordsCount('teams')">
    <?php require_once "menu_panel.html" ?>
    
    <div class="wrapper">
        <div>
            <p>Teams <span id="recordsCount"></span> <!--<button class="add-new" onclick="">+ add new</button>--></p>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50%;">
                                Team name
                            </th>
                            <th style="width: 50%;">
                                Leader name
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="buttons">
                <button onclick="teamsRecordHandler.previousPage(getRecords, 'teams');"><</button>
                <span id="currentPage">1</span>/<span id="recordsPages"></span>
                <button onclick="teamsRecordHandler.nextPage(getRecords, 'teams');">></button>
            </div>
        </div>
    </div>

    <script src="../scripts/get_data.js"></script>
    <script src="../scripts/record_page.js"></script>
    <script src="../scripts/person_page_handler.js"></script>
    <script>
        let teamsRecordHandler;
        (async() => {
            while(recordsCount == null)
                await new Promise(resolve => setTimeout(resolve, 200));
                teamsRecordHandler = new RecordPageHandler(recordsCount, maxRecords);
        })();
    </script>
</body>
</html>