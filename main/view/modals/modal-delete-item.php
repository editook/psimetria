<div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" action="update-system.php">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteItemModalTitle">Eliminar ítem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="page" value="<?= (int) $currentPage ?>">
                <input type="hidden" name="action" value="delete_item">
                <input type="hidden" name="item_id" id="deleteItemId" value="">
                <p>¿Confirmas que deseas eliminar este ítem?</p>
                <strong id="deleteItemName"></strong>
                <p class="text-danger mt-2 mb-0">También se eliminará su imagen asociada.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </div>
        </form>
    </div>
</div>
