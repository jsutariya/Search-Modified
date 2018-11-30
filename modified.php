<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Modified Script</title>
        <style type="text/css">
        .result-table td {
            padding: 3px 0 3px 15px;
        }
        body{
            /*background:#ccc;*/
            margin:0px auto;
            width: 65%;
            /*background-image: url("bg.jpg");
            color: #fff;*/
        }
        h1{
            text-align: center;
            margin-top:10px;
            text-decoration: underline;
        }
        .main-div{
            margin:0px auto;
            float:left;
            width:100%;
            box-shadow: 0px 1px 11px #000;
            border: 1px outset #fff;
        }
        .result-table{
            margin: 0px auto;
            float: left;
            width: 100%;
            box-shadow: 0px 1px 11px #000;
            margin-top:5px;
            font-size: 13px;
        }
        .suggestion-string{
            clear: both;
            float: left;
            font-size: 11px;
            line-height: 26px;
            margin-left: 5px;
            position: absolute;
        }
        form{
            padding:30px 30px 0;
        }
        .search-button{
            float:right;
            margin-top:25px;
        }
        thead {
            text-align: center;
            font-size: 20px;
        }
        </style>
    </head>
    <body>
        <h1>Search Modified File</h1>
        <div class="main-div">
            <form action="" method="post">
                <table>
                    <tr><td><label><?php echo "Enter Days"; ?></label><td><input type="text" name="days" id="days" value="<?php echo (isset($_POST['days'])) ? $_POST['days'] : ""; ?>" /><label class="suggestion-string">Enter Days</label></td></tr>
                    <tr><td><label><?php echo "Directory"; ?></label><td><input type="text" name="dir" id="dir"  value="<?php echo (isset($_POST['dir'])) ? $_POST['dir'] : ""; ?>"/><label class="suggestion-string">Enter directory path e.g. app/code/local</label></td></tr>
                    <tr><td><label><?php echo "File Extensions"; ?></label><td><input type="text" name="ext" id="ext"  value="<?php echo (isset($_POST['ext'])) ? $_POST['ext'] : ""; ?>"/><label class="suggestion-string">Enter file extensions. e.g. php / For multiple file types e.g. php,phtml<br>Keep empty for all file types</label></td></tr>
                    <tr></tr>
                    <tr><td colspan="2"><input class="search-button" type="submit" title="Search" value="Search"/></td></tr>
                </table>
            </form>
        </div>
    </body>
</html>
<?php
session_start();
if ($_POST) {
    $dir = ($_POST['dir']) ? $_POST['dir'] : getcwd();
    $findInDays = 0;
    $extArray = [];
    if ($_POST['ext'] != "") {
        $extArray = explode(",", $_POST['ext']);
    }
    echo "<table border='1' class='result-table'><thead><tr><td colspan='2'>Search Results</td></tr></thead><tbody><tr><td>Filepath</td><td>Last Modified Date</td></tr>";
    listFolderFiles($dir, $extArray);
    krsort($_SESSION);
    foreach ($_SESSION as $days => $filePath) {
        echo  "<tr><td>" . $filePath . "</td><td>" . date('d/m/Y h:i:s', $days) . "</td></tr>";
    }
    echo "</tbody></table>";
}

function listFolderFiles($dir, $extArray)
{
    $ffs = scandir($dir);
    foreach ($ffs as $ff) {
        if ($ff != '.' && $ff != '..') {
            if (is_dir($dir . '/' . $ff)) {
                listFolderFiles($dir . '/' . $ff, $extArray);
            } else {
                $extension = pathinfo($dir . '/' . $ff, PATHINFO_EXTENSION);
                if (!empty($extArray)) {
                    if (in_array($extension, $extArray)) {
                        $content = file_get_contents($dir . '/' . $ff);
                        $modifiedDate = filemtime($dir . '/' . $ff);
                        $currentDate = strtotime("now");
                        $seconds_diff = $currentDate - $modifiedDate;
                        $passedTimeInDays = floor($seconds_diff/3600/24);

                        if ($passedTimeInDays <= $_POST['days']) {
                            if (!array_key_exists($modifiedDate, $_SESSION)) {
                                $_SESSION[$modifiedDate] = $dir . '/' . $ff;
                            } else {
                                $modifiedDate++;
                                $_SESSION[$modifiedDate] = $dir . '/' . $ff;
                            }
                        }
                    }
                } else {
                    $content = file_get_contents($dir . '/' . $ff);
                    $modifiedDate = filemtime($dir . '/' . $ff);
                    $currentDate = strtotime("now");
                    $seconds_diff = $currentDate - $modifiedDate;
                    $passedTimeInDays = floor($seconds_diff/3600/24);

                    if ($passedTimeInDays <= $_POST['days']) {
                        if (!array_key_exists($modifiedDate, $_SESSION)) {
                            $_SESSION[$modifiedDate] = $dir . '/' . $ff;
                        } else {
                            $modifiedDate++;
                            $_SESSION[$modifiedDate] = $dir . '/' . $ff;
                        }
                    }
                }
            }
        }
    }
}
session_destroy();
