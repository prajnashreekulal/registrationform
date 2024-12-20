<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $gender = $conn->real_escape_string(trim($_POST['gender']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    $dob = $conn->real_escape_string(trim($_POST['dob']));

    if (empty($name) || empty($email) || empty($phone) || empty($gender) || empty($password) || empty($dob)) {
        die("All fields are required.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, phone, gender, password, dob) VALUES ('$name', '$email', '$phone', '$gender', '$hashedPassword', '$dob')";

    if ($conn->query($sql) === TRUE) {
        echo"
        <div style='
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        min-height: 100vh;
        font-family: Arial, sans-serif;
        text-align: center;
        background: #f9f9f9;
        padding: 20px;
    '>
        <h1 style='color: #4caf50;'>Registration Successful!</h1>
        <div style='
            background: #ffffff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        '>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Gender:</strong> $gender</p>
            <p><strong>Date of Birth:</strong> $dob</p>
        </div>
        <a href='index.html' style='
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        ' onmouseover=\"this.style.backgroundColor='#45a049'\"
        onmouseout=\"this.style.backgroundColor='#4caf50'\">Go Back</a>
    </div>
    ";
    } else {
        echo "Error: " . $sql . "\n" . $conn->error;
    }
}

$conn->close();