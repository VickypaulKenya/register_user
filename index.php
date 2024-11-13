<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="form-container">
    <form action="form_handler.php" method="POST" class="registration-form">
      <h2>User Registration</h2>
      
      <!-- Username Field -->
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['old']['username'] ?? ''); ?>">
      <?php if (isset($_SESSION['errors']['usernameError'])): ?>
        <p style="color: red;"><?php echo $_SESSION['errors']['usernameError']; ?></p>
      <?php endif; ?>
      
      <!-- Email Field -->
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['old']['email'] ?? ''); ?>">
      <?php if (isset($_SESSION['errors']['emailError'])): ?>
        <p style="color: red;"><?php echo $_SESSION['errors']['emailError']; ?></p>
      <?php endif; ?>
      
      <!-- Password Field -->
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($_SESSION['old']['password'] ?? ''); ?>">
      <?php if (isset($_SESSION['errors']['passwordError'])): ?>
        <p style="color: red;"><?php echo $_SESSION['errors']['passwordError']; ?></p>
      <?php endif; ?>
      
      <!-- Login Link -->
      <span>Already have an account? <a href="login.php">LOG IN</a></span>
      
      <!-- Submit Button -->
      <button type="submit">Register</button>
    </form>
  </div>

  <!-- Clear Session Error and Old Input Data After Displaying -->
  <?php unset($_SESSION['errors'], $_SESSION['old'], $_SESSION["success"]); ?>
</body>
</html>
