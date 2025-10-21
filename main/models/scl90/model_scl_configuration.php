<?php
class ModelSclConfiguration {

    public function contarNoCeros($answers){
        $total = 0;
        foreach($answers as $answer){
            $value = (int)$answer['response'];
            if($value>0){
                $total +=1;
            }
        }
        return $total;
    }

    public function GetAux1($array,$compare){
        //Columna T,T54
        $resultado = 0;
        foreach ($array as $valor) {
            if ($valor >= 51 && $valor > $compare) {
                $resultado += 1;
            }
        }
        return $resultado;
    }

    public function GetAux2($array1,$array2,$compare1,$compare2){
        //Columna T,Columna S,T54, S54
        $resultado = 0;
        for ($i = 0; $i < count($array1); $i++) {
            if ($array1[$i] >= 51 && $array1[$i] == $compare1 && $array2[$i] > $compare2) {
                $resultado += 1; // Suma si cumple todas las condiciones
            }
        }
        return $resultado;
    }

    public function GetAux3($T,$S,$R,$compare1,$compare2,$compare3){
        //Columna T,Columna S,Columna R, T54, S54,R54
        $T54 = $compare1;
        $S54 = $compare2;
        $R54 = $compare3;

        $resultado = 0;

        for ($i = 0; $i < count($T); $i++) {
            if ($T[$i] >= 51 && $T[$i] == $T54 && $S[$i] == $S54 && $R[$i] > $R54) {
                $resultado += 1;
            }
        }
        return $resultado;
    }

    public function GetAux4($T,$S,$R,$compare1,$compare2,$compare3,$indice){//0,1,2$indice
        //Columna T,Columna S,Columna R, T54, S54,R54
        $T54 = $compare1;
        $S54 = $compare2;
        $R54 = $compare3;
        $resultado = 0;

        for ($i = 0; $i < $indice; $i++) { // FILA($T$54:$T$62) < FILA(T54)
            if ($T[$i] >= 51 && $T[$i] == $T54 && $S[$i] == $S54 && $R[$i] == $R54) {
                $resultado++;
            }
        }
        return $resultado;
    }
    // 
    public function getIndex($T,$S,$R,$compareT,$comparePD,$compareR,$sumIndirecta){
        $valor1 = $this->GetAux1($T,$compareT);
        $valor2 = $this->GetAux2($T,$S,$compareT,$comparePD);
        $valor3 = $this->GetAux3($T,$S,$R,$compareT,$comparePD,$compareR);
        $valor4 = $this->GetAux4($T,$S,$R,$compareT,$comparePD,$compareR,$sumIndirecta);
        //echo $valor4.'<br>';
        return 1+$valor1+$valor2+$valor3+$valor4;
    }

