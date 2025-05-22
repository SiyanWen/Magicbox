<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $details = $_POST['details'];
    $dateTime = new DateTimeImmutable('now', new DateTimeZone('America/New_York'));
    $time = $dateTime->format('H:i:s');
    $date = $dateTime->format('M d, Y');
    $decision = "no";

    $search  = array('&', '<', '>', '"', "'");
    $replace = array('&amp;', '&lt;', '&gt;', '&quot;', '&#39;');
    $escaped=str_replace($search, $replace, $details);




    if (isset($_POST['is_plaintext']) && is_array($_POST['is_plaintext'])) {
        foreach ($_POST['is_plaintext'] as $each_check) {
            if ($each_check != null) {
                $decision = "yes";
                break;
            }
        }
    }

	include('db.php');

    $stmt = $mysqli->prepare("INSERT INTO list (details, date_posted, time_posted, is_plaintext) VALUES (?, ?, ?, ?)");
    if($decision=="yes"){
        $stmt->bind_param("ssss", $details, $date, $time, $decision);
    }else{
        $stmt->bind_param("ssss", $escaped, $date, $time, $decision);
    }
    
    $stmt->execute();

    $stmt->close();
    $mysqli->close();

    header("Location: home.php");
    exit();
} else {
    header("Location: home.php");
    exit();
}
?>
