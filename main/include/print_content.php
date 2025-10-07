<div id="loadingOverlay" style="
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
">
    <img src="<?=LOCALHOST_BASE?>/assets/img/loader.svg" alt="Cargando..." style="width: 100px; height: 100px;">
</div>

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
<button type="button" onclick="printContent('<?=$register['id_type_question']?>','<?=$register['id']?>','<?=$register['belong_id']?>','<?=$register['baremo_id']?>')" style="margin: 5px;" class="btn btn-primary">IMPRIMIR</button>
            
</div>