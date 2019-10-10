<?php
@session_start();
if(!isset($_SESSION['user']) || $_SESSION['user'] != "admin") {
	header("Location: login.php");
}
require_once('config.php');
try {
    $sql = new PDO($dbdsn, $dbuser, $dbpass, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    die("Can't connect to database. Check your config.php.");
}

$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
switch ($_POST['action']) {
    case 'add_faucet':
        addFaucet($_POST['name'], $_POST['url'], $_POST['min'], $_POST['max'], $_POST['time']);
        break;
    case 'get_faucet':
        getFaucet($_POST['url']);
        break;
    case 'delete_faucet':
        deleteFaucet($_POST['id_faucet']);
        break;
    case 'get_report':
        getReport($_POST['id_report']);
        break;
    case 'save':
        save($_POST['ads_left'], $_POST['ads_top'], $_POST['css']);
        break;
    case 'change_password':
        changePass($_POST['actual_passw'], $_POST['new_passw']);
        break;
    case 'delete_report':
        deleteReport($_POST['report_id']);
        break;
    case 'update_faucet':
        updateFaucet($_POST['name'], $_POST['url'], $_POST['min'], $_POST['max'], $_POST['time'], $_POST['id']);
        break;
    default:
        break;
}

function addFaucet($name, $url, $min, $max, $time) {    
    global $sql;
    $query = $sql->prepare('INSERT INTO rotator_faucets(faucet, url, min_reward, max_reward, time) VALUES(?, ?, ?, ?, ?)');

    try {
        $query->execute(array($name, $url, $min, $max, $time));
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            echo "A faucet with that name/url already exist.";
        } else {
            echo $e;    
        }
    }
}

function updateFaucet($name, $url, $min, $max, $time, $id) {
    global $sql;
    $query = $sql->prepare('UPDATE rotator_faucets SET faucet = ?, min_reward = ?, max_reward = ?, time = ?, url = ? WHERE id = ?');
    $query->execute(array($name, $min, $max, $time, $url, $id));
}


function getFaucet($urlLike) {
    global $sql;
    $query = $sql->prepare('SELECT id, faucet, url, min_reward, max_reward, votes, time FROM rotator_faucets WHERE url LIKE ?');
    $query->execute(array("%" . $urlLike . "%"));
    echo json_encode($query->fetch());
}

function deleteFaucet($id) {
    global $sql;

    $query = $sql->prepare('DELETE FROM rotator_faucets WHERE id = ?');
    if($query->execute(array($id))){
        echo "1";
    }
}

function deleteReport($id) {
    global $sql;
    $query = $sql->prepare('DELETE FROM rotator_reports WHERE id_report = ?');
    if(!$query->execute(array($id))) {
        echo "Error deleting report.";
    }
}

function getReport($id) {
    global $sql;
    $query = $sql->prepare('SELECT id_report, title, message FROM rotator_reports WHERE id_report =  ?');
    $query->execute(array($id));
    echo json_encode($query->fetch());
}

function getReports() {
    global $sql;
    $query = $sql->prepare('SELECT id_report, id_faucet, title, message, faucet, url, votes FROM rotator_reports LEFT JOIN rotator_faucets ON rotator_reports.id_faucet = rotator_faucets.id ORDER BY faucet DESC');
    $query->execute();
    return $query->fetchAll();
}

function save($left, $top, $css) {
    global $sql;
    $query = $sql->prepare('UPDATE rotator_config SET value = ? WHERE name = "ads-left"');
    if(!$query->execute(array($left))) {
        echo "Error saving ads-left.";
        return;
    }

    $query = $sql->prepare('UPDATE rotator_config SET value = ? WHERE name = "ads-top"');
    if(!$query->execute(array($top))) {
        echo "Error saving ads-top.";
        return;
    }

    $query = $sql->prepare('UPDATE rotator_config SET value = ? WHERE name = "custom_css"');
    if(!$query->execute(array($css))) {
        echo "Error saving css.";
        return;
    }

    echo "Changes successfully saved.";
}

function changePass($actual, $new) {
    global $sql;
    $query = $sql->prepare('SELECT value FROM rotator_config WHERE name = "passw"');
    $query->execute();
    $hash1 = $query->fetch(PDO::FETCH_OBJ)->value;
    $hash2 = crypt($actual, $hash1);

    if($hash1 != $hash2) {
        echo "Invalid actual password";
        return;
    }

    $new_hash = crypt($new);
    $query = $sql->prepare('UPDATE rotator_config SET value = ? WHERE name="passw"');
    if($query->execute(array($new_hash))) {
        echo "Password updated.";
        return;
    }

    echo "Fail password update.";
}
