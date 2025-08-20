<?php
class ModelMaciConfiguration {
    public function obtenerPdxEspaniol($value) {
        $pdx = [
            ['inicio' => 201, 'fin' => 209, 'valor' => 2],
            ['inicio' => 210, 'fin' => 219, 'valor' => 4],
            ['inicio' => 220, 'fin' => 229, 'valor' => 7],
            ['inicio' => 230, 'fin' => 239, 'valor' => 12],
            ['inicio' => 240, 'fin' => 249, 'valor' => 17],
            ['inicio' => 250, 'fin' => 259, 'valor' => 26],
            ['inicio' => 260, 'fin' => 269, 'valor' => 34],
            ['inicio' => 270, 'fin' => 279, 'valor' => 37],
            ['inicio' => 280, 'fin' => 289, 'valor' => 41],
            ['inicio' => 290, 'fin' => 299, 'valor' => 44],
            ['inicio' => 300, 'fin' => 309, 'valor' => 47],
            ['inicio' => 310, 'fin' => 319, 'valor' => 50],
            ['inicio' => 320, 'fin' => 329, 'valor' => 53],
            ['inicio' => 330, 'fin' => 339, 'valor' => 56],
            ['inicio' => 340, 'fin' => 349, 'valor' => 59],
            ['inicio' => 350, 'fin' => 359, 'valor' => 62],
            ['inicio' => 360, 'fin' => 369, 'valor' => 64],
            ['inicio' => 370, 'fin' => 379, 'valor' => 66],
            ['inicio' => 380, 'fin' => 389, 'valor' => 69],
            ['inicio' => 390, 'fin' => 399, 'valor' => 71],
            ['inicio' => 400, 'fin' => 409, 'valor' => 73],
            ['inicio' => 410, 'fin' => 419, 'valor' => 75],
            ['inicio' => 420, 'fin' => 429, 'valor' => 77],
            ['inicio' => 430, 'fin' => 439, 'valor' => 79],
            ['inicio' => 440, 'fin' => 449, 'valor' => 81],
            ['inicio' => 450, 'fin' => 459, 'valor' => 82],
            ['inicio' => 460, 'fin' => 469, 'valor' => 86],
            ['inicio' => 470, 'fin' => 479, 'valor' => 89],
            ['inicio' => 480, 'fin' => 489, 'valor' => 90],
            ['inicio' => 490, 'fin' => 499, 'valor' => 92],
            ['inicio' => 500, 'fin' => 509, 'valor' => 93],
            ['inicio' => 510, 'fin' => 519, 'valor' => 94],
            ['inicio' => 520, 'fin' => 529, 'valor' => 95],
            ['inicio' => 530, 'fin' => 539, 'valor' => 96],
            ['inicio' => 540, 'fin' => 549, 'valor' => 97],
            ['inicio' => 550, 'fin' => 559, 'valor' => 98],
            ['inicio' => 560, 'fin' => 569, 'valor' => 98],
            ['inicio' => 570, 'fin' => 579, 'valor' => 99],
            ['inicio' => 580, 'fin' => 589, 'valor' => 100],
        ];
        $cantidad = count($pdx);
        $total = 0;
        while($cantidad>0){
            $cantidad--;
            $data = $pdx[$cantidad];//indice
            $subtotal = 0;
            if($value>=$data['inicio'] && $value<=$data['fin']){
                $subtotal = $data['valor'];
            }
            $total = $total + $subtotal;
        }
        return $total;
    }

    public function obtenerPdxAmericano($value) {
        $pdx = [
            ['inicio' => 201, 'fin' => 209, 'valor' => 0],
            ['inicio' => 210, 'fin' => 219, 'valor' => 5],
            ['inicio' => 220, 'fin' => 229, 'valor' => 10],
            ['inicio' => 230, 'fin' => 239, 'valor' => 15],
            ['inicio' => 240, 'fin' => 249, 'valor' => 22],
            ['inicio' => 250, 'fin' => 259, 'valor' => 30],
            ['inicio' => 260, 'fin' => 269, 'valor' => 35],
            ['inicio' => 270, 'fin' => 279, 'valor' => 37],
            ['inicio' => 280, 'fin' => 289, 'valor' => 39],
            ['inicio' => 290, 'fin' => 299, 'valor' => 41],
            ['inicio' => 300, 'fin' => 309, 'valor' => 44],
            ['inicio' => 310, 'fin' => 319, 'valor' => 47],
            ['inicio' => 320, 'fin' => 329, 'valor' => 50],
            ['inicio' => 330, 'fin' => 339, 'valor' => 52],
            ['inicio' => 340, 'fin' => 349, 'valor' => 55],
            ['inicio' => 350, 'fin' => 359, 'valor' => 58],
            ['inicio' => 360, 'fin' => 369, 'valor' => 60],
            ['inicio' => 370, 'fin' => 379, 'valor' => 62],
            ['inicio' => 380, 'fin' => 389, 'valor' => 64],
            ['inicio' => 390, 'fin' => 399, 'valor' => 67],
            ['inicio' => 400, 'fin' => 409, 'valor' => 70],
            ['inicio' => 410, 'fin' => 419, 'valor' => 72],
            ['inicio' => 420, 'fin' => 429, 'valor' => 75],
            ['inicio' => 430, 'fin' => 439, 'valor' => 77],
            ['inicio' => 440, 'fin' => 449, 'valor' => 79],
            ['inicio' => 450, 'fin' => 459, 'valor' => 81],
            ['inicio' => 460, 'fin' => 469, 'valor' => 83],
            ['inicio' => 470, 'fin' => 479, 'valor' => 85],
            ['inicio' => 480, 'fin' => 489, 'valor' => 86],
            ['inicio' => 490, 'fin' => 499, 'valor' => 87],
            ['inicio' => 500, 'fin' => 509, 'valor' => 88],
            ['inicio' => 510, 'fin' => 519, 'valor' => 90],
            ['inicio' => 520, 'fin' => 529, 'valor' => 91],
            ['inicio' => 530, 'fin' => 539, 'valor' => 93],
            ['inicio' => 540, 'fin' => 549, 'valor' => 94],
            ['inicio' => 550, 'fin' => 559, 'valor' => 95],
            ['inicio' => 560, 'fin' => 569, 'valor' => 97],
            ['inicio' => 570, 'fin' => 579, 'valor' => 98],
            ['inicio' => 580, 'fin' => 589, 'valor' => 99],
        ];
        /*$data = $pdx[$index];
        if($value>=$data['inicio'] && $value<=$data['fin']){
            return $data['valor'];
        }*/
        $cantidad = count($pdx);
        $total = 0;
        while($cantidad>0){
            $cantidad--;
            $data = $pdx[$cantidad];//indice
            $subtotal = 0;
            if($value>=$data['inicio'] && $value<=$data['fin']){
                $subtotal = $data['valor'];
            }
            $total = $total + $subtotal;
        }
        return $total;
    }

    public function getRawScoreScaleX($index){
        $pares = [200 => 1000,201 => 25,202 => 25,203 => 24,204 => 24,205 => 24,206 => 23,207 => 23,208 => 23,209 => 22,210 => 22,211 => 22,212 => 21,213 => 21,214 => 21,215 => 20,216 => 20,217 => 20,218 => 19,219 => 19,220 => 19,221 => 18,222 => 18,223 => 18,224 => 17,225 => 17,226 => 17,227 => 16,228 => 16,229 => 16,230 => 15,231 => 15,232 => 15,233 => 14,234 => 14,235 => 14,236 => 13,237 => 13,238 => 13,239 => 12,240 => 12,241 => 12,242 => 11,243 => 11,244 => 11,245 => 10,246 => 10,247 => 10,248 => 9,249 => 9,250 => 9,251 => 8,252 => 8,253 => 8,254 => 7,255 => 7,256 => 7,257 => 6,258 => 6,259 => 6,260 => 5,261 => 5,262 => 5,263 => 4,264 => 4,265 => 4,266 => 4,267 => 4,268 => 4,269 => 2,270 => 2,271 => 2,272 => 1,273 => 1,274 => 1,275 => 0,276 => 0,277 => 0,278 => 0,279 => 0,280 => 0,281 => 0,282 => 0,283 => 0,284 => 0,285 => 0,286 => 0,287 => 0,288 => 0,289 => 0,290 => 0,291 => 0,292 => 0,293 => 0,294 => 0,295 => 0,296 => 0,297 => 0,298 => 0,299 => 0,300 => 0,301 => 0,302 => 0,303 => 0,304 => 0,305 => 0,306 => 0,307 => 0,308 => 0,309 => 0,310 => 0,311 => 0,312 => 0,313 => 0,314 => 0,315 => 0,316 => 0,317 => 0,318 => 0,319 => 0,320 => 0,321 => 0,322 => 0,323 => 0,324 => 0,325 => 0,326 => 0,327 => 0,328 => 0,329 => 0,330 => 0,331 => 0,332 => 0,333 => 0,334 => 0,335 => 0,336 => 0,337 => 0,338 => 0,339 => 0,340 => 0,341 => 0,342 => 0,343 => 0,344 => 0,345 => 0,346 => 0,347 => 0,348 => 0,349 => 0,350 => 0,351 => 0,352 => 0,353 => 0,354 => 0,355 => 0,356 => 0,357 => 0,358 => 0,359 => 0,360 => 0,361 => 0,362 => 0,363 => 0,364 => 0,365 => 0,366 => 0,367 => 0,368 => 0,369 => 0,370 => 0,371 => 0,372 => 0,373 => 0,374 => 0,375 => 0,376 => 0,377 => 0,378 => 0,379 => 0,380 => 0,381 => 0,382 => 0,383 => 0,384 => 0,385 => 0,386 => 0,387 => 0,388 => 0,389 => 0,390 => 0,391 => 0,392 => 0,393 => 0,394 => 0,395 => 0,396 => 0,397 => 0,398 => 0,399 => 0,400 => 0,401 => -1,402 => -1,403 => -1,404 => -1,405 => -1,406 => -1,407 => -1,408 => -1,409 => -2,410 => -2,411 => -2,412 => -2,413 => -2,414 => -2,415 => -2,416 => -2,417 => -3,418 => -3,419 => -3,420 => -3,421 => -3,422 => -3,423 => -3,424 => -3,425 => -4,426 => -4,427 => -4,428 => -4,429 => -4,430 => -4,431 => -4,432 => -4,433 => -5,434 => -5,435 => -5,436 => -5,437 => -5,438 => -5,439 => -5,440 => -5,441 => -6,442 => -6,443 => -6,444 => -6,445 => -6,446 => -6,447 => -6,448 => -6,449 => -7,450 => -7,451 => -7,452 => -7,453 => -7,454 => -7,455 => -7,456 => -7,457 => -8,458 => -8,459 => -8,460 => -8,461 => -8,462 => -8,463 => -8,464 => -8,465 => -9,466 => -9,467 => -9,468 => -9,469 => -9,470 => -9,471 => -9,472 => -9,473 => -10,474 => -10,475 => -10,476 => -10,477 => -10,478 => -10,479 => -10,480 => -10,481 => -11,482 => -11,483 => -11,484 => -11,485 => -11,486 => -11,487 => -11,488 => -11,489 => -12,490 => -12,491 => -12,492 => -12,493 => -12,494 => -12,495 => -12,496 => -12,497 => -13,498 => -13,499 => -13,500 => -13,501 => -13,502 => -13,503 => -13,504 => -13,505 => -14,506 => -14,507 => -14,508 => -14,509 => -14,510 => -14,511 => -14,512 => -14,513 => -15,514 => -15,515 => -15,516 => -15,517 => -15,518 => -15,519 => -15,520 => -15,521 => -16,522 => -16,523 => -16,524 => -16,525 => -16,526 => -16,527 => -16,528 => -16,529 => -17,530 => -17,531 => -17,532 => -17,533 => -17,534 => -17,535 => -17,536 => -17,537 => -18,538 => -18,539 => -18,540 => -18,541 => -18,542 => -18,543 => -18,544 => -18,545 => -19,546 => -19,547 => -19,548 => -19,549 => -19,550 => -19,551 => -19,552 => -19,553 => -20,554 => -20,555 => -20,556 => -20,557 => -20,558 => -20,559 => -20,560 => -20,561 => -21,562 => -21,563 => -21,564 => -21,565 => -21,566 => -21,567 => -21,568 => -21,569 => -22,570 => -22,571 => -22,572 => -22,573 => -22,574 => -22,575 => -22,576 => -22,577 => -23,578 => -23,579 => -23,580 => -23,581 => -23,582 => -23,583 => -23,584 => -23,585 => -24,586 => -24,587 => -24,588 => -24,589 => -24,590 => 1000];
        $value = $pares[$index];

        return $value;
    }

