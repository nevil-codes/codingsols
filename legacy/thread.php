<?php
require_once 'partials/_init.php';

$id = (int) ($_GET['threadid'] ?? 0);
$stmt = mysqli_prepare($con, 'SELECT t.thread_title, t.thread_desc, u.user_email
  FROM threads t LEFT JOIN users u ON u.srno = t.thread_user_id
  WHERE t.thread_id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$thread = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$thread) {
  http_response_code(404);
  exit('Thread not found.');
}

$showalert = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && is_logged_in()) {
  csrf_verify();
  $comment = trim($_POST['comment'] ?? '');
  if ($comment !== '') {
    $user_id = current_user_id();
    $stmt = mysqli_prepare($con, 'INSERT INTO comments (comment_content, thread_id, comment_by, comment_time) VALUES (?, ?, ?, current_timestamp())');
    mysqli_stmt_bind_param($stmt, 'sii', $comment, $id, $user_id);
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
    <title><?= e($thread['thread_title']) ?> - Codingsols</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
    <?php include 'partials/_header.php'; ?>
    <?php if ($showalert): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your comment has been added.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <div class="container my-4">
      <div class="jumbotron">
        <h1 class="display-4"><?= e($thread['thread_title']) ?></h1>
        <p class="lead mt-4"><?= nl2br(e($thread['thread_desc'])) ?></p>
        <hr class="my-4">
        <?php include 'partials/_rules.php'; ?>
        <p><b>Posted by: <?= e($thread['user_email'] ?? 'deleted user') ?></b></p>
      </div>
    </div>

    <?php if (is_logged_in()): ?>
      <div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <form action="thread.php?threadid=<?= $id ?>" method="POST">
          <?= csrf_field() ?>
          <div class="form-group">
            <label for="comment">Type your comment</label>
            <textarea class="form-control" name="comment" id="comment" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-success mt-3">Post Comment</button>
        </form>
      </div>
    <?php else: ?>
      <div class="container">
        <p class="lead">Log in to post a comment.</p>
      </div>
    <?php endif; ?>

    <div class="container my-4 pb-5">
      <h1 class="py-2">Discussion</h1>
      <?php
      $stmt = mysqli_prepare($con, 'SELECT c.comment_content, c.comment_time, u.user_email
        FROM comments c LEFT JOIN users u ON u.srno = c.comment_by
        WHERE c.thread_id = ? ORDER BY c.comment_time');
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
            <p class="fw-bold my-0">' . e($row['user_email'] ?? 'deleted user') . ' at ' . e($row['comment_time']) . '</p>
            ' . nl2br(e($row['comment_content'])) . '
          </div>
        </div>';
      }
      if ($noresult) {
        echo '<div class="jumbotron jumbotron-fluid">
          <div class="container">
            <h1 class="display-4">No Comments Yet</h1>
            <p class="lead">Be the first person to answer</p>
          </div>
        </div>';
      }
      ?>
    </div>

    <?php include 'partials/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>
