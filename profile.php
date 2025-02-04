<?php include 'header.php'; ?>
<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone, dob, profile_picture FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $dob = $_POST['dob'];
    $profile_picture = $user['profile_picture']; // Default to existing picture

    // Check if new email is already used by another user
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $check_stmt->bind_param("si", $email, $user_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        header("Location: profile.php?error=Email is already in use.");
        exit();
    }
    $check_stmt->close();

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $profile_picture = $target_dir . basename($_FILES["profile_picture"]["name"]);
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $profile_picture);
    }

    // Update user details
    $update_stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, phone=?, dob=?, profile_picture=? WHERE id=?");
    $update_stmt->bind_param("ssssssi", $first_name, $last_name, $email, $phone, $dob, $profile_picture, $user_id);

    if ($update_stmt->execute()) {
        // Update session variables
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['dob'] = $dob;
        $_SESSION['profile_picture'] = $profile_picture;

        header("Location: profile.php?success=Profile updated successfully!");
        exit();
    } else {
        header("Location: profile.php?error=Something went wrong. Please try again.");
        exit();
    }

    $update_stmt->close();
}

// Handle account deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
    // Delete user from the database
    $delete_stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $delete_stmt->bind_param("i", $user_id);

    if ($delete_stmt->execute()) {
        session_destroy(); // End session
        header("Location: index.php?message=Account deleted successfully.");
        exit();
    } else {
        header("Location: profile.php?error=Failed to delete account.");
        exit();
    }

    $delete_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="flex justify-center items-center h-screen">
        <div class="w-full sm:w-120 md:w-1/2 lg:w-1/3 bg-white p-8 rounded-xl shadow-lg">


            <!-- Profile Picture -->
            <div class="flex justify-center mb-6">
                <img src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : 'default-avatar.png'; ?>" alt="Profile Picture" class="w-32 h-32 rounded-full">
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-indigo-500 text-center mb-6">My Profile</h2>

            <!-- Success & Error Messages -->
            <?php if (isset($_GET['error'])): ?>
                <p class="text-red-500 text-center mb-4"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php elseif (isset($_GET['success'])): ?>
                <p class="text-green-500 text-center mb-4"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php endif; ?>

            <!-- Edit Profile Form -->
            <form action="profile.php" method="POST" enctype="multipart/form-data">

                <!-- First and Last Name (side by side) -->
                <div class="flex space-x-4 mb-4">
                    <div class="w-full">
                        <label for="first_name" class="block text-gray-700 font-medium">First Name:</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div class="w-full">
                        <label for="last_name" class="block text-gray-700 font-medium">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
                    </div>
                </div>

                <!-- Email and Phone Number (side by side) -->
                <div class="flex space-x-4 mb-4">
                    <div class="w-full">
                        <label for="email" class="block text-gray-700 font-medium">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full p-2 mt-2 mb-4 border border-gray-300 rounded-lg" style="min-width: 100%;" required>

                    </div>
                    <div class="w-full">
                        <label for="phone" class="block text-gray-700 font-medium">Phone Number:</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" class="w-full p-2 border border-gray-300 rounded-lg" required>
                    </div>
                </div>

                <!-- Date of Birth -->
                <label for="dob" class="block text-gray-700 font-medium">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" class="w-full p-2 mb-4 border border-gray-300 rounded-lg" required>

                <!-- Profile Picture -->
                <label for="profile_picture" class="block text-gray-700 font-medium">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="w-full p-2 mb-4 border border-gray-300 rounded-lg">

                <!-- Submit Button -->
                <button type="submit" name="update_profile" class="w-full py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition duration-200">Update Profile</button>
            </form>

            <!-- Delete Account Form -->
            <form action="profile.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                <button type="submit" name="delete_account" class="w-full py-2 mt-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">Delete Account</button>
            </form>
        </div>
    </div>

</body>
</html>

<?php include 'footer.php'; ?>