    public function getDifereceYZ($index){
        $pares = [-65 => -7,-64 => -6,-63 => -6,-62 => -6,-61 => -6,-60 => -6,-59 => -6,-58 => -6,-57 => -6,-56 => -6,-55 => -6,-54 => -5,-53 => -5,-52 => -5,-51 => -5,-50 => -5,-49 => -5,-48 => -5,-47 => -5,-46 => -5,-45 => -5,-44 => -4,-43 => -4,-42 => -4,-41 => -4,-40 => -4,-39 => -4,-38 => -4,-37 => -4,-36 => -4,-35 => -4,-34 => -3,-33 => -3,-32 => -3,-31 => -3,-30 => -3,-29 => -3,-28 => -3,-27 => -3,-26 => -3,-25 => -3,-24 => -2,-23 => -2,-22 => -2,-21 => -2,-20 => -2,-19 => -2,-18 => -2,-17 => -2,-16 => -2,-15 => -2,-14 => -1,-13 => -1,-12 => -1,-11 => -1,-10 => -1,-9 => -1,-8 => -1,-7 => -1,-6 => -1,-5 => -1,-4 => 0,-3 => 0,-2 => 0,-1 => 0,0 => 0,1 => 0,2 => 0,3 => 0,4 => 0,5 => 1,6 => 1,7 => 1,8 => 1,9 => 1,10 => 1,11 => 1,12 => 1,13 => 1,14 => 2,15 => 2,16 => 2,17 => 2,18 => 2,19 => 2,20 => 2,21 => 2,22 => 2,23 => 2,24 => 2,25 => 3,26 => 3,27 => 3,28 => 3,29 => 3,30 => 3,31 => 3,32 => 3,33 => 3,34 => 3,35 => 4,36 => 4,37 => 4,38 => 4,39 => 4,40 => 4,41 => 4,42 => 4,43 => 4,44 => 4,45 => 5,46 => 5,47 => 5,48 => 5,49 => 5,50 => 5,51 => 5,52 => 5,53 => 5,54 => 5,55 => 6,56 => 6,57 => 6,58 => 6,59 => 6,60 => 6,61 => 6,62 => 6,63 => 6,64 => 6,65 => 7];
        $value = $pares[$index];

        return $value;
    }

    public function getSettingAD($index){
        if($index == 0){
            return 0;
        }
        $pares = [1 => 1,2 => 1,3 => 2,4 => 3,5 => 4,6 => 4,7 => 5,8 => 6,9 => 7,10 => 7,11 => 8,12 => 9,13 => 10,14 => 10,15 => 11,16 => 12,17 => 13,18 => 13,19 => 14,20 => 15];
        $value = $pares[$index];
        return $value;
    }
    //prototipos de personalidad
    public function getPrototipoPersonalidad($except_array,$introversion,$inhibido,$pesimista,$sumiso,$histrionico,$egocentrico,$rebelde,$rudo,$conformista,$oposicionista,$autopunitivo){
        $array = [
            ["llave" => "Introversión", "total" => $introversion, "valor" => 0],
            ["llave" => "Inhibido", "total" => $inhibido, "valor" => -4],
            ["llave" => "Pesimista", "total" => $pesimista, "valor" => -4],
            ["llave" => "Sumiso", "total" => $sumiso, "valor" => 0],
            ["llave" => "Histriónico", "total" => $histrionico, "valor" => 4],
            ["llave" => "Egocéntrico", "total" => $egocentrico, "valor" => 4],
            ["llave" => "Rebelde", "total" => $rebelde, "valor" => 0],
            ["llave" => "Rudo", "total" => $rudo, "valor" => 0],
            ["llave" => "Conformista", "total" => $conformista, "valor" => 4],
            ["llave" => "Oposicionista", "total" => $oposicionista, "valor" => 0],
            ["llave" => "Autopunitivo", "total" => $autopunitivo, "valor" => -4]
        ];

        $maxTotal = -1;
        $valorMaximo = 0;//return
        $selected = null;
        foreach ($array as $item) {
            if ($item['total'] > $maxTotal && !in_array($item['llave'], $except_array)) {// 
                $maxTotal = $item['total'];
                $valorMaximo = $item['valor'];
                $selected = $item;
            }
        }
        
        return $selected;
    }

    public function getPersonalidadPP($texto){
        $descripciones = [
            "Introversión" => "Evalúa la tendencia a ser apático, indiferente, distante y suelen ser reservados, mostrándose bastante tranquilos y poco emotivos. Suelen ser apáticos, indiferentes, distantes y poco sociables",
            "Inhibido" => "Mide la tendencia a ser bastante vergonzosos o a sentirse incómodos en las relaciones con los otros. A estas personas les gustaría la proximidad de los otros pero han aprendido que es mejor mantener su propia distancia y no confiar en la amistad de otros",
            "Pesimista" => "Evalúa la tendencia a sentirse abatidos y desanimados, a veces desde la infancia. Tienen una perspectiva vital pesimista, ven el futuro como algo amenazador y triste",
            "Sumiso" => "Evalúa la tendencia a comportamientos de ser bondadosos, sentimentales y amables en sus relaciones con los demás. Sin embargo, son extremadamente renuentes a imponerse y evitan tomar la iniciativa o asumir el rol de líder",
            "Histriónico" => "Evalúa la tendencia a ser hablador, socialmente encantador y emocionalmente expresivo. Los adolescentes con puntuaciones altas suelen mantener relaciones intensas pero breves, buscan experiencias excitantes y nuevas formas de estimulación, aburridos fácilmente con la rutina",
            "Egocéntrico" => "Mide la propensión a estar seguro de las propias capacidades y ser percibido como narcisista. Los adolescentes con puntuaciones elevadas raramente dudan de su propio valor, actúan con confianza en sí mismos y pueden ser arrogantes y explotadores",
            "Rebelde" => "Evalúa la tendencia a actuar de forma antisocial antisociales y desafiantes, frecuentemente se resisten a los esfuerzos que se hacen para que se comporten de acuerdo con las normas socialmente aceptadas",
            "Rudo" => "Mide la propensión a ser duro, obstinado y dominante. Los adolescentes con puntuaciones elevadas tienden a abusar de los otros, cuestionar los derechos ajenos y preferir asumir el control en la mayoría de las situaciones",
            "Conformista" => "Evalúa la tendencia a ser formal, eficiente, respetuoso y consciente de las normas. Los adolescentes con puntuaciones altas intentan hacer lo «correcto» y lo «adecuado», contienen sus emociones y son muy controlados y tensos",
            "Oposicionista" => "Evalúa la tendencia a comportamientos descontentos, hoscos y pasivo-agresivos",
            "Autopunitivo" => "Evalúa la tendencia a comportamientos autodestructivos. En esta escala suelen ser sus peores enemigos, actúan de forma lesiva para ellos mismos y, a veces, dan la sensación de que están contentos de sufrir",
            "Tendencia límite" => "Mide la inestabilidad emocional significativa, con fluctuaciones en el estado de ánimo, dificultades en la identidad y comportamientos autodestructivos"
        ];
        
        return "(".($descripciones[$texto] ?? "NA")."). ";
    }

