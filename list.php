<?php
require_once('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.7/integration/jqueryui/dataTables.jqueryui.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/jqueryui/dataTables.jqueryui.css" />  
    <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" />
    <link href="public/css/rotator.css" type="text/css" rel="stylesheet" />
    <link href="public/css/list.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
    <script src="public/js/rotator.js"></script>    
    <script type="text/javascript">
        $(document).ready(function() {
            $('#faucet-list').DataTable( {
                "bJQueryUI": true,
                "iDisplayLength": 10
            });
        });
    </script>
</head>
<body>
<table id="faucet-list" class="display" cellspacing="0">
    <thead>
        <tr>
            <th>Site</th>
            <th>Min reward</th>
            <th>Max reward</th>
            <th>Time</th>
            <th>Votes</th>
        </tr>
    </thead>
    <tbody>
       <?php 
       $faucets = getFaucets("votes");

       foreach ($faucets as $faucet) {
         echo "<tr>";
         echo "<td><a target=\"_blank\" href=\"" . $faucet['url'] . "\" class=\"faucet-link\">" . $faucet['faucet'] . "</a></td>";
         echo "<td>" . $faucet['min_reward'] . "</td>";
         echo "<td>" . $faucet['max_reward'] . "</td>";
         echo "<td>" . $faucet['time'] . "</td>";
         echo "<td>" . $faucet['votes'] . "</td>";
         echo "</tr>";
     }
     ?>
 </tbody>
</table>
</body>
</html>