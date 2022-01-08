<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <?php require_once "global_style_links.html" ?>
    <link rel="stylesheet" href="../css/tasks_style.css">
    
    <title>Work Manage App</title>
</head>
<body onload="highlightMenu('tasks')">
    <?php require_once "menu_panel.html" ?>
    <div class="wrapper">
        <div>
            <div class="task-block">
                <div class="title">TO DO</div>
                <div class="body">
                    <div class="hidden-scroll" id="to-do">
                        <div class="new" onclick="addNew()"><b>+</b>&nbsp; add new</div>
                    </div>
                </div>
            </div>

            <div class="task-block">
                <div class="title">WORKING ON</div>
                <div class="body"></div>
            </div>

            <div class="task-block">
                <div class="title">COMPLETED</div>
                <div class="body"></div>
            </div>
            </div>
        </div>
    </div>

    <script src="../scripts/tasks_handler.js"></script>
</body>
</html>