<?php
include_once('../configs.php');
$carpetaBase = dirname(__DIR__, 2);

function guardarImagenBase64($base64, $ruta) {
        
    $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
    $base64 = str_replace(' ', '+', $base64);
    $data = base64_decode($base64);

    if ($data === false) {
        return false;
    }

    return file_put_contents($ruta, $data) !== false;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $carpetaBase = dirname(__DIR__, 2);
    $carpeta = $carpetaBase . "/capturas/".$_POST['type_question_id']."/";
    
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }
    
    
    for ($i = 1; $i <= 3; $i++) {
        $campo = "image_contenido{$i}";
        if (!empty($_POST[$campo])) {
            $nombreArchivo = $campo . ".png";
            $rutaArchivo = $carpeta . $nombreArchivo;

            if (guardarImagenBase64($_POST[$campo], $rutaArchivo)) {
                echo "Imagen $i guardada como: $nombreArchivo<br>";
            }
        }
    }
    header("Location: ".LOCALHOST."/view/print.php?documento=".$_POST['type_question_id']);

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $footerImageUrl = LOCALHOST_BASE.'/assets/img/lsb50/image.png';
    $documentoId = $_GET['documento'];
    $carpeta = $carpetaBase . "/capturas/".$documentoId;
    
    $image1 = $carpeta . "/image_contenido1.png";
    $image2 = $carpeta . "/image_contenido2.png";
    $image3 = $carpeta . "/image_contenido3.png";
    $baseUrl = LOCALHOST_BASE . "/capturas/" . $documentoId;
    $image1Url = $baseUrl . "/image_contenido1.png";
    $image2Url = $baseUrl . "/image_contenido2.png";
    $image3Url = $baseUrl . "/image_contenido3.png";
    $html = '
    <html>
        <head>
            <style>
               .page-break {
                    page-break-before: always; /* Fuerza salto de página */
                }
                .img {
                    width: 100%;
                    height: auto;
                }
                .footer {
                    position: relative;
                    bottom: 0;
                    width: 100%;
                    text-align: center;
                }
                .footer img {
                    max-width: 150px; /* Ajusta el tamaño del logo o imagen */
                    height: auto;
                }
            </style>
        </head>
        <body style="text-align: center;margin: 20px;">
            <div class="footer">
                <img src="' . $footerImageUrl . '" alt="Footer">
            </div>
            
            <img class="img" src="' . $image1Url . '" />
            <br><br>
            <img style="width:100%;height:auto;" src="' . $image2Url . '" />

            <div class="page-break"></div>
            <img  class="img" src="' . $image3Url . '" />
            
        </body>
        
    </html>
    ';
    echo $html;
}


?>
<script>
    
    window.print();
</script>