<?php
require_once('config.php');
try {
   	$sql = new PDO($dbdsn, $dbuser, $dbpass, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
	die("Can't connect to database. Check your config.php.");
}

$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

switch ($_POST['action']) {
	case 'get_faucets':
		getFaucetsJSON($_POST['orderby']);
		break;
	case 'vote_faucet':
		voteFaucet($_POST['vote'], $_POST['id']);
		break;
	case 'report_faucet':
		reportFaucet($_POST['id'], $_POST['title'], $_POST['msg']);
		break;
	default:
		break;
}

function reportFaucet($id, $title, $msg) {
	if($title == "" || $msg == "") {
		echo "Fields cannot be empty.";
		return;
	}
	
	global $sql;
	$ip = getIP();
	$query = $sql->prepare('SELECT * FROM rotator_reports WHERE ip = ? AND id_faucet = ?');
	$query->execute(array($ip, $id));

	if($query->rowCount() != 0) {
		echo "You can't report this faucet again.";
		return;
	}

	$query = $sql->prepare('INSERT INTO rotator_reports(id_faucet, title, message, ip) VALUES (?, ?, ?, ?)');
	if(!$query->execute(array($id, $title, $msg, $ip))) {
		echo "Error while sending report.";
		return;
	}
	echo "Report added.";
}

function getFaucets($orderBy) {
	switch ($orderBy) {
		case 'time':
			$mode = "ASC";
			break;
		case 'votes':
			$mode = "DESC";
			break;
		case 'min_reward':
			$mode = "DESC";
			break;
		case 'max_reward':
			$mode = "DESC";
			break;
		default:
			$orderBy = "votes";
			$mode = "DESC";
			break;
	}

	global $sql;
	
	$query = $sql->prepare('SELECT id, faucet, url, min_reward, max_reward, time, votes FROM rotator_faucets ORDER BY ' . $orderBy . ' ' . $mode);
	$query->execute();
	return $query->fetchAll();
}

function getFaucetsJSON($orderBy) {
	echo json_encode(getFaucets($orderBy));
}

function voteFaucet($vote, $id) {
	global $sql;
	$ip = getIP();
	$query = $sql->prepare('SELECT * FROM rotator_votes WHERE ip = ? AND id_faucet = ?');
	$query->execute(array($ip, $id));

	if($query->rowCount() != 0) {
		echo "You can't vote this faucet again.";
		return;
	}

	switch ($vote) {
		case 'p':
			$query = $sql->prepare('UPDATE rotator_faucets SET votes = votes+1 WHERE id = ?');	
			break;
		case 'n':
			$query = $sql->prepare('UPDATE rotator_faucets SET votes = votes-1 WHERE id = ?');
			break;
		default:
			echo "Unvalid vote option";
			return;
	}

	$query->execute(array($id));
	$query = $sql->prepare('INSERT INTO rotator_votes(ip, id_faucet) VALUES (?, ?)');
	if(!$query->execute(array($ip, $id))) {
		echo "Something went wrong, vote wasn't added.";
		return;
	}

	echo "Vote added sucessfully.";
}

function getIP() {
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
 		$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	return $_SERVER['REMOTE_ADDR'];
}

function getAdsLeft() {
	global $sql;
	$query = $sql->prepare('SELECT value FROM rotator_config WHERE name = "ads-left"');
	$query->execute();
	$val = $query->fetch(PDO::FETCH_OBJ)->value;
	return rawurldecode($val);
}

function getAdsTop() {
	global $sql;
	$query = $sql->prepare('SELECT value FROM rotator_config WHERE name = "ads-top"');
	$query->execute();
	$val = $query->fetch(PDO::FETCH_OBJ)->value;
	return rawurldecode($val);
}

function getCustomCSS() {
	global $sql;
	$query = $sql->prepare('SELECT value FROM rotator_config WHERE name = "custom_css"');
	$query->execute();
	$val = $query->fetch(PDO::FETCH_OBJ)->value;
	return rawurldecode($val);
}