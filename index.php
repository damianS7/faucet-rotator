<!DOCTYPE html>
<html>
<head>
	<title>Rotator</title>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.datatables.net/plug-ins/1.10.7/integration/jqueryui/dataTables.jqueryui.js"></script>
  <script src="public/assets/alertify/alertify.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/jqueryui/dataTables.jqueryui.css" />  
  <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" />
  <link rel="icon" href="../bitcoin.png" type="image/png" />
  <link href="public/css/rotator.css" type="text/css" rel="stylesheet" />
  <link href="public/css/list.css" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="public/assets/alertify/themes/alertify.core.css" />
  <link rel="stylesheet" type="text/css" href="public/assets/alertify/themes/alertify.default.css" />
  <script type="text/javascript" src="advertisement.js"></script>
  <script src="public/js/rotator.js"></script>
  <style type="text/css">
    #blockblockA {position:absolute;top:0px;left:0px;background-color:#000000;width:100%;height:100%;text-align: center;}
    #blockblockA h1, #blockblockA .msg{color:red;position: relative;top: 50%;transform: translateY(-50%);}
    #blockblockA .msg{font-size:20px;}
    #blockblockB {visibility:invisible;display:none;height: 100%}
    #linkA {font: bold 13px Verdana;color:#ffffff;}
  </style>
  <style type="text/css">
    <?php require_once('functions.php'); echo getCustomCSS(); ?>
  </style>
</head>
<body onload="loadFaucets('votes')">
  <header>
    <div class="control-left">
     <a href="http://myfaucetbitcoin.com/" class="button" target="_blank">MyFaucetBitcoin</a>	
     <button class="button" onclick="setFaucet('list.php')">List</button>
     <button class="button" onclick="previous()">Previous</button>
     <button class="button" onclick="next()">Next</button>
     <button class="button" onClick="vote('p')" title="Vote +1"><i class="fa fa-thumbs-o-up fa-lg"></i></button>
     <span class="control-text faucet_votes"> 0 </span> 
     <button class="button" onClick="vote('n')" title="Vote -1"><i class="fa fa-thumbs-o-down fa-lg"></i></button>
     <button class="button" onClick="showReport()" title="Report this faucet"><i class="fa fa-exclamation-triangle fa-lg"></i></button>
     <span class="control-text actual_faucet">0</span> of <span class="control-text total_faucets">0</span>
     - <span class="control-text faucet_name"> - </span>
   </div>
   <div class="control-right">
     Order by
     <button class="order-button" onClick="loadFaucets('time')">Time</button>
     <button class="order-button" onClick="loadFaucets('min_reward')">Low reward</button>
     <button class="order-button" onClick="loadFaucets('max_reward')">High reward</button>
     <button class="order-button order-button-selected" onClick="loadFaucets('votes')">Votes</button>
   </div>
 </header>
 
<!-- ADBLOCK -->
  <noscript>
    <style type="text/css">
      #blockblockA {visibility:invisible!important;display:none!important;}
      #blockblockB {visibility:visible!important;display:block!important;}
    </style>
  </noscript>

  <div id="blockblockA">
    <p><h1>Please disable your Adblock.</h1></p>
    <p class="msg"></p>
  </div>
  <span id="blockblockB"> 

 <div class="report">
  <?php include_once('report.php'); ?>
</div>

<div class="left">
  <?php require_once('functions.php'); echo getAdsLeft(); ?>
</div>
<div class="container">    
  <div class="horizontal-ads">
    <?php require_once('functions.php'); echo getAdsTop(); ?>
  </div>    
  <div class="right">
    <iframe id="frame" width="100%" height="100%" sandbox="allow-forms allow-pointer-lock allow-popups allow-scripts allow-same-origin" seamless="" src=""></iframe>
  </div>
</div>
</body>
</html>