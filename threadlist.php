<?php
require_once 'partials/_init.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = mysqli_prepare($con, 'SELECT category_name, category_description FROM categories WHERE category_id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$category = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$category) {
  http_response_code(404);
  exit('Category not found.');
}

$showalert = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_logged_in()) {
  csrf_verify();
  $th_title = trim($_POST['title'] ?? '');
  $th_desc = trim($_POST['desc'] ?? '');
  if ($th_title !== '' && $th_desc !== '') {
    $user_id = current_user_id();
    $stmt = mysqli_prepare($con, 'INSERT INTO threads (thread_title, thread_desc, thread_cat_id, thread_user_id, timestamp) VALUES (?, ?, ?, ?, current_timestamp())');
    mysqli_stmt_bind_param($stmt, 'ssii', $th_title, $th_desc, $id, $user_id);
    mysqli_stmt_execute($stmt);
    $showalert = true;
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($category['category_name']) ?> forum - Codingsols</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    <?php include 'partials/_header.php'; ?>
    <?php if ($showalert): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your thread has been added. Wait for the community to respond.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <div class="container my-4">
      <div class="jumbotron">
        <h1 class="display-4">Welcome to <?= e($category['category_name']) ?> forum</h1>
        <p class="lead mt-4"><?= e($category['category_description']) ?></p>
        <hr class="my-4">
        <?php include 'partials/_rules.php'; ?>
      </div>
    </div>

    <?php if (is_logged_in()): ?>
      <div class="container">
        <h1 class="py-2">Start A Discussion</h1>
        <form action="threadlist.php?id=<?= $id ?>" method="POST">
          <?= csrf_field() ?>
          <div class="form-group">
            <label for="title">Problem Title</label>
            <input type="text" class="form-control" id="title" name="title" maxlength="255" aria-describedby="titleHelp" required>
            <small id="titleHelp" class="form-text text-muted">Keep your title short and crisp as possible.</small>
          </div>
          <div class="form-group">
            <label for="desc">Elaborate Your Problem</label>
            <textarea class="form-control" name="desc" id="desc" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-success mt-3">Submit</button>
        </form>
      </div>
    <?php else: ?>
      <div class="container">
        <p class="lead">Log in to start a discussion.</p>
      </div>
    <?php endif; ?>

    <div class="container my-4 pb-5">
      <h1 class="py-2">Browse Questions</h1>
      <?php
      $stmt = mysqli_prepare($con, 'SELECT t.thread_id, t.thread_title, t.thread_desc, t.timestamp, u.user_email
        FROM threads t LEFT JOIN users u ON u.srno = t.thread_user_id
        WHERE t.thread_cat_id = ? ORDER BY t.timestamp DESC');
      mysqli_stmt_bind_param($stmt, 'i', $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $noresult = true;
      while ($row = mysqli_fetch_assoc($result)) {
        $noresult = false;
        echo '<div class="d-flex my-3">
          <div class="flex-shrink-0">
            <img src="img/user.png" width="40" alt="">
          </div>
          <div class="flex-grow-1 ms-3">
            <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid=' . (int) $row['thread_id'] . '">' . e($row['thread_title']) . '</a></h5>
            <p class="mb-1">' . e($row['thread_desc']) . '</p>
            <p class="fw-bold my-0">Asked by: ' . e($row['user_email'] ?? 'deleted user') . ' at ' . e($row['timestamp']) . '</p>
          </div>
        </div>';
      }
      if ($noresult) {
        echo '<div class="jumbotron jumbotron-fluid">
          <div class="container">
            <h1 class="display-4">No Threads Found</h1>
            <p class="lead">Be the first person to ask the question</p>
          </div>
        </div>';
      }
      ?>
    </div>

    <?php include 'partials/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
