<div class="modal fade" id="updateSystemModal" tabindex="-1" aria-labelledby="updateSystemModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" id="updateSystemForm" method="post" action="update-system.php">
            <div class="modal-header">
                <h5 class="modal-title" id="updateSystemModalTitle">Nueva actualización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="page" value="<?= (int) $currentPage ?>">
                <input type="hidden" name="action" id="updateSystemAction" value="create_update">
                <input type="hidden" name="update_id" id="updateSystemId" value="">
                <div class="form-group mb-3">
                    <label for="updateTitleInput">Título</label>
                    <input class="form-control" type="text" id="updateTitleInput" name="title" maxlength="200" required>
                </div>
                <div class="form-group mb-3">
                    <label for="updateDateInput">Fecha</label>
                    <input class="form-control" type="date" id="updateDateInput" name="update_date" value="<?= htmlspecialchars($todayDate) ?>" required>
                </div>
                <div class="form-group">
                    <label for="updateVersionInput">Versión</label>
                    <input class="form-control" type="text" id="updateVersionInput" name="version" maxlength="20" value="<?= htmlspecialchars($defaultVersion) ?>" required>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar actualización</button>
            </div>
        </form>
    </div>
</div>
