<?php
$mysqli = new mysqli("localhost", "root", "", "faq_chatbot");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mysqli->query("DELETE FROM faqs WHERE id = $id");
}

$mysqli->close();

header("Location: manage.php");
?>
