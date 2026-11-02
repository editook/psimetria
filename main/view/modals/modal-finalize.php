<div class="modal fade" id="modalfinalize" tabindex="-1" aria-labelledby="modalfinalizeTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="modalfinalizeTitle">Finalizar registro</h6>
                <button aria-label="Cerrar" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                ¿Confirma que desea finalizar este registro? Su estado cambiará a TERMINADO.
                <p class="text-danger">* Si el cuestionario no fue completado es posible que algunos valores tomen como referencia '0' o VACIO.</p>
            </div>
            <form method="post" action="register.php?client=<?= (int) $idClient ?>">
                <input type="hidden" id="finalize_id" name="finalize_id" value="">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <div class="modal-footer">
                    <button type="button" class="btn ripple btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn ripple btn-success">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
