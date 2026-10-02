
<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="loginModalLabel">Login to codingsols account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="partials/_handlelogin.php" method="post">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="loginemail" class="form-label">Email</label>
            <input type="text" class="form-control" name="loginemail" id="loginemail" autocomplete="username" required>
          </div>
          <div class="mb-3">
            <label for="loginpass" class="form-label">Password</label>
            <input type="password" class="form-control" id="loginpass" name="loginpass" autocomplete="current-password" required>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
