<?php
require_once 'partials/_init.php';

if (!is_logged_in()) {
  redirect('index.php');
}

$user_id = current_user_id();
$stmt = mysqli_prepare($con, 'SELECT user_email, timestamp FROM users WHERE srno = ?');
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$user) {
  redirect('partials/_logout.php');
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Profile - Codingsols</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    <?php include 'partials/_header.php'; ?>
    <div class="container mt-5 pb-5">
      <h2 class="mb-4 display-4 text-center">User Profile</h2>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" value="<?= e($user['user_email']) ?>" disabled>
      </div>
      <div class="mb-3">
        <label for="joined" class="form-label">Member since</label>
        <input type="text" class="form-control" id="joined" value="<?= e($user['timestamp']) ?>" disabled>
      </div>
      <p class="text-muted">Profile editing is coming in the next version of Codingsols.</p>
    </div>
    <?php include 'partials/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
