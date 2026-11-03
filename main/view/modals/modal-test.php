<div class="modal fade" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Creacion de Test Psicologico</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="needs-validation was-validated" action="register.php" method="post">
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="form-group has-success mg-b-0">
                                <input type="hidden" id="id" name="id" value="">
                                <input type="hidden" id="belong_id" name="belong_id" value="<?= $idClient ?>">
                                <input class="form-control" id="id_client" name="id_client" placeholder="Nombre Completo" required="" type="text" value="">
                                <input class="form-control mg-t-20" id="age" name="age" placeholder="Edad" required="" type="number" value="">

                                <select class="form-control mg-t-20 select2-no-search" id="sex" name="sex">
                                    <option value="" selected disabled>SEXO</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                    <option value="FEMENINO">FEMENINO</option>
                                </select>

                                <select class="form-control mg-t-20 select2-no-search" id="id_type_question" name="id_type_question">
                                    <option value="" selected disabled>TIPO DE EVALUACION</option>
                                    <?php foreach ($questions as $question): ?>
                                        <option value="<?= $question['id'] ?>">
                                            <?= htmlspecialchars($question['name']) ?> v<?= $question['value_data'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-control mg-t-20 select2-no-search" id="baremo_id" name="baremo_id"></select>
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
