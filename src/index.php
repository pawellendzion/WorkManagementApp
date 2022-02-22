<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <?php require_once "global_style_links.html" ?>
    <link rel="stylesheet" href="../css/home_page_style.css">
    
    <title>Work Management App</title>
</head>
<body onload="highlightMenu('home')">
    <?php require_once "menu_panel.html" ?>
    <div class="wrapper">
        <div class="welcome-box">
            <p>Welcome to <br /> Work Management App</p>
        </div>
        <div class="info">
            <div class="inline">
                <div><ion-icon name="bookmark-outline"></ion-icon> <br /> manage tasks</div>
                <div><ion-icon name="people-outline"></ion-icon> <br /> manage employees</div>
                <div><ion-icon name="people-circle-outline"></ion-icon> <br /> manage customers</div>
            </div>
            <div class="inline">
                <div></div>
                <div><ion-icon name="information-circle-outline"></ion-icon> <br /> show details</div>
                <div></div>
            </div>
        </div>
    </div>
</body>
</html>