    public function getPersonalidadPPInterpretacion($texto,$introversion,$inhibido,$pesimista,$sumiso,$histrionico,$egocentrico,$rebelde,$rudo,$conformista,$oposicionista,$autopunitivo){
        
        $l18 = $introversion;
        $result_introversion = "Sin datos suficientes para evaluar.";
        if ($l18 <= 60) {
            $result_introversion = "indica que no presenta o presenta en grado mínimo rasgos de personalidad introvertida.";
        } elseif ($l18 <= 74) {
            $result_introversion = "indica que se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente una característica predominante o un factor de riesgo en el funcionamiento general. En estos casos, puede manifestar ciertos rasgos de reserva y desapego, pero sin que interfieran significativamente en su adaptación al entorno.";
        } elseif ($l18 <= 84) {
            $result_introversion = "indica que el patrón de personalidad introvertido se encuentra presente de manera más definida, aunque sin ser el rasgo predominante en su configuración psicológica. En estos casos, se observa una tendencia a la apatía y a la indiferencia afectiva, con una reducida implicación emocional en sus relaciones interpersonales y actividades cotidianas. Tiende a mantener un comportamiento reservado y poco expresivo, sin que ello implique una evitación activa de los demás, sino más bien una falta de interés o necesidad de vinculación social significativa.";
        } elseif ($l18 >= 85) {
            $result_introversion = "indica que la expresión del prototipo de personalidad introvertido se torna destacada o prominente. En este nivel, se manifiesta una actitud de desapego e indiferencia emocional de manera persistente, con una reducida capacidad para experimentar tanto la alegría como la tristeza con intensidad. Su comportamiento se caracteriza por la distancia afectiva y la ausencia de deseo por establecer vínculos cercanos o significativos. No se trata de una evitación social motivada por ansiedad o incomodidad, sino de una actitud pasiva frente a la interacción humana. Su implicación en las relaciones interpersonales es mínima, funcionando más como un observador de su entorno que como un participante activo. Las necesidades emocionales y afectivas son escasas, lo que se traduce en una notable falta de expresividad emocional y una ausencia de motivación para involucrarse en dinámicas sociales o afectivas. Este patrón de personalidad guarda similitudes con la personalidad esquizoide descrita en el DSM, destacando la tendencia a la indiferencia emocional y la limitada respuesta ante estímulos afectivos y sociales. Su mundo interno se mantiene distante de las experiencias interpersonales, con una notable falta de implicación en las relaciones humanas y una actitud caracterizada por la neutralidad afectiva y la ausencia de búsqueda de gratificación social.";
        }

        $l19 = $inhibido;
        $result_inhibido = "Sin datos suficientes para evaluar.";
        if ($l19 <= 60) {
            $result_inhibido = "indica que en este rango, las características asociadas al prototipo Inhibido se consideran ausentes o no significativas.";
        } elseif ($l19 <= 74) {
            $result_inhibido = "se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o un factor que afecte significativamente el funcionamiento social y emocional. En estos casos, puede mostrar cierta cautela en las interacciones interpersonales y cierta reserva emocional, pero sin que esto limite de manera importante su capacidad de relacionarse con los demás.";
        } elseif ($l19 <= 84) {
            $result_inhibido = "indica que se encuentra presente de manera más definida, aunque sin ser el rasgo predominante en su configuración psicológica. En estos casos, se observa una tendencia a evitar el contacto social cercano debido a una marcada inseguridad personal. A pesar de que existe un deseo de proximidad con los demás, este suele verse obstaculizado por experiencias previas que han reforzado la idea de que mantener distancia es la mejor forma de evitar el rechazo. Es común que evite compartir sus pensamientos o emociones más profundas, prefiriendo mantener sus sentimientos en reserva para evitar la posibilidad de ser juzgado o rechazado.";
        } elseif ($l19 >= 85) {
            $result_inhibido = "la expresión del prototipo de personalidad inhibido se torna destacada o prominente. En este nivel, se manifiesta una marcada timidez y una gran incomodidad en situaciones sociales, lo que genera una tendencia persistente al aislamiento y a la evitación. A pesar del deseo de establecer vínculos cercanos, el temor al rechazo y la falta de confianza en la aceptación de los demás generan una barrera para la interacción social. Su comportamiento está caracterizado por una notable autocontención emocional, manteniendo un alto grado de reserva en cuanto a sus pensamientos y sentimientos personales. Tiende a experimentar un sentido de soledad, pero evita activamente la cercanía.";
        }
        
        $l20 = $pesimista;
        $result_pesimista = "Sin datos suficientes para evaluar.";
        if ($l20 <= 60) {
            $result_pesimista = "indica una actitud generalmente optimista o realista ante la vida. En este rango pueden no mostrar las características típicas asociadas con el pesimismo o la depresión.";
        } elseif ($l20 <= 74) {
            $result_pesimista = "indica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o un factor que afecte significativamente su funcionamiento. En estos casos, puede experimentar ocasionales momentos de negatividad o inseguridad, pero sin que ello configure una perspectiva global persistentemente pesimista.";
        } elseif ($l20 <= 84) {
            $result_pesimista = "indica que el patrón de personalidad pesimista se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. Se observa una tendencia a percibir el futuro con incertidumbre y desconfianza, con una predisposición a experimentar sentimientos de abatimiento. La autopercepción suele estar marcada por la duda sobre sus propias capacidades y un sentido recurrente de inadecuación.";
        } elseif ($l20 >= 85) {
            $result_pesimista = "indica que el prototipo de personalidad pesimista se torna destacada o prominente. En este nivel, se observa una visión negativa del mundo y de sí mismo, con una tendencia persistente a experimentar tristeza. La perspectiva del futuro se configura como amenazante y sin esperanza, dificultando experimentar experiencias gratificantes. Su autoevaluación suele estar dominada por sentimientos de culpa y remordimiento, lo que refuerza una imagen personal de inadecuación y un sentido de inutilidad. Este patrón de personalidad comparte características con la personalidad depresiva descrita en el DSM IV.";
        }

        $l21 = $sumiso;
        $result_sumiso = "Sin datos suficientes para evaluar.";
        if ($l21 <= 60) {
            $result_sumiso = "indica que tiene una menor propensión a la sumisión y dependencia. Aunque puede haber momentos en que prefiera la aprobación externa o muestre cierta reticencia a tomar la iniciativa, estas no son características predominantes. Puede mostrar una mezcla equilibrada de dependencia y autonomía, capaz de actuar independientemente cuando es necesario, aunque todavía pueda evitar situaciones de alto conflicto o liderazgo en contextos más desafiantes.";
        } elseif ($l21 <= 74) {
            $result_sumiso = "se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o un factor que afecte significativamente su funcionamiento interpersonal. En estos casos, puede mostrar una tendencia a la cooperación y a evitar la imposición de sus deseos sobre los demás, pero sin que esto implique una dependencia marcada o una dificultad significativa para asumir la iniciativa.";
        } elseif ($l21 <= 84) {
            $result_sumiso = "el patrón de personalidad sumiso se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. Se observa una marcada tendencia a evitar situaciones en las que se requiera liderazgo o toma de decisiones, prefiriendo adoptar un rol secundario en las interacciones sociales. Es común que busque la aprobación de los demás y que minimice sus logros personales, mostrando una autoevaluación caracterizada por la modestia y la subestimación de sus propias capacidades. Su actitud es dependiente, con una inclinación a mantener relaciones en las que la seguridad emocional provenga de figuras externas.";
        } elseif ($l21 >= 85) {
            $result_sumiso = "la expresión del prototipo de personalidad sumiso se torna destacada o prominente. En este nivel, el comportamiento se caracteriza por una renuencia a asumir cualquier tipo de autoridad o liderazgo, mostrando una fuerte dependencia emocional en sus relaciones interpersonales. Su actitud refleja una necesidad constante de apoyo y validación, con un temor significativo a la separación o al rechazo. La tendencia a la autodevaluación es persistente, minimizando sus propias habilidades. Su estilo interpersonal está marcado por la complacencia y la evitación de cualquier tipo de conflicto, con una predisposición a subyugar sus propias necesidades para mantener la armonía en sus relaciones cercanas. Este patrón de personalidad guarda similitudes con la personalidad dependiente descrita en el DSM, en la medida en que el individuo ha aprendido a vincular su sensación de seguridad y bienestar con la aceptación y el apoyo constante de los demás.";
        }

        $result_histrionico = "Sin datos suficientes para evaluar.";
        
        $l22 = $histrionico;
        if ($l22 <= 60) {
            $result_histrionico= $mensaje = "Indica una baja presencia de rasgos histriónicos. En este rango, no busca activamente la "
             . "atención o la aprobación de otros mediante la expresividad emocional o el comportamiento exhibicionista. "
             . "Pueden tener relaciones más estables y menos dependientes de la validación externa.";

        } elseif ($l22 <= 74) {
            $result_histrionico= "Se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante "
             . "o que afecte significativamente su funcionamiento social y emocional. En estos casos, puede manifestar un comportamiento "
             . "sociable y comunicativo, con cierta inclinación por la expresividad emocional y la interacción dinámica con los demás, "
             . "pero sin que esto configure una necesidad constante de atención.";

        } elseif ($l22 <= 84) {
            $result_histrionico=  "El patrón de personalidad histriónico se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. "
             . "Se observa una tendencia a ser conversador y expresivo en su forma de interactuar. Tiende a establecer relaciones de manera rápida y "
             . "con gran intensidad, aunque estas suelen ser breves debido a su constante búsqueda de novedad y estimulación. "
             . "Se aburre con facilidad cuando las situaciones o las relaciones se tornan rutinarias, por lo que busca experiencias nuevas.";

        } elseif ($l22 >= 85) {
            $result_histrionico= $mensaje = "La expresión del prototipo de personalidad histriónico se torna destacada o prominente. En este nivel, exhibe un comportamiento "
             . "expresivo y necesita mantenerse en entornos donde la atención sea constante. Su estilo de interacción está caracterizado por un deseo "
             . "persistente de captar el interés de los demás. Tiende a dramatizar sus emociones, mostrando una reactividad emocional intensa en distintas situaciones. "
             . "Este patrón de personalidad guarda paralelismo con el trastorno histriónico de la personalidad descrito en el DSM, en la medida en que se orienta hacia la "
             . "interacción social con un estilo expresivo, buscando continuamente experiencias que mantengan su interés y evitando la estabilidad o la rutina en sus relaciones "
             . "interpersonales. Está definido por una alta intensidad y dramatismo, con una necesidad constante de atención.";

        }
        
        $result_egocentrico = "Sin datos suficientes para evaluar.";
        $l23 = $egocentrico;
        if ($l23 <= 60) {
            $result_egocentrico = "indica una baja presencia de rasgos egocéntricos o narcisistas. En este rango probablemente muestra una consideración equilibrada por los demás y una autoestima saludable que no se inclina hacia la autovaloración excesiva o la explotación de otros.";
        } elseif ($l23 <= 74) {
            $result_egocentrico = "se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o que afecte significativamente su funcionamiento. En estos casos, puede mostrarse seguro de sí mismo y con un sentido de autoestima elevado, pero sin que esto implique una actitud arrogante o explotadora en sus relaciones interpersonales.";
        } elseif ($l23 <= 84) {
            $result_egocentrico = "el patrón de personalidad egocéntrico se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. Se observa una tendencia a actuar con confianza en sí mismo y una baja disposición a cuestionar su propio valor. Su comportamiento suele percibirse como pretencioso o centrado en sus propios intereses, con una limitada preocupación por las necesidades ajenas. Aunque acepta y busca elogios de los demás, su autoestima no depende de una validación externa constante, ya que mantiene una actitud de superioridad con independencia del reconocimiento social real.";
        } elseif ($l23 >= 85) {
            $result_egocentrico = "la expresión del prototipo de personalidad egocéntrico se torna destacada o prominente. En este nivel, se muestra notablemente arrogante y exhibe una confianza en sí mismo que rara vez admite dudas o cuestionamientos. Su comportamiento se caracteriza por una actitud de superioridad, donde la percepción de su propio valor es elevada, incluso en ausencia de logros objetivos que la respalden. Su interacción con los demás tiende a ser utilitaria, mostrando una baja consideración por las necesidades o sentimientos ajenos. Puede adoptar una postura explotadora en sus relaciones interpersonales, buscando obtener beneficios personales sin reflexionar demasiado sobre el impacto en los otros. Su aire de esnobismo y autosuficiencia minimiza la necesidad de confirmación externa, ya que la creencia en su propia valía es interna y persistente. Este patrón de personalidad mantiene un paralelismo con la personalidad narcisista descrita en el DSM, en la medida en que exhibe un sentido de grandiosidad y una autoimagen inflada que se sostiene con independencia de la validación social genuina. Su actitud se basa en la convicción de que su posición y capacidades lo distinguen del resto, lo que se traduce en un estilo interpersonal marcado por la arrogancia y una limitada empatía hacia los demás.";
        }
        
        $result_rebelde = "Sin datos suficientes para evaluar.";
        $l24 = $rebelde;
        if ($l24 <= 60) {
            $result_rebelde = "indica una baja presencia de comportamientos y actitudes rebeldes. En este rango, probablemente se ajusta a las normas sociales y legales y muestra un respeto general por las autoridades y las reglas establecidas.";
        } elseif ($l24 <= 74) {
            $result_rebelde = "se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o que afecte significativamente su comportamiento. En estos casos, puede mostrar cierta resistencia a la autoridad y una actitud independiente, pero sin que esto implique un patrón consistente de conducta desafiante o antisocial.";
        } elseif ($l24 <= 84) {
            $result_rebelde = "el patrón de personalidad rebelde se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. Se observa una tendencia a resistirse a las normas y a desafiar la autoridad de figuras paternas, educativas o institucionales. La actitud se caracteriza por un comportamiento provocador y un rechazo a las restricciones impuestas por otros. Puede presentar dificultades en la adaptación a estructuras jerárquicas, mostrando una disposición a la confrontación cuando percibe que sus deseos o decisiones están siendo limitados. Aunque esta conducta no alcanza niveles extremos, sí está presente de manera recurrente en su interacción con el entorno.";
        } elseif ($l24 >= 85) {
            $result_rebelde = "la expresión del prototipo de personalidad rebelde se torna destacada o prominente. En este nivel, el comportamiento se define por una marcada resistencia a ajustarse a las normas socialmente aceptadas y una tendencia a involucrarse en conflictos con figuras de autoridad, como padres, docentes o incluso instancias legales. Su actitud se caracteriza por una disposición hostil y desafiante, con una inclinación a desafiar activamente cualquier intento de control externo. Puede manifestar comportamientos tramposos o manipuladores como una forma de obtener ventaja en sus relaciones interpersonales o para evitar consecuencias adversas. Además, es común que adopte un estilo de interacción marcado por la desconfianza y el resentimiento, asumiendo que los demás actúan con engaño o desprecio, lo que lo lleva a responder con actitudes defensivas o agresivas. Este patrón de personalidad guarda similitudes con el trastorno antisocial de la personalidad descrito en el DSM, en la medida en que no solo desafía la autoridad y las normas, sino que también puede involucrarse en conductas ilegales o perjudiciales con la intención de obtener un beneficio personal o de desafiar activamente las reglas establecidas. Su comportamiento refleja un estilo de afrontamiento basado en la oposición y el desafío, manteniendo una actitud de enfrentamiento constante con el entorno.";
        }
        
        $result_rudo = "Sin datos suficientes para evaluar.";
        $l25 = $rudo;
        if ($l25 <= 60) {
            $result_rudo = "indica que en este rango, las características asociadas al prototipo Rudo se consideran ausentes o no significativas. No se observan tendencias marcadas hacia la dureza, obstinación o dominación de otros. No muestra inclinación a cuestionar los derechos de los demás o a asumir el control en la mayoría de las situaciones.";
        } elseif ($l25 <= 74) {
            $result_rudo = "se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o que afecte significativamente su interacción con los demás. En estos casos, puede manifestar cierta firmeza y actitud directa en sus relaciones, pero sin que esto implique un comportamiento hostil o abusivo.";
        } elseif ($l25 <= 84) {
            $result_rudo = "el patrón de personalidad rudo se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. Se observa una tendencia a imponerse sobre los demás y a cuestionar sus derechos, mostrando poca tolerancia hacia las debilidades ajenas. Su estilo de interacción tiende a ser directo y poco considerado, con una baja disposición a la empatía o a la comprensión de las dificultades de los demás. Prefiere asumir el control en la mayoría de las situaciones y puede mostrarse impaciente ante aquellos que percibe como menos capaces o vulnerables. Aunque estas características no alcanzan un nivel extremo, están presentes de manera recurrente en su forma de relacionarse con los otros.";
        } elseif ($l25 >= 85) {
            $result_rudo = "la expresión del prototipo de personalidad rudo se torna destacada o prominente. En este nivel, exhibe un comportamiento marcadamente dominante y hostil, con una inclinación persistente a subyugar a los demás y a imponer su voluntad sin consideración por sus derechos o sentimientos. Su actitud se caracteriza por la falta de amabilidad y una notable impaciencia ante cualquier muestra de vulnerabilidad o debilidad en los otros. La interacción con su entorno suele estar mediada por la intimidación y el control, mostrando una tendencia a desestimar las necesidades ajenas en favor de su propio dominio. Es común que adopte un estilo interpersonal basado en la imposición, la dureza y el desprecio hacia aquellos que considera inferiores o incapaces. Este patrón de personalidad guarda similitudes con el trastorno sádico descrito en el DSM, en la medida en que parece encontrar placer o satisfacción en ejercer control mediante la imposición de estrés, temor o crueldad en sus relaciones interpersonales. Su forma de interacción se basa en una inversión del principio dolor-placer, considerando la dominación y la dureza como la vía preferida para relacionarse con los demás. Su conducta refleja una orientación al poder y al sometimiento de los otros, estableciendo dinámicas interpersonales donde la imposición y el abuso pueden estar presentes de manera consistente.";
        } 
        $result_conformista = "Sin datos suficientes para evaluar.";
        $l26 = $conformista;
        if ($l26 <= 60) {
            $result_conformista = "indica que no muestra una tendencia de patrón de personalidad de conformista.";
        } elseif ($l26 <= 74) {
            $result_conformista = "indica presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o que afecte significativamente su funcionamiento. En estos casos, tiende a ser organizado y responsable, con una inclinación por seguir reglas y mantener un estilo de vida estructurado, sin que esto limite su flexibilidad o adaptación a situaciones imprevistas.";
        } elseif ($l26 <= 84) {
            $result_conformista = "el patrón de personalidad conformista se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. Se observa una tendencia a cumplir estrictamente con normas y expectativas, evitando cualquier desviación de lo que se considera correcto o adecuado. Su estilo de vida se caracteriza por la planificación meticulosa y el rechazo a la incertidumbre, lo que puede generar un alto grado de control sobre sus propias emociones y comportamientos. Su actitud es predominantemente reservada y cautelosa, con una marcada necesidad de orden y predictibilidad en su entorno. Aunque no se manifiesta de manera extrema, la autoexigencia y la contención emocional son aspectos notables de su personalidad.";
        } elseif ($l26 >= 85) {
            $result_conformista = "indica que la expresión del prototipo de personalidad conformista se torna destacada o prominente. En este nivel, exhibe un comportamiento rígidamente controlado, con una marcada preocupación por hacer lo correcto y ajustarse a las expectativas sociales. Su actitud se define por una estricta disciplina y un esfuerzo constante por evitar cualquier situación que implique incertidumbre o improvisación. Su necesidad de estructura lo lleva a establecer demandas elevadas para sí mismo, lo que puede generar un alto nivel de tensión interna. Aunque en apariencia es obediente y sumamente responsable, este patrón de personalidad también está acompañado de una intensa represión emocional, derivada de un conflicto interno entre la rabia reprimida y el temor a la vergüenza, la culpa o la desaprobación social. Este perfil de personalidad guarda similitudes con el trastorno obsesivo-compulsivo de la personalidad descrito en el DSM, en la medida en que enfrenta un conflicto entre la necesidad de control y una oposición interna reprimida. La conformidad extrema y la autoimposición de estándares rigurosos actúan como mecanismos para mantener contenida cualquier expresión de descontento o resentimiento. La vacilación, la duda y la tendencia a la pasividad en ciertas situaciones son reflejo de la lucha interna entre la necesidad de orden y la presencia de deseos ocultos de oposición, que rara vez son expresados de manera abierta.";
        }
        
        $result_oposicionista = "Sin datos suficientes para evaluar.";
        $l27 = $oposicionista;
        if ($l27 <= 60) {
            $result_oposicionista = "indica que una baja incidencia de comportamiento oposicionista, indicando que generalmente cumple con las expectativas sin mostrar resistencia significativa o negativismo hacia los demás.";
        } elseif ($l27 <= 74) {
            $result_oposicionista = "se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o que afecte significativamente su interacción con el entorno. En estos casos, puede manifestar ocasionales episodios de irritabilidad o descontento, pero sin que esto configure un patrón persistente de negativismo o conducta desafiante.";
        } elseif ($l27 <= 84) {
            $result_oposicionista = "el patrón de personalidad oposicionista se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. Se observa una tendencia a experimentar cambios repentinos en el estado de ánimo, con momentos en los que puede mostrarse extrovertido y agradable, seguidos de episodios de hostilidad e irritabilidad. Su comportamiento es impredecible, alternando entre el cumplimiento de las expectativas de los demás y la resistencia pasiva a la autoridad. Aunque experimenta sentimientos intensos de culpa y descontento consigo mismo.";
        } elseif ($l27 >= 85) {
            $result_oposicionista = "la expresión del prototipo de personalidad oposicionista se torna destacada o prominente. En este nivel, el comportamiento se caracteriza por una marcada ambivalencia en las relaciones interpersonales y una actitud negativista persistente. Su estilo de interacción se define por una resistencia a someterse a las expectativas de los demás, al mismo tiempo que experimenta sentimientos de culpa y autodesaprobación por no cumplir con lo que se espera de él. La expresión emocional es errática, con una alternancia entre la conformidad aparente y una oposición desafiante, lo que genera dificultades en la estabilidad de sus vínculos interpersonales. Su patrón de comportamiento refleja una lucha constante entre el deseo de aceptación y la necesidad de autonomía, lo que da lugar a reacciones impredecibles y a una dificultad para regular la expresión de su malestar. Este perfil de personalidad guarda similitudes con la personalidad pasivo-agresiva del DSM-III y con la personalidad negativista del DSM-IV, en la medida en que oscila entre la obediencia y la resistencia, sin lograr resolver la ambivalencia en su conducta. Su patrón de funcionamiento está definido por una trayectoria errática, caracterizada por el descontento con los demás y consigo mismo, expresando una combinación de autocrítica y terco negativismo. Su relación con el entorno se desarrolla a través de la oposición indirecta, manifestando una resistencia a las demandas externas mientras experimenta una fuerte insatisfacción interna.";
        }
        
        $result_autopunitivo = "Sin datos suficientes para evaluar.";
        $l28 = $autopunitivo;
        if ($l28 <= 60) {
            $result_autopunitivo = "indica una baja incidencia de comportamiento autopunitivo.";
        } elseif ($l28 <= 74) {
            $result_autopunitivo = "se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o que afecte significativamente su funcionamiento. En estos casos, puede mostrar cierta tendencia a minimizar sus logros o a desvalorizarse en algunas situaciones, pero sin que esto configure un patrón persistente de autosabotaje o autodestrucción.";
        } elseif ($l28 <= 84) {
            $result_autopunitivo = "indica que el patrón de personalidad autopunitivo se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. Se observa una tendencia a socavar los propios esfuerzos y a negar el disfrute de experiencias positivas. Su relación con los demás suele estar marcada por la sumisión y la complacencia excesiva, facilitando que otros se aprovechen de su disposición a priorizar las necesidades ajenas sobre las propias. Es común que enfatice sus aspectos negativos y se coloque en una posición de inferioridad, lo que contribuye a un ciclo de autoevaluación negativa y desvalorización personal.";
        } elseif ($l28 >= 85) {
            $result_autopunitivo = "la expresión del prototipo de personalidad autopunitivo se torna destacada o prominente. En este nivel, actúa de manera sistemáticamente perjudicial para sí mismo, mostrando una actitud de resignación ante el sufrimiento y una disposición a aceptar el dolor como parte central de su experiencia emocional. Su conducta se caracteriza por el autosabotaje constante, evitando activamente el éxito o las experiencias gratificantes y convirtiendo las circunstancias favorables en nuevas fuentes de angustia. Su estilo interpersonal se basa en la sumisión, permitiendo o incluso propiciando que otros lo exploten o lo humillen. Suele recordar y revivir episodios dolorosos del pasado de manera recurrente, reforzando así su sensación de indignidad y sufrimiento autoimpuesto. Su actitud está marcada por la renuncia a cualquier forma de reconocimiento o autoafirmación, lo que lo lleva a intensificar sus dificultades y a posicionarse en una dinámica de inferioridad o servidumbre en sus relaciones interpersonales. Este perfil de personalidad guarda similitudes con la personalidad autodestructiva descrita en el DSM, en la medida en que tiende a perpetuar su propio malestar mediante un ciclo de autodevaluación y negación del bienestar. Su comportamiento está orientado a reforzar la percepción de que merece ser castigado o despreciado, mostrando una resistencia activa a cualquier intento externo de mejorar su condición emocional o social. Su tendencia a la autoinfravaloración y a la autosacrificación lo coloca en una posición vulnerable ante la explotación y el abuso, al mismo tiempo que fortalece su identidad basada en la angustia y el sufrimiento.";
        }

        $result_tendencialimite = "Sin datos suficientes para evaluar.";
        $l29 = 0;
        if ($l29 <= 60) {
            $result_tendencialimite = "Indica una baja incidencia de las características asociadas con la tendencia límite.";
        } elseif ($l29 <= 74) {
            $result_tendencialimite = "Se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o que afecte significativamente su funcionamiento. En estos casos, puede experimentar algunas fluctuaciones en su estado de ánimo o cierta inestabilidad en sus relaciones, pero sin que esto configure un patrón persistente de desregulación emocional o impulsividad.";
        } elseif ($l29 <= 84) {
            $result_tendencialimite = "El patrón de personalidad de tendencia límite se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. Se observa una tendencia a experimentar estados emocionales intensos y variables, alternando entre episodios de abatimiento, ansiedad, irritabilidad o euforia. Su comportamiento puede tornarse caprichoso e impulsivo, con cambios abruptos en la forma en que percibe sus relaciones interpersonales. Es común que muestre una fuerte ambivalencia en sus vínculos, oscilando entre la idealización y la desvalorización de los demás. Puede manifestar temor al abandono, lo que lo lleva a reaccionar de manera extrema ante situaciones que percibe como amenazantes para su estabilidad emocional. Su sentido de identidad suele ser frágil, con dificultades para mantener una autoimagen estable y coherente a lo largo del tiempo.";
        } elseif ($l29 >= 85) {
            $result_tendencialimite = "La expresión del prototipo de personalidad de tendencia límite se torna destacada o prominente. En este nivel, presenta una marcada desorganización interna, con una constante oscilación entre extremos opuestos en su comportamiento y estado emocional. Su inestabilidad afectiva se manifiesta en cambios abruptos de humor, con periodos de abatimiento y apatía que pueden alternarse con episodios de rabia intensa, ansiedad o euforia. En el ámbito interpersonal, predominan sentimientos contradictorios de amor, culpa y hostilidad hacia los demás, lo que dificulta la construcción de relaciones estables. Su estructura psíquica presenta una cohesión reducida, con dificultades para mantener una posición equilibrada entre la dependencia y la independencia, entre la impulsividad y la pasividad, o entre la obediencia y la oposición. En este nivel de expresión, la presencia de pensamientos autolesivos y suicidas puede ser recurrente, y algunos pueden llegar a actuar en función de estos impulsos. Su comportamiento tiende a ser errático, con una marcada dificultad para mantener la consistencia en sus decisiones y acciones. Reiteradamente, sabotea o contradice sus propios esfuerzos, reflejando un estado interno caracterizado por una profunda división intrapsíquica. Su funcionamiento se encuentra marcado por una fractura entre sus orientaciones internas y su forma de relacionarse con los demás, lo que genera un patrón de inestabilidad persistente tanto a nivel emocional como interpersonal. Este perfil de personalidad guarda similitudes con el trastorno límite de la personalidad descrito en el DSM, en la medida en que muestra una estructura psíquica caracterizada por una marcada discordia interna y una incapacidad para mantener un sentido coherente de sí mismo. Su funcionamiento se ve afectado por una polarización constante en sus emociones, relaciones y comportamientos, lo que lo lleva a alternar entre impulsividad y retraimiento, entre dependencia y oposición, y entre la búsqueda de aprobación y el rechazo activo de la misma. Su experiencia subjetiva está dominada por una sensación de vacío, inestabilidad y conflicto interno, lo que genera dificultades significativas en su capacidad para mantener relaciones interpersonales estables y una identidad consolidada.";
        }

        $descripciones = [
            "Introversión" => $result_introversion,
            "Inhibido" => $result_inhibido,
            "Pesimista" => $result_pesimista,
            "Sumiso" => $result_sumiso,
            "Histriónico" => $result_histrionico,
            "Egocéntrico" => $result_egocentrico,
            "Rebelde" => $result_rebelde,
            "Rudo" => $result_rudo,
            "Conformista" => $result_conformista,
            "Oposicionista" => $result_oposicionista,
            "Autopunitivo" => $result_autopunitivo,
            "Tendencia límite" => 0,
        ];
        
        return $descripciones[$texto] ?? "NA";
    }

