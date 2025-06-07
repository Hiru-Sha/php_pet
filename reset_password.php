<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "pawsitive_match");

if ($conn->connect_error) {
  echo json_encode(['error' => 'Database connection failed']);
  exit();
}

$email = $_POST['email'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
  echo json_encode(['error' => 'All fields are required']);
  exit();
}

if ($newPassword !== $confirmPassword) {
  echo json_encode(['error' => 'Passwords do not match']);
  exit();
}

// Check if email exists
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  echo json_encode(['error' => 'Email not found']);
  exit();
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
$updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$updateStmt->bind_param("ss", $hashedPassword, $email);

if ($updateStmt->execute()) {
  echo json_encode(['success' => '✔️ Password reset successful! Redirecting...']);
} else {
  echo json_encode(['error' => '❌ Failed to update password']);
}

$stmt->close();
$updateStmt->close();
$conn->close();
?>
