<?php
session_start();

$host = "localhost";
$dbname = "pawsitive_match";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$enteredPassword = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($enteredPassword, $user['password'])) {
        // ✅ Set session data
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['profile_image'] = $user['profile_image']; // added this

        // ✅ Redirect to home page
        header("Location: home.php");
        exit();
    } else {
        header("Location: sign_in.html?message=" . urlencode("❌ Incorrect password!") . "&type=error");
        exit();
    }
} else {
    header("Location: sign_in.html?message=" . urlencode("❌ Email not found!") . "&type=error");
    exit();
}

$stmt->close();
$conn->close();
?>