    //sindromes clinicos
    public function getSindromeClinico($except_array,$transtorno,$inclinacion,$predisposicion,$propension,$sentimiento,$afecto,$tendencia){
        $array = [
            ["llave" => "Trastornos de la alimentación", "total" => $transtorno, "valor" => 0],
            ["llave" => "Inclinación al abuso de sustancias", "total" => $inclinacion, "valor" => -4],
            ["llave" => "Predisposición a la delincuencia", "total" => $predisposicion, "valor" => -4],
            ["llave" => "Propensión a la impulsividad", "total" => $propension, "valor" => 0],
            ["llave" => "Sentimiento de ansiedad", "total" => $sentimiento, "valor" => 4],
            ["llave" => "Afecto depresivo", "total" => $afecto, "valor" => 4],
            ["llave" => "Tendencia al suicidio", "total" => $tendencia, "valor" => 0],
        ];

        $maxTotal = -1;
        $valorMaximo = 0;//return
        $selected = null;
        foreach ($array as $item) {
            if ($item['total'] > $maxTotal && !in_array($item['llave'], $except_array)) {// 
                $maxTotal = $item['total'];
                $valorMaximo = $item['valor'];
                $selected = $item;
            }
        }
        
        return $selected;
    }

    public function getObjetivoSindromeClinico($texto){
        $descripciones = [
            "Trastornos de la alimentación" => "Evalúa la tendencia a la anorexia o la bulimia nerviosas. Identifica patrones de alimentación problemáticos, preocupación excesiva por el peso y temor intenso a volverse obeso",
            "Inclinación al abuso de sustancias" => "Mide patrones inadecuados de abuso de alcohol o drogas que han llevado a un deterioro significativo del rendimiento o comportamiento. Evalúa el tiempo dedicado a obtener sustancias, comportamientos socialmente inaceptables y persistencia en el consumo a pesar de consecuencias negativas",
            "Predisposición a la delincuencia" => "Evalúa comportamientos que violan los derechos de otros o normas sociales. Incluye amenazas, uso de armas, engaño, robo y otras conductas antisociales",
            "Propensión a la impulsividad" => "Mide la tendencia a actuar con poca reflexión ante provocaciones mínimas. Evalúa el pobre control de impulsos sexuales y agresivos, y la propensión a reacciones emocionales intensas y repentinas",
            "Sentimiento de ansiedad" => "Evalúa la presencia de aprensión, inquietud y nerviosismo generalizado. Mide la tendencia a estar constantemente alerta y temeroso ante posibles problemas o situaciones amenazantes",
            "Afecto depresivo" => "Identifica síntomas de depresión como disminución de la actividad, sentimientos de culpa, fatiga, desesperanza, aislamiento social, pérdida de confianza y disminución de los sentimientos de adecuación y del propio atractivo",
            "Tendencia al suicidio" => "Evalúa la presencia de ideación y planes suicidas. Mide sentimientos de falta de valor, ausencia de objetivos y la creencia de que los demás estarían mejor sin el adolescente",
        ];
        
        return "(".($descripciones[$texto] ?? "NA")."). ";
    }

