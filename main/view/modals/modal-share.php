<div class="modal fade" id="modalshare9">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Compartir formulario</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="form-group has-success mg-b-0">
                            <input class="form-control" style="background: papayawhip;" id="input_share_model" name="id_client" type="text" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input class="form-control mb-2" style="width: 150px;" id="input_share_number" type="text" placeholder="Numero">
                <button class="btn ripple btn-primary" onclick="shareWhatsApp()" type="button">Compartir por WhastApp</button>
                <button class="btn ripple btn-secondary" onclick="copiarMensaje()" type="button">Copiar</button>
            </div>
        </div>
    </div>
</div>
