<?php
if (empty($_SESSION['password_csrf'])) {
    $_SESSION['password_csrf'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['password_csrf'];
$iduser    = (int) $_SESSION['REST_id_user'];


?>

<div class="modal fade" id="addEmailModal" tabindex="-1" aria-labelledby="addEmailModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form class="modal-content" method="post" action="register.php">
      <div class="modal-header">
        <h5 class="modal-title" id="addEmailModalTitle">Registrar correo electrónico</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
        <input type="hidden" name="iduser" value="<?= (int) $iduser ?>">
        <input type="hidden" name="add_email" value="">

        <p class="text-danger fs-5 fw-bold mb-3 text-center">
          Para proteger su cuenta le recomendamos registrar su correo.
        </p>

        <label for="newEmail" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="newEmail" name="email" placeholder="ejemplo@correo.com" required>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Registrar</button>
      </div>
    </form>
  </div>
</div>