    public function getSindromeClinicoInterpretacion($texto,$transtorno,$inclinacion,$predisposicion,$propension,$sentimiento,$afecto,$tendencia){
        
        $result_transtorno = "";
        if ($transtorno <= 60) {
            $result_transtorno = "La puntuación obtenida se encuentra dentro de un rango en el que no se identifican semejanzas con los adolescentes que presentan "
                    . "trastornos de la conducta alimentaria. No se observan indicadores que reflejen preocupación extrema por el peso, el miedo a la obesidad "
                    . "o la presencia de patrones alimentarios desadaptativos como restricción severa de la ingesta, episodios de alimentación incontrolada o conductas compensatorias.";
        } elseif ($transtorno <= 74) {
            $result_transtorno = "Muestra algunas semejanzas con adolescentes que presentan preocupaciones relacionadas con la alimentación y el peso. "
                    . "Puede estar presente ciertos indicios de inquietud por su imagen corporal o intentos esporádicos de control alimentario, "
                    . "aunque sin llegar a un patrón clínicamente significativo. Estas manifestaciones pueden fluctuar en función de situaciones externas.";
        } elseif ($transtorno <= 84) {
            $result_transtorno = "Se identifica niveles moderados de características asociadas a los trastornos de la conducta alimentaria. "
                    . "Es posible que muestre una preocupación intensa por el peso y la apariencia física, con tendencia a restringir la ingesta de alimentos "
                    . "o experimentar episodios de ingesta descontrolada seguidos de conductas compensatorias como el uso de laxantes, diuréticos o vómitos autoinducidos. "
                    . "La relación con la alimentación puede estar caracterizada por patrones rígidos y una percepción distorsionada del peso corporal.";
        } elseif ($transtorno >= 85) {
            $result_transtorno = "Se observa una alta probabilidad de que manifieste un cuadro característico de los trastornos de la conducta alimentaria. "
                    . "La preocupación por el peso y la figura adquiere un nivel central en su experiencia, lo que puede traducirse en conductas extremas como restricción alimentaria, "
                    . "episodios de alimentación incontrolada y la implementación de métodos compensatorios para evitar el aumento de peso. "
                    . "Es frecuente la presencia de un temor persistente a ganar peso, incluso cuando el peso se encuentra por debajo de lo esperado. "
                    . "Estos patrones suelen estar enmarcados en una distorsión de la imagen corporal y una relación disfuncional con la alimentación, "
                    . "reflejando una exacerbación del estilo de personalidad subyacente.";
        }
        
        $inclinacion_message = "";
        if ($inclinacion <= 60) {
            $inclinacion_message = "La puntuación obtenida se encuentra dentro de un rango en el que no se identifican semejanzas con adolescentes que presentan un patrón inadecuado "
                    . "de consumo de alcohol o drogas. No se observan indicadores que reflejen un deterioro significativo en su rendimiento o comportamiento asociado al uso de sustancias, "
                    . "ni evidencia de conductas orientadas a la obtención de estas.";
        } elseif ($inclinacion <= 74) {
            $inclinacion_message = "Presenta ciertas semejanzas con adolescentes que han experimentado contacto o curiosidad por el consumo de sustancias, "
                    . "aunque sin manifestar un patrón de abuso significativo. Puede haber indicios de exposición a contextos donde el consumo es una opción presente, "
                    . "así como actitudes permisivas o exploratorias respecto al uso de alcohol o drogas, sin que esto represente un deterioro marcado en su funcionamiento diario.";
        } elseif ($inclinacion <= 84) {
            $inclinacion_message = "Se identifican niveles moderados de características asociadas al abuso de sustancias. "
                    . "Es posible que haya desarrollado patrones de consumo que impactan en su comportamiento y rendimiento. "
                    . "Puede invertir una cantidad considerable de tiempo en la obtención y uso de sustancias, lo que puede llevar a la adopción de conductas socialmente inaceptables. "
                    . "A pesar de reconocer los efectos negativos que esto genera en su vida, el consumo puede mantenerse como una conducta persistente.";
        } elseif ($inclinacion >= 85) {
            $inclinacion_message = "Se observa una alta probabilidad de que manifieste un patrón marcado de abuso de sustancias. "
                    . "La conducta de consumo de alcohol o drogas ha adquirido una relevancia central en su vida, afectando su desempeño en diversas áreas "
                    . "y contribuyendo al deterioro de su comportamiento. Dedica una cantidad considerable de tiempo a la obtención y consumo de estas sustancias, "
                    . "mostrando una falta de control sobre su uso. A pesar de ser consciente de los efectos perjudiciales que esto genera, el consumo persiste, "
                    . "reflejando una inclinación establecida hacia este patrón de comportamiento.";
        }
        $predisposicion_message = "";
        if ($predisposicion <= 60) {
            $predisposicion_message = "La puntuación obtenida se encuentra dentro de un rango en el que no se identifican semejanzas con adolescentes que presentan inclinaciones hacia conductas delictivas. "
                    . "No se observan indicadores que reflejen comportamientos asociados a la violación de normas sociales, transgresión de derechos ajenos o participación en actividades antisociales.";
        } elseif ($predisposicion <= 74) {
            $predisposicion_message = "Presenta ciertas semejanzas con adolescentes que han mostrado comportamientos desafiantes frente a normas y reglas sociales. "
                    . "Puede existir episodios esporádicos en los que se ha manifestado actitudes de oposición, deshonestidad o conductas que rozan la transgresión de límites establecidos, "
                    . "aunque sin llegar a establecer un patrón delictivo sostenido. Estas manifestaciones pueden estar influenciadas por factores contextuales, "
                    . "sin consolidarse como un rasgo dominante en su conducta.";
        } elseif ($predisposicion <= 84) {
            $predisposicion_message = "Se identifica niveles moderados de características asociadas a la predisposición a la delincuencia. "
                    . "Es posible que haya participado en conductas que implican violaciones de normas sociales o acciones que afectan a otros. "
                    . "Puede presentarse episodios de engaño, manipulación, agresión o robos; denota tendencia a desafiar restricciones impuestas por la autoridad. "
                    . "Estos comportamientos pueden estar relacionados con una mayor tolerancia al riesgo y una dificultad para ajustarse a normas sociales establecidas.";
        } elseif ($predisposicion >= 85) {
            $predisposicion_message = "Se observa una alta probabilidad de que manifieste un patrón característico de predisposición a la delincuencia. "
                    . "La conducta transgresora puede estar consolidada, reflejándose en actos que implican la violación de derechos de otros y el incumplimiento de normas establecidas. "
                    . "Es posible que haya participado en amenazas, uso de armas, robos, engaños reiterados o agresiones físicas. "
                    . "Estas conductas pueden mantenerse de manera persistente a pesar de las consecuencias negativas asociadas, "
                    . "manifestando una inclinación hacia acciones que desafían las normas establecidas en la sociedad.";
        }

        $propension_message = "";

        if ($propension <= 60) {
            $propension_message = "La puntuación obtenida se encuentra dentro de un rango en el que no se identifican semejanzas con adolescentes que presentan comportamientos asociados "
                    . "a la transgresión de normas o la violación de derechos ajenos. No se observan indicadores que reflejen inclinaciones hacia conductas antisociales, engaños persistentes, "
                    . "agresiones o participación en actividades delictivas.";
        } elseif ($propension <= 74) {
            $propension_message = "Presenta ciertas semejanzas con adolescentes que han mostrado actitudes desafiantes ante normas y reglas sociales. "
                    . "Puede haber episodios esporádicos en los que se han manifestado conductas de oposición, engaño o transgresión de límites establecidos. "
                    . "Sin embargo, estas acciones no representan un patrón delictivo consolidado y pueden fluctuar en función del contexto o de situaciones específicas.";
        } elseif ($propension <= 84) {
            $propension_message = "Se identifican niveles moderados de características asociadas a la predisposición a la delincuencia. "
                    . "Es posible que haya mostrado comportamientos en los que se transgreden normas sociales o se afectan los derechos de otros. "
                    . "Pueden presentarse episodios de manipulación, engaño persistente, agresiones, robos o amenazas, lo que indica una tendencia a desafiar restricciones impuestas por la autoridad. "
                    . "Estas conductas pueden estar relacionadas con una menor adherencia a normas y un menor reconocimiento de las consecuencias de sus actos.";
        } elseif ($propension >= 85) {
            $propension_message = "Se observa una alta probabilidad de que el evaluado manifieste un patrón característico de predisposición a la delincuencia. "
                    . "Su comportamiento puede estar marcado por una tendencia estable a la violación de normas y la transgresión de derechos ajenos. "
                    . "Es posible que haya participado en actos de agresión, amenazas, robos, uso de armas o engaños recurrentes. "
                    . "Estas conductas pueden mantenerse a pesar de las consecuencias negativas que generan, reflejando una inclinación hacia acciones que desafían los límites sociales y legales establecidos.";
        }

        $sentimiento_message= "";

        if ($sentimiento <= 60) {
            $sentimiento_message = "La puntuación obtenida se encuentra dentro de un rango en el que no se identifican semejanzas con adolescentes que presentan estados persistentes de ansiedad. "
                    . "No se observan indicadores que reflejen preocupación excesiva, nerviosismo recurrente o una sensación constante de aprensión ante eventos futuros.";
        } elseif ($sentimiento <= 74) {
            $sentimiento_message = "Presenta algunas semejanzas con adolescentes que pueden experimentar cierta inquietud ante diversas situaciones. "
                    . "Puede presentarse episodios de preocupación o tensión, aunque estos no alcanzan una intensidad que genere un malestar significativo en su estado emocional. "
                    . "La ansiedad puede manifestarse de manera ocasional sin constituir un rasgo predominante en su funcionamiento.";
        } elseif ($sentimiento <= 84) {
            $sentimiento_message = "Se identifican niveles moderados de características asociadas a la ansiedad. "
                    . "Experimenta una sensación persistente de nerviosismo y aprensión, acompañada de una incomodidad constante. "
                    . "Puede estar en un estado de alerta ante la posibilidad de que ocurra algo negativo, mostrando dificultades para relajarse o deshacerse de la preocupación. "
                    . "La ansiedad influye en su comportamiento y genera una percepción de malestar prolongado.";
        } elseif ($sentimiento >= 85) {
            $sentimiento_message = "Se observa una alta probabilidad de que manifieste un patrón característico de ansiedad significativa. "
                    . "La sensación de aprensión y desasosiego es constante, con una percepción continua de que algo negativo puede ocurrir. "
                    . "Puede presentar un estado de inquietud permanente, acompañado de una expectativa de angustia sin una causa clara. "
                    . "La ansiedad se encuentra presente en diversos ámbitos y afecta su funcionamiento diario, generando un malestar emocional sostenido.";
        }

        $afecto_message = "";

        if ($afecto <= 60) {
            $afecto_message = "La puntuación obtenida se encuentra dentro de un rango en el que no se identifican semejanzas con adolescentes que presentan un estado de ánimo deprimido. "
                    . "No se observan indicadores que reflejen disminución en el nivel de actividad, pérdida de confianza, sentimientos de culpa o una percepción negativa sobre el futuro.";
        } elseif ($afecto <= 74) {
            $afecto_message = "Presenta ciertas semejanzas con adolescentes que pueden experimentar momentos de desánimo o una ligera disminución en su nivel de energía. "
                    . "Puede haber indicios de una leve insatisfacción con su desempeño o con su autoimagen, sin que esto represente una alteración significativa en su estado de ánimo o funcionamiento diario.";
        } elseif ($afecto <= 84) {
            $afecto_message = "Se identifican niveles moderados de características asociadas al afecto depresivo. "
                    . "Presenta una disminución en su nivel de actividad, acompañada de sentimientos de culpa, fatiga y desesperanza respecto al futuro. "
                    . "Manifiesta una tendencia al aislamiento social y una pérdida de confianza en sus capacidades, con una percepción reducida de su propio atractivo y una sensación de inadecuación personal.";
        } elseif ($afecto >= 85) {
            $afecto_message = "Se observa una alta probabilidad de que manifieste un patrón característico de afecto depresivo. "
                    . "Su nivel de actividad se encuentra reducido en comparación con su funcionamiento previo. "
                    . "Presenta una pérdida de eficacia, sentimientos persistentes de culpa y fatiga, así como una visión desesperanzada del futuro. "
                    . "Es frecuente el aislamiento social y una notable disminución en la confianza en sí mismo, lo que se acompaña de una percepción negativa de su adecuación personal y su atractivo.";
        }

        $tendencia_message = "";

        if ($tendencia <= 60) {
            $tendencia_message = "La puntuación obtenida se encuentra dentro de un rango en el que no se identifican semejanzas con adolescentes que presentan ideación o planes suicidas. "
                    . "No se observan indicadores que reflejen una sensación persistente de falta de valor, ausencia de objetivos o pensamientos relacionados con la percepción de que los demás estarían mejor sin su presencia.";
        } elseif ($tendencia <= 74) {
            $tendencia_message = "Presenta ciertas semejanzas con adolescentes que han experimentado momentos de desesperanza o pensamientos de inutilidad. "
                    . "Puede manifestarse sentimientos ocasionales de falta de propósito o desvalorización personal, aunque estos no constituyen un patrón persistente ni están acompañados de ideación suicida estructurada.";
        } elseif ($tendencia <= 84) {
            $tendencia_message = "Se identifican niveles moderados de características asociadas a la tendencia suicida. "
                    . "Experimenta una sensación recurrente de falta de valor y ausencia de metas, acompañada de pensamientos en los que considera la posibilidad de que los demás estarían mejor sin su presencia. "
                    . "La ideación suicida puede estar presente, aunque no necesariamente acompañada de planes específicos o una intención consolidada de llevarla a cabo.";
        } elseif ($tendencia >= 85) {
            $tendencia_message = "Se observa una alta probabilidad de que manifieste un patrón característico de tendencia suicida. "
                    . "La presencia de ideación y planes suicidas es un aspecto relevante en su perfil, acompañado de un marcado sentimiento de inutilidad "
                    . "y una percepción persistente de que su existencia carece de propósito. La idea de que los demás estarían mejor sin su presencia es un pensamiento recurrente y significativo en su experiencia.";
        }


        $descripciones = [
            "Trastornos de la alimentación" => $result_transtorno,
            "Inclinación al abuso de sustancias" => $inclinacion_message,
            "Predisposición a la delincuencia" => $predisposicion_message,
            "Propensión a la impulsividad" => $propension_message,
            "Sentimiento de ansiedad" => $sentimiento_message,
            "Afecto depresivo" => $afecto_message,
            "Tendencia al suicidio" => $tendencia_message,
        ];
        
        return $descripciones[$texto] ?? "NA";
    }

