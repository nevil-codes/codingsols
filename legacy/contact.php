<?php
require_once 'partials/_init.php';

$alert = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  csrf_verify();
  $nm = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $comment = trim($_POST['comment'] ?? '');
  if ($nm === '' || $comment === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $alert = ['warning', 'Please fill in your name, a valid email and a message.'];
  } else {
    $stmt = mysqli_prepare($con, 'INSERT INTO contact (name, email, comments, dated) VALUES (?, ?, ?, current_timestamp())');
    mysqli_stmt_bind_param($stmt, 'sss', $nm, $email, $comment);
    mysqli_stmt_execute($stmt);
    $alert = ['success', 'Your response has been submitted successfully.'];
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - Codingsols</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    <?php include 'partials/_header.php'; ?>
    <?php if ($alert): ?>
      <div class="alert alert-<?= $alert[0] ?> alert-dismissible fade show" role="alert">
        <?= e($alert[1]) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <div class="container pb-5">
      <h1 class="display-4 text-center mb-5 mt-5">Contact To CodingSols</h1>
      <form method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" class="form-control" id="name" maxlength="255" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" id="email" maxlength="255" required>
        </div>
        <div>
          <label for="comment" class="form-label">Comments</label>
          <textarea class="form-control" placeholder="Leave a comment here" name="comment" id="comment" required></textarea>
        </div>
        <button type="submit" class="mb-5 mt-4 btn btn-primary">Submit</button>
      </form>
    </div>
    <?php include 'partials/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
