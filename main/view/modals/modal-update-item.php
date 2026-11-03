<div class="modal fade" id="updateItemModal" tabindex="-1" aria-labelledby="updateItemModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" id="updateItemForm" method="post" action="update-system.php" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="updateItemModalTitle">Agregar ítem</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="page" value="<?= (int) $currentPage ?>">
                <input type="hidden" name="action" id="updateItemAction" value="create_item">
                <input type="hidden" name="item_id" id="updateItemId" value="">
                <input type="hidden" name="update_id" id="updateItemUpdateId" value="">
                <div class="form-group mb-3">
                    <label for="updateItemName">Detalle</label>
                    <textarea class="form-control" id="updateItemName" name="item_name" rows="4" maxlength="500" required></textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="updateItemImage">Imagen (opcional)</label>
                    <input class="form-control" type="file" id="updateItemImage" name="item_image" accept="image/jpeg,image/png,image/webp,image/gif">
                    <small class="text-muted">JPG, PNG, WEBP o GIF. Máximo 5 MB.</small>
                </div>
                <p class="small text-muted mb-2" id="currentItemImage"></p>
                <div class="form-check d-none" id="removeItemImageContainer">
                    <input class="form-check-input" type="checkbox" id="removeItemImage" name="remove_image" value="1">
                    <label class="form-check-label" for="removeItemImage">Quitar imagen actual</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar ítem</button>
            </div>
        </form>
    </div>
</div>
