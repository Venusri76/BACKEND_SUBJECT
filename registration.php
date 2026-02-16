<!DOCTYPE html>
<html>
<head>
<title>Insert New User</title>
</head>
<body>
<h1>Insert New User</h1>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<label for="name">Name:</label><br>
<input type="text" id="name" name="name" required><br><br>
<label for="email">Email:</label><br>
<input type="email" id="email" name="email" required><br><br>
<label for="password">Password:</label><br>
<input type="password" id="password" name="password" required><br><br>
<input type="submit" value="Submit">
</form>
</body>
</html>
<?php
require "connect.php";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
// Prepare and bind
$stmt = $con->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $password);
// Execute the query
if ($stmt->execute()) {
echo "New user added successfully!";
} else {
echo "Error: " . $stmt->error;
}
// Close statement
$stmt->close();
}
?>

