<?php
session_start();
require_once('functions.php');
require_once('admin-functions.php');
if(!isset($_SESSION['user']) || $_SESSION['user'] != "admin") {
	header("Location: login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Bitcoin-gator.com - Faucet rotator</title>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="icon" href="../bitcoin.png" type="image/png" />
    <link href="public/css/skyform.css" type="text/css" rel="stylesheet" />
    <link href="public/css/admin.css" type="text/css" rel="stylesheet" />
    <link href="public/css/rotator.css" type="text/css" rel="stylesheet" />
    <link href="public/assets/font-awesome/css/font-awesome.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/jqueryui/dataTables.jqueryui.css" />  
    <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="public/assets/alertify/themes/alertify.core.css" />
    <link rel="stylesheet" type="text/css" href="public/assets/alertify/themes/alertify.default.css" />
    <script src="public/assets/alertify/alertify.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.7/integration/jqueryui/dataTables.jqueryui.js"></script>
    <script src="public/js/admin.js"></script>
</head>
<body>
    <header>
        <div class="control-left">
        <a href="#" onClick="showFaucetManager()" class="button">Faucet</a>
        <a href="#" onClick="showReports()" class="button">Reports</a>
        <a href="#" onClick="showAdsConfig()" class="button">Config</a>
        <a href="logout.php" class="button">Logout</a>
        </div>
    </header>
    <div class="content">
        <div class="add sky-form">
            <fieldset>
                <section>
                    <label class="input">
                        <input type="text" id="id_faucet" placeholder="Faucet id" disabled />
                        <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                    </label>
                    <label class="input">
                        <input type="text" id="faucet_name" placeholder="Faucet name"/>
                        <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                    </label>
                    <label class="input">
                        <input type="text" id="faucet_url" placeholder="Faucet URL" />
                        <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                    </label>
                    <label class="input">
                        <input type="text" id="min_reward" placeholder="Min reward" />
                        <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                    </label>
                    <label class="input">
                        <input type="text" id="max_reward" placeholder="Max reward"  />
                        <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                    </label>
                    <label class="input">
                        <input type="text" id="time" placeholder="Time" />
                        <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                    </label>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <label class="text">
                        <span class="error"></span>
                    </label>
                </section>
            </fieldset>
            <footer>
                <button onClick="addFaucet()" class="button">Add</button>   
                <button onClick="updateFaucet()" class="button">Update</button>             
                <button onClick="checkFaucet()" class="button">Check</button>
                <button onClick="findFaucet()" class="button">Find</button>
                <button onClick="deleteFaucet()" class="button">Delete</button>
            </footer>
        </div>

        <div class="reports">
            <div class="sky-form">
                <fieldset>
                    <section>
                        <label class="input">
                            <input type="text" id="report_id" placeholder="Faucet id" disabled />
                            <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                        </label>
                        <label class="input">
                            <input type="text" id="report_title" placeholder="Report title" />
                            <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                        </label>
                        <label class="textarea">
                            <textarea id="report_message">Report message</textarea>
                            <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                        </label>
                    </section>
                </fieldset>
                <fieldset>
                    <section>
                        <label class="text">
                            <span class="error"></span>
                        </label>
                    </section>
                </fieldset>
                <footer>
                    <button class="button" onClick="deleteReport()">Delete</button>
                </footer>
            </div>
            <table id="faucet-reports" class="display" cellspacing="0">
                <thead>
                    <tr>
                        <th>Faucet</th>
                        <th>Report ID</th>
                        <th>Url</th>
                        <th>Votes</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php 
                    $reports = getReports();

                    foreach ($reports as $report) {
                        echo "<tr>";
                        echo "<td> " . $report['faucet'] . " </td>";
                        echo "<td><a href=# onClick='getReport(" . $report['id_report'] . ")'>See report</a></td>";
                        echo "<td> " . $report['url'] . " </td>";
                        echo "<td> " . $report['votes'] . " </td>";
                        //echo "<td><a href=# onClick='deleteReport(" . $report['id_report'] . ")'>Delete</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="config">
            <div class="sky-form">
                <header>Change password</header>
                <fieldset>    
                    <section>
                        <label class="input">
                            <input type="text" id="actual_passw" placeholder="Actual password" />
                            <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                        </label>
                        <label class="input">
                            <input type="text" id="new_passw" placeholder="New password" />
                            <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                        </label>
                        <label class="input">
                            <input type="text" id="new_passw2" placeholder="Repeat password" />
                            <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                        </label>
                    </section>
                    <button class="button" onClick="changePassword()">Update password</button>
                </fieldset>
                <header>ADS Left</header>
                <fieldset>
                 <section>
                     <label class="textarea">
                        <textarea id="ads-left" rows="10"><?php echo getAdsLeft(); ?></textarea>
                        <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                    </label>
                </section>
            </fieldset>
            <header>ADS Top</header>
            <fieldset>
             <section>
                 <label class="textarea">
                    <textarea id="ads-top" rows="10"><?php echo getAdsTop(); ?></textarea>
                    <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                </label>
            </section>
        </fieldset>
        <header>Custom CSS</header>
            <fieldset>
             <section>
                 <label class="textarea">
                    <textarea id="custom_css" rows="10"><?php echo getCustomCSS(); ?></textarea>
                    <b class="tooltip tooltip-bottom-right">Only latin characters and numbers</b>
                </label>
            </section>
        </fieldset>
        <footer>
            <button class="button" onClick="save()">Save</button>
        </footer>
    </div>
</div>
</div>
<iframe id="frame" width="100%" height="100%" sandbox="allow-forms allow-pointer-lock allow-popups allow-scripts allow-same-origin" seamless="" src=""></iframe>
</div>
</body>
</html>