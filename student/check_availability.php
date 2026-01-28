<?php
require_once('includes/session_security.php');
require_once("includes/config.php");
require_once("includes/security.php");

if (!empty($_POST["cid"])) {
    $cid = (int) $_POST["cid"]; // Cast to integer for safety
    $regid = $_SESSION['login'];

    try {
        // Use prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("SELECT studentRegno FROM courseenrolls WHERE course = :cid AND studentRegno = :regid");
        $stmt->execute(['cid' => $cid, 'regid' => $regid]);
        $count = $stmt->rowCount();

        if ($count > 0) {
            echo "<span style='color:red'> Already Applied for this course.</span>";
            echo "<script>$('#submit').prop('disabled',true);</script>";
        }
    } catch (PDOException $e) {
        error_log("Check enrollment error: " . $e->getMessage());
        echo "<span style='color:red'> An error occurred. Please try again.</span>";
    }
}

if (!empty($_POST["cid"])) {
    $cid = (int) $_POST["cid"];

    try {
        // Check current enrollments using prepared statement
        $stmt = $pdo->prepare("SELECT * FROM courseenrolls WHERE course = :cid");
        $stmt->execute(['cid' => $cid]);
        $count = $stmt->rowCount();

        // Get seat limit
        $stmt2 = $pdo->prepare("SELECT noofSeats FROM course WHERE id = :cid");
        $stmt2->execute(['cid' => $cid]);
        $row = $stmt2->fetch();

        if ($row) {
            $noofseat = $row['noofSeats'];
            if ($count >= $noofseat) {
                echo "<span style='color:red'> Seat not available for this course. All Seats Are full</span>";
                echo "<script>$('#submit').prop('disabled',true);</script>";
            }
        }
    } catch (PDOException $e) {
        error_log("Check availability error: " . $e->getMessage());
        echo "<span style='color:red'> An error occurred. Please try again.</span>";
    }
}
?>