    public function getResponse1($valuestring,$value_t){
        $resultado = "";
        if($valuestring == "Ansiedad"){
            if ($value_t <= 50) {
                $resultado = "Indica que los niveles de síntomas depresivos reportados están dentro del rango considerado normal. "
                . "Los sentimientos de tristeza, desánimo y falta de energía no son frecuentes ni intensos. "
                . "Estos síntomas se consideran comunes y no generan un malestar significativo.";
            } elseif ($value_t <= 63) {
                $resultado = "Indica que los síntomas depresivos reportados son más frecuentes o intensos que los observados en la población general, "
                . "aunque no alcanzan una severidad alta. Síntomas como sentirse bajo de energías, preocuparse demasiado por todo y sentirse solo "
                . "pueden estar presentes en mayor medida. Esta puntuación sugiere una mayor incidencia de síntomas depresivos, aunque de intensidad moderada.";
            } elseif ($value_t >= 64) {
                $resultado = "Indica que los síntomas depresivos son significativamente más frecuentes e intensos que en la población general. "
                . "Síntomas como pensamientos suicidas, sentirse desesperanzado con respecto al futuro y la sensación de ser inútil o no valer nada son prominentes. "
                . "Esta puntuación refleja una alta severidad de síntomas depresivos.";
            }
            return $resultado;
        }

        if($valuestring == "Somatización"){
            if ($value_t <= 50) {
                $resultado = "Indica que los niveles de síntomas somáticos reportados están dentro del rango considerado normal. "
                . "Los síntomas físicos, como dolores de cabeza, sensaciones de desmayo o mareo, y dolores musculares, no son frecuentes ni intensos. "
                . "Estos síntomas se consideran comunes y esperados en la población general, sin indicar un malestar significativo.";
            } elseif ($value_t <= 63) {
                $resultado = "Indica que los síntomas somáticos reportados son más frecuentes o intensos que los observados en la población general, "
                . "aunque no alcanzan una severidad alta. Los síntomas como náuseas, dolores en la parte baja de la espalda y entumecimiento u hormigueo "
                . "pueden estar presentes en mayor medida. Esta puntuación sugiere una mayor incidencia de síntomas físicos, aunque de intensidad moderada.";
            } elseif ($value_t >= 64) {
                $resultado = "Indica que los síntomas somáticos son significativamente más frecuentes e intensos que en la población general. "
                . "Síntomas como dolores en el corazón o en el pecho, ahogos o dificultad para respirar, y pesadez en los brazos o en las piernas son prominentes. "
                . "Esta puntuación refleja una alta severidad de síntomas somáticos. Sugiere que experimenta un alto nivel de malestar físico que puede estar relacionado con factores psicológicos.";
            }
            return $resultado;
        }

        if($valuestring == "Obsesión-compulsión"){
            if ($value_t <= 50) {
                $resultado = "Indica que los niveles de pensamientos y conductas obsesivo-compulsivas se encuentran dentro del rango normal. "
                . "Los síntomas, como la dificultad para tomar decisiones y la preocupación por la desorganización, no son frecuentes ni intensos. "
                . "Esta puntuación sugiere que estas experiencias son comunes y no generan un malestar significativo.";
            } elseif ($value_t <= 63) {
                $resultado = "Indica que los síntomas obsesivo-compulsivos reportados son más frecuentes o intensos que los observados en la población general, "
                . "aunque no alcanzan una severidad alta. Síntomas como la necesidad de comprobar repetidamente las acciones y la dificultad para concentrarse "
                . "pueden estar presentes en mayor medida. Esta puntuación indica una mayor incidencia de síntomas obsesivo-compulsivos, aunque de intensidad moderada.";
            } elseif ($value_t >= 64) {
                $resultado = "Indica que los síntomas obsesivo-compulsivos son significativamente más frecuentes e intensos que en la población general. "
                . "Síntomas como pensamientos intrusivos no deseados, la necesidad de hacer las cosas muy despacio para asegurarse de que están bien hechas, "
                . "y los impulsos a realizar acciones de manera repetitiva son prominentes. Esta puntuación refleja una alta severidad de síntomas obsesivo-compulsivos.";
            }
            return $resultado;
        }

        if($valuestring == "Sensibilidad interpersonal"){
            if ($value_t <= 50) {
                $resultado = "Indica que los niveles de sensibilidad interpersonal se encuentran dentro del rango considerado normal. "
                . "Los sentimientos de timidez, vergüenza e incomodidad en las relaciones interpersonales no son frecuentes ni intensos. "
                . "Los síntomas, como sentirse incómodo cuando la gente le mira o hablar acerca de usted, son comunes y no generan un malestar significativo.";
            } elseif ($value_t <= 63) {
                $resultado = "Indica que los síntomas de sensibilidad interpersonal reportados son más frecuentes o intensos que los observados en la población general, "
                . "aunque no alcanzan una severidad alta. Síntomas como sentirse inferior a los demás y la sensación de que los demás no le comprenden "
                . "pueden estar presentes en mayor medida. Esta puntuación sugiere una mayor incidencia de síntomas de sensibilidad interpersonal, aunque de intensidad moderada.";
            } elseif ($value_t >= 64) {
                $resultado = "Indica que los síntomas de sensibilidad interpersonal son significativamente más frecuentes e intensos que en la población general. "
                . "Síntomas como la hipersensibilidad a las opiniones ajenas, sentirse muy cohibido o vergonzoso entre otras personas, "
                . "y la impresión de que otras personas son poco amistosas son prominentes. Esta puntuación refleja una alta severidad de síntomas de sensibilidad interpersonal.";
            }
            return $resultado;
        }

        if($valuestring == "Depresión"){
            if ($value_t <= 50) {
                $resultado = "Indica que los niveles de síntomas depresivos reportados están dentro del rango considerado normal. "
                . "Los sentimientos de tristeza, desánimo y falta de energía no son frecuentes ni intensos. "
                . "Estos síntomas se consideran comunes y no generan un malestar significativo.";
            } elseif ($value_t <= 63) {
                $resultado = "Indica que los síntomas depresivos reportados son más frecuentes o intensos que los observados en la población general, "
                . "aunque no alcanzan una severidad alta. Síntomas como sentirse bajo de energías, preocuparse demasiado por todo y sentirse solo "
                . "pueden estar presentes en mayor medida. Esta puntuación sugiere una mayor incidencia de síntomas depresivos, aunque de intensidad moderada.";
            } elseif ($value_t >= 64) {
                $resultado = "Indica que los síntomas depresivos son significativamente más frecuentes e intensos que en la población general. "
                . "Síntomas como pensamientos suicidas, sentirse desesperanzado con respecto al futuro y la sensación de ser inútil o no valer nada son prominentes. "
                . "Esta puntuación refleja una alta severidad de síntomas depresivos.";
            }
            return $resultado;
        }

        if($valuestring == "Hostilidad"){
            if ($value_t <= 50) {
                $resultado = "Indica que los niveles de hostilidad reportados están dentro del rango considerado normal. "
                . "Los síntomas como sentirse fácilmente molesto, tener discusiones frecuentes y sentir el impulso de romper algo "
                . "no son frecuentes ni intensos. Estos síntomas se consideran comunes y no generan un malestar significativo.";
            } elseif ($value_t <= 63) {
                $resultado = "Indica que los síntomas de hostilidad reportados son más frecuentes o intensos que los observados en la población general, "
                . "aunque no alcanzan una severidad alta. Síntomas como arrebatos de cólera, sentirse irritado o enfadado y gritar pueden estar presentes "
                . "en mayor medida. Esta puntuación sugiere una mayor incidencia de síntomas de hostilidad, aunque de intensidad moderada.";
            } elseif ($value_t >= 64) {
                $resultado = "Indica que los síntomas de hostilidad son significativamente más frecuentes e intensos que en la población general. "
                . "Síntomas como sentir el impulso de pegar o golpear a alguien, ataques de furia incontrolables y deseos de romper cosas son prominentes. "
                . "Esta puntuación refleja una alta severidad de síntomas de hostilidad.";
            }
            return $resultado;
        }

        if($valuestring == "Ansiedad fóbica"){
            if ($value_t <= 50) {
                $resultado = "Indica que los niveles de síntomas fóbicos reportados están dentro del rango considerado normal. "
                . "Los miedos y evitaciones, como el miedo a los espacios abiertos o a viajar en transporte público, no son frecuentes ni intensos. "
                . "Estos síntomas se consideran comunes y no generan un malestar significativo.";
            } elseif ($value_t <= 63) {
                $resultado = "Indica que los síntomas fóbicos reportados son más frecuentes o intensos que los observados en la población general, "
                . "aunque no alcanzan una severidad alta. Síntomas como el miedo a salir de casa solo, sentirse nervioso cuando se queda solo y evitar ciertas actividades "
                . "pueden estar presentes en mayor medida. Esta puntuación sugiere una mayor incidencia de síntomas fóbicos, aunque de intensidad moderada.";
            } elseif ($value_t >= 64) {
                $resultado = "Indica que los síntomas fóbicos son significativamente más frecuentes e intensos que en la población general. "
                . "Síntomas como sentir miedo a los espacios abiertos, tener miedo de desmayarse en público y sentirse incómodo entre mucha gente son prominentes. "
                . "Esta puntuación refleja una alta severidad de síntomas fóbicos.";
            }
            return $resultado;
        }

        if($valuestring == "Ideación paranoide"){
            if ($value_t <= 50) {
                $resultado = "Indica que los niveles de ideación paranoide reportados están dentro del rango considerado normal. "
                . "Los síntomas como la suspicacia, la idea de que uno no se puede fiar de la gente, y la sensación de que las otras personas le miran o hablan de él/ella, "
                . "no son frecuentes ni intensos. Estos síntomas se consideran comunes y no generan un malestar significativo.";
            } elseif ($value_t <= 63) {
                $resultado = "Indica que los síntomas de ideación paranoide reportados son más frecuentes o intensos que los observados en la población general, "
                . "aunque no alcanzan una severidad alta. Síntomas como la impresión de que la mayoría de los problemas son culpa de los demás, "
                . "la idea de que otros no le reconocen adecuadamente sus méritos y tener ideas o creencias que los demás no comparten, pueden estar presentes en mayor medida. "
                . "Esta puntuación sugiere una mayor incidencia de síntomas paranoides, aunque de intensidad moderada.";
            } elseif ($value_t >= 64) {
                $resultado = "Indica que los síntomas de ideación paranoide son significativamente más frecuentes e intensos que en la población general. "
                . "Síntomas como la impresión de que la mayoría de los problemas son culpa de los demás, la idea de que uno no se puede fiar de la gente, "
                . "y la impresión de que la gente intentaría aprovecharse de él/ella si se lo permitiera, son prominentes. "
                . "Esta puntuación refleja una alta severidad de síntomas paranoides.";
            }
            return $resultado;
        }

        if($valuestring == "Psicoticismo"){
            if ($value_t <= 50) {
                $resultado = "Indica que los niveles de síntomas psicóticos reportados están dentro del rango considerado normal. "
                . "Los síntomas, como la sensación de alienación social, la idea de que otra persona pueda controlar sus pensamientos y sentirse solo aunque esté con más gente, "
                . "no son frecuentes ni intensos. Estos síntomas se consideran comunes y no generan un malestar significativo.";
            } elseif ($value_t <= 63) {
                $resultado = "Indica que los síntomas de psicoticismo reportados son más frecuentes o intensos que los observados en la población general, "
                . "aunque no alcanzan una severidad alta. Síntomas como la impresión de que los demás se dan cuenta de lo que está pensando, tener pensamientos que no son suyos "
                . "y la idea de que algo serio anda mal en su cuerpo, pueden estar presentes en mayor medida. Esta puntuación sugiere una mayor incidencia de síntomas psicóticos, "
                . "aunque de intensidad moderada.";
            } elseif ($value_t >= 64) {
                $resultado = "Indica que los síntomas de psicoticismo son significativamente más frecuentes e intensos que en la población general. "
                . "Síntomas como oír voces que otras personas no oyen, la idea de que debería ser castigado por sus pecados o errores, "
                . "y la idea de que algo anda mal en su mente, son prominentes. Esta puntuación refleja una alta severidad de síntomas psicóticos.";
            }
            return $resultado;
        }
    }

