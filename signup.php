<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "pawsitive_match");

if ($conn->connect_error) {
  echo json_encode(['error' => 'Database connection failed']);
  exit();
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirmPassword'] ?? '';

if ($password !== $confirm) {
  echo json_encode(['error' => 'Passwords do not match']);
  exit();
}

// Check if email already exists
$result = $conn->query("SELECT * FROM users WHERE email='$email'");
if ($result->num_rows > 0) {
  echo json_encode(['error' => 'Email already exists']);
  exit();
}

// Handle image upload
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
  $imgName = $_FILES['profile_image']['name'];
  $imgTmp = $_FILES['profile_image']['tmp_name'];
  $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
  $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

  if (!in_array($imgExt, $allowed)) {
    echo json_encode(['error' => 'Invalid image type. Only JPG, PNG, GIF, WEBP allowed.']);
    exit();
  }

  $newFileName = uniqid("IMG_", true) . '.' . $imgExt;
  $uploadPath = 'uploads/' . $newFileName;

  if (!move_uploaded_file($imgTmp, $uploadPath)) {
    echo json_encode(['error' => 'Failed to upload image.']);
    exit();
  }
} else {
  echo json_encode(['error' => 'Profile image is required.']);
  exit();
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$stmt = $conn->prepare("INSERT INTO users (name, email, password, profile_image) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashed, $newFileName);

if ($stmt->execute()) {
  echo json_encode(['success' => 'Account created successfully! Redirecting...']);
} else {
  echo json_encode(['error' => 'Failed to register user']);
}

$stmt->close();
$conn->close();
?>
