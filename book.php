<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $conn = new mysqli("localhost", "root", "", "information");
    if ($conn->connect_error) {
        die("Connection failed");
    }

    function clean($data) {
        return htmlspecialchars(trim($data));
    }

    $fullName = clean($_POST['full-name'] ?? '');
    $destination = clean($_POST['destination'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $payement = clean($_POST['payement'] ?? '');
    $departureDate = clean($_POST['departure-date'] ?? '');
    $travelers = clean($_POST['travelers'] ?? '');
    $phone = clean($_POST['phone'] ?? '');
    $notes = clean($_POST['notes'] ?? '');

    if (
        empty($fullName)   ||empty($destination)  || empty($email) ||
        empty($payement)   ||empty($departureDate)  || empty($travelers) || empty($phone)
    ) {
        die("<h3 style='color:red'>Please fill all required fields.</h3>");
    }

    $stmt = $conn->prepare("INSERT INTO form 
    (full_name, destination, email, Payement_method, departure_date, travelers, phone, notes)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssss", 
        $fullName, $destination, $email, $payement,
        $departureDate, $travelers, $phone, $notes
    );

    if ($stmt->execute()) {
        echo "<h3 style='color:green'>Booking saved successfully!</h3>";
        echo "<a href='../index.html'>Return Home</a>";
    } else {
        echo "<h3 style='color:red'>Something went wrong.</h3>";
    }

    $stmt->close();
    $conn->close();
}
?>