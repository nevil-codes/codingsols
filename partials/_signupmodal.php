
<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="signupModalLabel">Signup to Codingsols account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="partials/_handleSignup.php" method="post">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label for="signupEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="signupEmail1" name="signupEmail1" maxlength="30" aria-describedby="signupEmailHelp" autocomplete="email" required>
            <div id="signupEmailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="signuppassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="signuppassword" name="signuppassword" minlength="8" autocomplete="new-password" required>
          </div>
          <div class="mb-3">
            <label for="signupcpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="signupcpassword" name="signupcpassword" minlength="8" autocomplete="new-password" required>
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
