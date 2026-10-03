<?php
require_once __DIR__ . '/_init.php';

function header_alert($type, $title, $message)
{
  echo '<div class="alert alert-' . $type . ' alert-dismissible mb-0 fade show" role="alert">
  <strong>' . e($title) . '</strong> ' . e($message) . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

if (($_GET['login'] ?? '') === 'false') {
  header_alert('warning', 'Warning!', 'Check your email and password.');
}
if (($_GET['signupsuccess'] ?? '') === 'false') {
  header_alert('warning', 'Signup failed:', $_GET['error'] ?? 'Try again later.');
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Codingsols</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Top Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
<?php
$result = mysqli_query($con, 'SELECT category_id, category_name FROM categories ORDER BY category_id LIMIT 5');
while ($row = mysqli_fetch_assoc($result)) {
  echo '<li><a class="dropdown-item" href="threadlist.php?id=' . (int) $row['category_id'] . '">' . e($row['category_name']) . '</a></li>';
}
?>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>
<?php if (is_logged_in()): ?>
      <div class="d-flex align-items-center">
        <p class="text-light my-0 mx-2">Welcome <a href="profile.php"><?= e($_SESSION['useremail']) ?></a></p>
        <a href="partials/_logout.php" role="button" class="btn btn-outline-success mx-2">Logout</a>
      </div>
<?php else: ?>
      <button class="btn btn-outline-success mx-2" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
      <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>
<?php endif; ?>
    </div>
  </div>
</nav>
<?php
include __DIR__ . '/_loginmodal.php';
include __DIR__ . '/_signupmodal.php';

if (($_GET['signupsuccess'] ?? '') === 'true') {
  header_alert('success', 'Success!', 'You can log in now.');
}