    public function getPreocupacionesExpresadasTB($except_array,$desagrado,$difusion,$insensibilidad,$desvalorizacion,$incomodidad,$inseguridad,$discordancia,$abusos){
        $array = [
            ["llave" => "Desagrado por el propio cuerpo", "total" => $desagrado, "objetivo" => "Evalúa el descontento con las deficiencias o desviaciones percibidas en la maduración o morfología corporal. Mide la insatisfacción con el atractivo físico y social","interpretacion"=>"la insatisfacción con la imagen corporal se convierte en un área pendiente de resolver, considerada problemática. En este nivel, experimenta un malestar persistente con su apariencia física, expresando un descontento recurrente con su desarrollo corporal. Su percepción negativa de sí mismo se ve influida por la evaluación externa y por la comparación con estándares de atractivo social. Es común que perciba deficiencias en su morfología, lo que puede afectar su autoconfianza y su participación en entornos sociales."],
            ["llave" => "Difusión de la identidad", "total" => $difusion, "objetivo" => "Evalúa la confusión del adolescente sobre quién es y lo que quiere. Mide la inseguridad sobre la propia identidad, la falta de claridad en las metas futuras y los valores","interpretacion"=>"la identidad se percibe como un tema ligeramente problemático. En este nivel, puede experimentar períodos de incertidumbre y desorientación respecto a quién es y qué desea en el futuro. Aunque este proceso es común durante el desarrollo psicosocial, la falta de claridad en sus valores, metas y sentido de sí mismo puede generar momentos de inseguridad y confusión."],
            ["llave" => "Insensibilidad social", "total" => $insensibilidad, "objetivo" => "Mide la frialdad e indiferencia hacia el bienestar de otros. Evalúa la falta de empatía y el escaso interés en construir vínculos personales cálidos o afectuosos","interpretacion"=>"la insensibilidad social se percibe como un tema ligeramente problemático. En este nivel, puede manifestar cierta distancia afectiva en sus relaciones, mostrando un menor interés por los sentimientos y necesidades de los demás. Su comportamiento puede reflejar una tendencia a priorizar sus propios deseos sin prestar demasiada atención a las consecuencias que esto puede tener en su entorno social. Aunque no se trata de una actitud extrema, puede haber dificultades para desarrollar vínculos personales cálidos."],
            ["llave" => "Desvalorización de sí mismo", "total" => $desvalorizacion, "objetivo" => "Mide la insatisfacción con la imagen de sí mismo y los sentimientos de baja autoestima. Evalúa la percepción de tener poco que admirar en uno mismo y el temor a no alcanzar las expectativas","interpretacion"=>"la desvalorización de sí mismo se percibe como un tema ligeramente problemático. En este nivel, puede mostrar episodios de autocrítica frecuente y comparaciones negativas con los demás. Aunque mantiene cierto grado de confianza en sí mismo, sus sentimientos de insatisfacción con su autoimagen pueden generarle dudas sobre su capacidad para alcanzar sus aspiraciones personales."],
        
            ["llave" => "Incomodidad respecto al sexo", "total" => $incomodidad, "objetivo" => "Mide la insatisfacción con la imagen de sí mismo y los sentimientos de baja autoestima. Evalúa la percepción de tener poco que admirar en uno mismo y el temor a no alcanzar las expectativas","interpretacion"=>"la desvalorización de sí mismo se percibe como un tema ligeramente problemático. En este nivel, puede mostrar episodios de autocrítica frecuente y comparaciones negativas con los demás. Aunque mantiene cierto grado de confianza en sí mismo, sus sentimientos de insatisfacción con su autoimagen pueden generarle dudas sobre su capacidad para alcanzar sus aspiraciones personales."],
            ["llave" => "Inseguridad con los iguales", "total" => $inseguridad, "objetivo" => "Mide la insatisfacción con la imagen de sí mismo y los sentimientos de baja autoestima. Evalúa la percepción de tener poco que admirar en uno mismo y el temor a no alcanzar las expectativas","interpretacion"=>"la desvalorización de sí mismo se percibe como un tema ligeramente problemático. En este nivel, puede mostrar episodios de autocrítica frecuente y comparaciones negativas con los demás. Aunque mantiene cierto grado de confianza en sí mismo, sus sentimientos de insatisfacción con su autoimagen pueden generarle dudas sobre su capacidad para alcanzar sus aspiraciones personales."],
            ["llave" => "Discordancia familiar", "total" => $discordancia, "objetivo" => "Mide la insatisfacción con la imagen de sí mismo y los sentimientos de baja autoestima. Evalúa la percepción de tener poco que admirar en uno mismo y el temor a no alcanzar las expectativas","interpretacion"=>"la desvalorización de sí mismo se percibe como un tema ligeramente problemático. En este nivel, puede mostrar episodios de autocrítica frecuente y comparaciones negativas con los demás. Aunque mantiene cierto grado de confianza en sí mismo, sus sentimientos de insatisfacción con su autoimagen pueden generarle dudas sobre su capacidad para alcanzar sus aspiraciones personales."],
            ["llave" => "Abusos en la infancia", "total" => $abusos, "objetivo" => "Mide la insatisfacción con la imagen de sí mismo y los sentimientos de baja autoestima. Evalúa la percepción de tener poco que admirar en uno mismo y el temor a no alcanzar las expectativas","interpretacion"=>"la desvalorización de sí mismo se percibe como un tema ligeramente problemático. En este nivel, puede mostrar episodios de autocrítica frecuente y comparaciones negativas con los demás. Aunque mantiene cierto grado de confianza en sí mismo, sus sentimientos de insatisfacción con su autoimagen pueden generarle dudas sobre su capacidad para alcanzar sus aspiraciones personales."],
            
        ];

        $maxTotal = -1;
        $valorMaximo = 0;//return
        $selected = null;
        foreach ($array as $item) {
            if ($item['total'] > $maxTotal && !in_array($item['llave'], $except_array)) {// 
                $maxTotal = $item['total'];
                $selected = $item;
            }
        }
        
        return $selected;
    }
    //copia de getPreocupacionesExpresadasTB array duplicar
    public function getPuntosFuertesTB($except_array,$desagrado,$difusion,$insensibilidad,$desvalorizacion,$incomodidad,$inseguridad,$discordancia,$abusos){
        
        $array = [
           ["llave" => "Desagrado por el propio cuerpo", "total" => $desagrado, "objetivo" => "Evalúa el descontento con las deficiencias o desviaciones percibidas en la maduración o morfología corporal. Mide la insatisfacción con el atractivo físico y social","interpretacion"=>"la insatisfacción con la imagen corporal se convierte en un área pendiente de resolver, considerada problemática. En este nivel, experimenta un malestar persistente con su apariencia física, expresando un descontento recurrente con su desarrollo corporal. Su percepción negativa de sí mismo se ve influida por la evaluación externa y por la comparación con estándares de atractivo social. Es común que perciba deficiencias en su morfología, lo que puede afectar su autoconfianza y su participación en entornos sociales."],
            ["llave" => "Difusión de la identidad", "total" => $difusion, "objetivo" => "Evalúa la confusión del adolescente sobre quién es y lo que quiere. Mide la inseguridad sobre la propia identidad, la falta de claridad en las metas futuras y los valores","interpretacion"=>"la identidad se percibe como un tema ligeramente problemático. En este nivel, puede experimentar períodos de incertidumbre y desorientación respecto a quién es y qué desea en el futuro. Aunque este proceso es común durante el desarrollo psicosocial, la falta de claridad en sus valores, metas y sentido de sí mismo puede generar momentos de inseguridad y confusión."],
            ["llave" => "Insensibilidad social", "total" => $insensibilidad, "objetivo" => "Mide la frialdad e indiferencia hacia el bienestar de otros. Evalúa la falta de empatía y el escaso interés en construir vínculos personales cálidos o afectuosos","interpretacion"=>"la insensibilidad social se percibe como un tema ligeramente problemático. En este nivel, puede manifestar cierta distancia afectiva en sus relaciones, mostrando un menor interés por los sentimientos y necesidades de los demás. Su comportamiento puede reflejar una tendencia a priorizar sus propios deseos sin prestar demasiada atención a las consecuencias que esto puede tener en su entorno social. Aunque no se trata de una actitud extrema, puede haber dificultades para desarrollar vínculos personales cálidos."],
            ["llave" => "Desvalorización de sí mismo", "total" => $desvalorizacion, "objetivo" => "Mide la insatisfacción con la imagen de sí mismo y los sentimientos de baja autoestima. Evalúa la percepción de tener poco que admirar en uno mismo y el temor a no alcanzar las expectativas","interpretacion"=>"la desvalorización de sí mismo se percibe como un tema ligeramente problemático. En este nivel, puede mostrar episodios de autocrítica frecuente y comparaciones negativas con los demás. Aunque mantiene cierto grado de confianza en sí mismo, sus sentimientos de insatisfacción con su autoimagen pueden generarle dudas sobre su capacidad para alcanzar sus aspiraciones personales."],
        
            ["llave" => "Incomodidad respecto al sexo", "total" => $incomodidad, "objetivo" => "Mide la insatisfacción con la imagen de sí mismo y los sentimientos de baja autoestima. Evalúa la percepción de tener poco que admirar en uno mismo y el temor a no alcanzar las expectativas","interpretacion"=>"la desvalorización de sí mismo se percibe como un tema ligeramente problemático. En este nivel, puede mostrar episodios de autocrítica frecuente y comparaciones negativas con los demás. Aunque mantiene cierto grado de confianza en sí mismo, sus sentimientos de insatisfacción con su autoimagen pueden generarle dudas sobre su capacidad para alcanzar sus aspiraciones personales."],
            ["llave" => "Inseguridad con los iguales", "total" => $inseguridad, "objetivo" => "Mide la insatisfacción con la imagen de sí mismo y los sentimientos de baja autoestima. Evalúa la percepción de tener poco que admirar en uno mismo y el temor a no alcanzar las expectativas","interpretacion"=>"la desvalorización de sí mismo se percibe como un tema ligeramente problemático. En este nivel, puede mostrar episodios de autocrítica frecuente y comparaciones negativas con los demás. Aunque mantiene cierto grado de confianza en sí mismo, sus sentimientos de insatisfacción con su autoimagen pueden generarle dudas sobre su capacidad para alcanzar sus aspiraciones personales."],
            ["llave" => "Discordancia familiar", "total" => $discordancia, "objetivo" => "Mide la insatisfacción con la imagen de sí mismo y los sentimientos de baja autoestima. Evalúa la percepción de tener poco que admirar en uno mismo y el temor a no alcanzar las expectativas","interpretacion"=>"la desvalorización de sí mismo se percibe como un tema ligeramente problemático. En este nivel, puede mostrar episodios de autocrítica frecuente y comparaciones negativas con los demás. Aunque mantiene cierto grado de confianza en sí mismo, sus sentimientos de insatisfacción con su autoimagen pueden generarle dudas sobre su capacidad para alcanzar sus aspiraciones personales."],
            ["llave" => "Abusos en la infancia", "total" => $abusos, "objetivo" => "Mide la insatisfacción con la imagen de sí mismo y los sentimientos de baja autoestima. Evalúa la percepción de tener poco que admirar en uno mismo y el temor a no alcanzar las expectativas","interpretacion"=>"la desvalorización de sí mismo se percibe como un tema ligeramente problemático. En este nivel, puede mostrar episodios de autocrítica frecuente y comparaciones negativas con los demás. Aunque mantiene cierto grado de confianza en sí mismo, sus sentimientos de insatisfacción con su autoimagen pueden generarle dudas sobre su capacidad para alcanzar sus aspiraciones personales."],
            
        ];

        $maxTotal = -1;
        $valorMaximo = 0;//return
        $selected = null;
        foreach ($array as $item) {
            if($item['total']<=35){
                if ($item['total'] > $maxTotal && !in_array($item['llave'], $except_array) ) {
                    $maxTotal = $item['total'];
                    $selected = $item;
                }
            }
        }
        
        return $selected;
    }
}
