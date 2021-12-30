<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <?php require_once "global_style_links.html" ?>
    <link rel="stylesheet" href="../css/customers_style.css">
    
    <title>Work Manage App</title>
</head>
<body onload="highlightMenu('customers')">
    <?php require_once "menu_panel.html" ?>
    <div class="wrapper">
        <div>
            <p>Customers <span>(<?php echo "0 / 14" ?>)</span></p>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>
                                CUSTOMER NAME
                            </th>
                            <th>
                                EMAIL
                            </th>
                            <th>
                                PHONE
                            </th>
                            <th>
                                LAST CONTACT
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="buttons">
                <button><</button>
                <?php echo "0 / ?" ?>
                <button>></button>
            </div>
        </div>
    </div>
</body>
</html>