    public function getTop($data_values,$response_ts){

        $data_tops = [];

        $data_response = [
            "Somatización" => "evalúa  la  presencia  de  malestares  que  la  persona  percibe  relacionados  con  diferentes  disfunciones corporales (cardiovasculares, gastrointestinales, respiratorios).",
            "Obsesión-compulsión" =>"describe conductas, pensamientos e impulsos que considera absurdos e indeseados, que generan intensa angustia y que son difíciles de resistir, evitar o eliminar, además de otras vivencias y fenómenos cognitivos característicos de los trastornos y personalidades obsesivas.", 
            "Sensibilidad interpersonal" => "recoge sentimientos de timidez y vergüenza, tendencia a sentirse inferior a los demás.",
            "Depresión" => "recoge signos y síntomas clínicos propios de los trastornos depresivos. Incluye vivencias disfóricas, de desánimo, anhedonia, desesperanza, impotencia y falta de energía, así como ideas autodestructivas.",
            "Ansiedad" => "evalúa  la  presencia  de    signos  generales  de  ansiedad  tales  como  nerviosismo,  tensión,  ataques de pánico, miedos.",
            "Hostilidad" => "evalúa pensamientos, sentimientos y conductas propios de estados de agresividad, ira, irritabilidad, rabia y resentimiento.",
            "Ansiedad fóbica" => "valora distintas variantes de la experiencia fóbica, entendida como un miedo persistente, irracional y desproporcionado a un animal o persona, lugar, objeto o situación.",
            "Ideación paranoide" => "recoge distintos aspectos de la conducta paranoide, considerada fundamentalmente como la respuesta a un trastorno de la ideación.",
            "Psicoticismo" => "configura un espectro psicótico que se extiende desde la esquizoidia y la esquizotipia leves hasta la psicosis florida. En la población general esta dimensión está más relacionada con sentimientos de alienación social que con psicosis clínicamente manifiesta."
            
        ];
        $i = 4;
        foreach ($data_values as $clave => $valor) {
            
            $message = $this->getResponse1($array[i]->,$response_ts[i]);
            $data_tops[] = ["name"=>$clave,"valor"=>$valor,"message1"=>$message,"message2"=>$data_response["$clave"]];
            if($i == 1){
                break;
            }
            $i -=1; 
        }
        return $data_tops;
    }
}
