<div class="modal fade" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title" id="CreateModalTitle">Creacion de cliente</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="needs-validation was-validated" action="index.php" method="post">
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="form-group has-success mg-b-0">
                                <input type="hidden" id="iduser" name="iduser" value="">
                                <input class="form-control" id="full_name" name="full_name" placeholder="Nombre Completo" required="" type="text" value="">
                                <input class="form-control mg-t-20" id="name_user" name="name_user" placeholder="Usuario" required="" type="text" value="">
                                <input class="form-control mg-t-20" id="password" name="password" placeholder="Contraseña" required="" type="password" value="">
                                <select class="form-control mg-t-20 select2-no-search" id="active" name="active">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit">Guardar Cambios</button>
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
