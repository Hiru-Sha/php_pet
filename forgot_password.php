<?php 
header('Content-Type: application/json');

// Connect to the database
$conn = new mysqli("localhost", "root", "", "pawsitive_match");

// Check connection
if ($conn->connect_error) {
  echo json_encode(['error' => 'Database connection failed']);
  exit();
}

$email = trim($_POST['email'] ?? '');

if (empty($email)) {
  echo json_encode(['error' => 'Email is required']);
  exit();
}

// Prepare statement to prevent SQL injection
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the email exists
if ($result->num_rows > 0) {
  // ✅ Email found — simulate password reset step
  echo json_encode(['success' => '✔️ Email verified! Redirecting to reset...']);
} else {
  // ❌ Email not found
  echo json_encode(['error' => '❌ Email not found in our records']);
}

$stmt->close();
$conn->close();
?>
