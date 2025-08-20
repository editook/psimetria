<div style="position: fixed;
bottom: 20px;
right: 20px;
z-index: 1000;
height: min-content;
width: auto;
background: #0162e8;
color: #fff;
border-radius: 10px;
">
<form action="print.php" method="post" enctype="multipart/form-data" style="padding: 0;margin: 0;" target="_blank">
    <input type="hidden" name="html" id="html">
            <input type="hidden" name="type_question_id" id="type_question_id">
            <input type="hidden" name="image_contenido1" id="image_contenido1">
            <input type="hidden" name="image_contenido2" id="image_contenido2">
            <input type="hidden" name="image_contenido3" id="image_contenido3">
            <button type="button" onclick="printContent('<?=$register['id_type_question']?>','<?=$register['id']?>','<?=$register['belong_id']?>','<?=$register['baremo_id']?>')" style="margin: 5px;" class="btn btn-primary">GENERAR PDF</button>
            <button type="submit" id="sub" style="height: 0px;
            width: 0px;
            padding: 0px;
            margin: 0px;
            visibility: hidden;"></button>

</form>
</div>