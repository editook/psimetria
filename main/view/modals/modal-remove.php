<div class="modal fade" id="modalremove1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Eliminar Registro</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="form-group has-success mg-b-0">
                            Esta seguro que desea eliminar el registro de:
                            <input class="form-control" style="background: papayawhip;" id="id_eliminar" disabled type="text" value="">
                            <p class="text-danger">* Al eliminar este registro no podra restaurarlo.</p>
                            <input type="hidden" id="id_client_remove" name="id_client_remove" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-danger" onclick="eliminarRegistroModal()" type="button">Eliminar</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
            </div>
        </div>
    </div>
</div>
