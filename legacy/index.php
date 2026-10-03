<?php require_once 'partials/_init.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Codingsols - Coding Forum</title>
    <style>
      #ques{
            min-height: 433px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
<?php include "partials/_header.php"; ?>

<!-- slider -->

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/ing-1.jpeg" class="d-block w-100" alt="">
    </div>
    <div class="carousel-item">
      <img src="img/ing-2.jpeg" class="d-block w-100" alt="">
    </div>
    <div class="carousel-item">
      <img src="img/ing-3.jpeg" class="d-block w-100" alt="">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<!-- category container -->
<div class="container my-4" id="ques">
  <h2 class="text-center mt-3">Welcome to Codingsols</h2>
  <div class="row my-3">
<?php
  $result = mysqli_query($con, 'SELECT category_id, category_name, category_description FROM categories ORDER BY category_id');
  while ($row = mysqli_fetch_assoc($result)) {
    $id = (int) $row['category_id'];
    echo '
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title"><a href="threadlist.php?id=' . $id . '">' . e($row['category_name']) . '</a></h5>
          <p class="card-text">' . e(mb_strimwidth($row['category_description'], 0, 90, '...')) . '</p>
          <a href="threadlist.php?id=' . $id . '" class="btn btn-primary">View Threads</a>
        </div>
      </div>
    </div>';
  }
  ?>
    </div>
</div>


<?php include "partials/_footer.php";?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>