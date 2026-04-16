<?php
class ModelLsbConfiguration {
    public function GetAux1($array,$compare){
        //Columna T,T54
        $resultado = 0;
        foreach ($array as $valor) {
            if ($valor >= 85 && $valor > $compare) {
                $resultado += 1;
            }
        }
        return $resultado;
    }

    public function GetAux2($array1,$array2,$compare1,$compare2){
        //Columna T,Columna S,T54, S54
        $resultado = 0;
        for ($i = 0; $i < count($array1); $i++) {
            if ($array1[$i] >= 85 && $array1[$i] == $compare1 && $array2[$i] > $compare2) {
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
            if ($T[$i] >= 85 && $T[$i] == $T54 && $S[$i] == $S54 && $R[$i] > $R54) {
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
            if ($T[$i] >= 85 && $T[$i] == $T54 && $S[$i] == $S54 && $R[$i] == $R54) {
                $resultado++;
            }
        }
        return $resultado;
    }

    public function getIndex($T,$S,$R,$compareT,$comparePD,$compareR,$sumIndirecta){
        $valor1 = $this->GetAux1($T,$compareT);
        $valor2 = $this->GetAux2($T,$S,$compareT,$comparePD);
        $valor3 = $this->GetAux3($T,$S,$R,$compareT,$comparePD,$compareR);
        $valor4 = $this->GetAux4($T,$S,$R,$compareT,$comparePD,$compareR,$sumIndirecta);
        //echo $valor4.'<br>';
        return 1+$valor1+$valor2+$valor3+$valor4;
    }

    public function getResponse($valuestring,$value_t){
        $descripcion = "";

        if($valuestring == "Psicoreactividad"){
            
            $I20 = $value_t; 
            $descripcion = "";

            if ($I20 <= 3) {
                $descripcion = "El resultado muestra un nivel de psicoreactividad considerablemente reducido. "
                    . "Se identifica una sensibilidad muy baja en la forma en que se percibe a sí mism@ y en su relación con su imagen personal y con los demás. "
                    . "La autoobservación está poco presente o es prácticamente inexistente. "
                    . "Es decir, no tiende a analizar lo que hace o lo que piensa, ni a prestar atención a su forma de actuar. "
                    . "Este perfil se distancia de manera importante de los niveles habituales en la población general.";
            }
            elseif ($I20 <= 16) {
                $descripcion = "El resultado indica un nivel de psicoreactividad por debajo del promedio. "
                    . "Se observa una menor sensibilidad al momento de percibirse a sí mism@ en relación con otras personas y en lo que respecta a su imagen personal. "
                    . "Tiende a mostrar una baja autoobservación, es decir, presta poca atención o dedica poco tiempo a reflexionar sobre lo que hace, cómo actúa o cómo piensa. "
                    . "Este funcionamiento se aleja ligeramente de lo que comúnmente se observa en la población general.";
            }
            elseif ($I20 <= 84) {
                $descripcion = "El resultado se encuentra dentro del rango promedio. "
                    . "Presenta una forma de percibirse a sí mism@ y de relacionarse con su imagen personal y con los demás que se ajusta a lo que es habitual en la mayoría de las personas. "
                    . "Se identifica un nivel de autoobservación moderado, que forma parte de un funcionamiento personal equilibrado. "
                    . "La atención que dedica a sus propios pensamientos y acciones se encuentra dentro de lo que se considera esperable y no presenta desviaciones relevantes.";
            }
            elseif ($I20 <= 96) {
                $descripcion = "El resultado indica que presenta un nivel de psicoreactividad por encima del promedio. "
                    . "Se identifica una sensibilidad elevada respecto a cómo se percibe a sí mism@ y cómo interpreta sus relaciones con los demás. "
                    . "Además, muestra una tendencia frecuente a detenerse en sus pensamientos, a analizar lo que hace y cómo actúa. "
                    . "Esta autoobservación está claramente presente en su estilo de funcionamiento personal y puede influir en su modo habitual de comportarse.";
            }
            elseif ($I20 >= 97) {
                $descripcion = "El resultado indica un nivel de psicoreactividad considerablemente elevado. "
                    . "Se observa una forma de percibirse a sí mism@ muy intens@, tanto en su imagen personal como en su relación con otras personas. "
                    . "Presenta una fuerte tendencia a vigilar y analizar de manera constante sus pensamientos, conductas y emociones. "
                    . "Esta autoobservación puede estar muy presente en su vida diaria y condicionar cómo actúa, cómo se comunica o cómo interpreta su experiencia interna. "
                    . "Este funcionamiento se sitúa muy por encima de lo que se espera en la mayoría de la población.";
            }


            return $descripcion;
        }

        if($valuestring == "Hipersensibilidad"){
            
            $I21 = $value_t; // Valor correspondiente a la celda I21
            $descripcion = "";

            if ($I21 <= 3) {
                $descripcion = "El resultado muestra un nivel de hipersensibilidad considerablemente bajo. "
                    . "No se observan indicios relevantes de incomodidad social, sentimientos de cohibición, susceptibilidad ante comentarios, ni una percepción negativa de sí mism@. "
                    . "Tampoco se identifican emociones asociadas a la soledad en presencia de otros ni preocupación por cómo es evaluad@ o percibid@. "
                    . "Este funcionamiento se aleja de manera clara del patrón habitual en la población general.";
            }
            elseif ($I21 <= 16) {
                $descripcion = "El resultado indica una hipersensibilidad reducida. "
                    . "Se observa una menor tendencia a sentirse afectad@ por la valoración de otras personas y una baja preocupación por cómo es percibid@ en contextos sociales. "
                    . "Tiende a experimentar con poca frecuencia sentimientos de inferioridad, incomodidad en público o la sensación de ser observad@ o rechazad@. "
                    . "Esta forma de percibir y procesar lo interpersonal y lo personal se encuentra por debajo de lo que se espera comúnmente.";
            }
            elseif ($I21 <= 84) {
                $descripcion = "El resultado se encuentra dentro del rango promedio. "
                    . "Presenta una sensibilidad interpersonal e intrapersonal similar a la de la mayoría de las personas. "
                    . "Puede experimentar ocasionalmente sentimientos de vergüenza, inseguridad o incomodidad en situaciones sociales, pero estos no predominan en su funcionamiento general. "
                    . "Del mismo modo, su autovaloración no se ve fuertemente condicionada por la opinión de los demás ni por la percepción de ser observad@ o juzgad@.";
            }
            elseif ($I21 <= 96) {
                $descripcion = "El resultado indica una hipersensibilidad superior a la habitual. "
                    . "Se identifica una sensibilidad marcada tanto en las relaciones con los demás como en la valoración personal. "
                    . "Presenta incomodidad en situaciones sociales simples, como comer o beber frente a otras personas, y tiende a interpretar ciertas actitudes como rechazo o incomprensión. "
                    . "Además, es habitual que se sienta afectad@ por comentarios y que experimente una sensación de no ser valorad@ como los demás.";
            }
            elseif ($I21 >= 97) {
                $descripcion = "El resultado indica un nivel de hipersensibilidad considerablemente elevado. "
                    . "Se observa una sensibilidad interpersonal e intrapersonal muy acentuada. "
                    . "Presenta una fuerte tendencia a sentirse cohibid@ ante otras personas, a experimentar con frecuencia la sensación de ser observad@, comentad@ o incomprendid@, y a sentirse herid@ por comentarios que percibe como negativos. "
                    . "También se identifican sentimientos persistentes de inferioridad y la vivencia de soledad incluso en presencia de otras personas. "
                    . "Este funcionamiento se sitúa notablemente por encima del promedio esperado.";
            }
            return $descripcion;
        }

        if($valuestring == "Obsesión-Compulsión"){
            
            $I22 = $value_t; // Valor correspondiente a la celda I22
            $descripcion = "";

            if ($I22 <= 3) {
                $descripcion = "El resultado muestra una ausencia o presencia mínima de síntomas obsesivo-compulsivos. "
                    . "No se observan pensamientos repetitivos, dudas persistentes ni conductas que deban repetirse de forma insistente. "
                    . "Tiende a tomar decisiones con facilidad, completar sus actividades sin dificultad y actuar sin la necesidad de revisar o repetir lo que hace. "
                    . "Esta forma de funcionamiento se encuentra considerablemente por debajo del promedio esperado en la población general.";
            }
            elseif ($I22 <= 16) {
                $descripcion = "El resultado indica una presencia reducida de síntomas obsesivo-compulsivos. "
                    . "Se identifica una baja frecuencia de pensamientos repetitivos no deseados o conductas compulsivas. "
                    . "Presenta una manera de actuar en la que las decisiones se toman con relativa facilidad, sin mostrar una necesidad persistente de revisar o comprobar. "
                    . "Tampoco se observa una preocupación constante por el orden o por repetir acciones.";
            }
            elseif ($I22 <= 84) {
                $descripcion = "El resultado se encuentra dentro del rango promedio. "
                    . "Se observan algunas preocupaciones relacionadas con el orden, la organización o la necesidad de comprobar ciertas acciones, "
                    . "pero estas se presentan en un nivel similar al que muestran la mayoría de las personas. "
                    . "También pueden estar presentes, en ocasiones, pensamientos repetitivos o cierta dificultad para tomar decisiones, "
                    . "pero sin que interfieran de forma importante en su funcionamiento.";
            }
            elseif ($I22 <= 96) {
                $descripcion = "El resultado indica un nivel elevado de síntomas relacionados con la obsesión y la compulsión. "
                    . "Presenta una tendencia a tener dudas constantes, pensamientos que se repiten sin desearlo y que generan incomodidad. "
                    . "Se identifica la necesidad de hacer ciertas acciones más de una vez, como comprobar o repetir tareas, así como una preocupación frecuente por el orden, la organización o la limpieza. "
                    . "También manifiesta dificultades para decidir y para dar por finalizadas ciertas actividades.";
            }
            elseif ($I22 >= 97) {
                $descripcion = "El resultado indica la presencia de síntomas obsesivo-compulsivos en un nivel considerablemente elevado. "
                    . "Se observa una fuerte tendencia a experimentar pensamientos no deseados que se repiten con frecuencia y que resultan difíciles de apartar de la mente. "
                    . "También se identifican conductas repetitivas, como la necesidad de comprobar varias veces lo que se hace, realizar tareas de forma lenta para asegurarse de que estén bien hechas o repetir ciertos actos, como el lavado. "
                    . "Asimismo, presenta dificultades para tomar decisiones y sensación de no poder terminar lo que comienza. "
                    . "Este funcionamiento se encuentra notablemente por encima del promedio observado en la población general.";
            }
            return $descripcion;
        }

        if($valuestring == "Ansiedad"){
            
            $I23 = $value_t; // Valor correspondiente a la celda I23
            $descripcion = "";

            if ($I23 <= 3) {
                $descripcion = "El resultado indica una ausencia o presencia mínima de manifestaciones de ansiedad. "
                    . "No se identifican síntomas relevantes relacionados con angustia, miedos irracionales, ni pensamientos o imágenes que generen temor. "
                    . "Tampoco se observan conductas de evitación ni sensaciones persistentes de peligro. "
                    . "Esta forma de experimentar el malestar ansioso se sitúa considerablemente por debajo del promedio esperado en la población general.";
            }
            elseif ($I23 <= 16) {
                $descripcion = "El resultado indica una presencia reducida de síntomas de ansiedad. "
                    . "Se identifica una menor frecuencia de nerviosismo, miedos o pensamientos que generen malestar. "
                    . "También se observa poca evitación de lugares o situaciones, y una baja aparición de sensaciones que indiquen temor sin causa aparente. "
                    . "Esta forma de funcionamiento se encuentra por debajo de lo que es común en la mayoría de las personas.";
            }
            elseif ($I23 <= 84) {
                $descripcion = "El resultado se sitúa dentro del rango promedio. "
                    . "Se observan manifestaciones de ansiedad que son compatibles con lo habitual en la población general. "
                    . "Puede experimentar ocasionalmente sensaciones de inquietud, miedos o evitación de ciertos espacios, pero estas no predominan. "
                    . "La frecuencia e intensidad de los síntomas se ajustan a lo esperable y no presentan desviaciones relevantes respecto al promedio.";
            }
            elseif ($I23 <= 96) {
                $descripcion = "El resultado indica un nivel de ansiedad superior al promedio. "
                    . "Se identifica una presencia habitual de síntomas como nerviosismo, preocupación constante o miedo intenso en determinadas situaciones. "
                    . "También puede presentar dificultad para permanecer en algunos lugares o salir de casa sin compañía. "
                    . "Se observan pensamientos intrusivos relacionados con el temor o imágenes que provocan angustia. "
                    . "Estas manifestaciones se encuentran en un nivel más alto que el que presentan la mayoría de las personas.";
            }
            elseif ($I23 >= 97) {
                $descripcion = "El resultado indica un nivel de ansiedad considerablemente elevado. "
                    . "Se observan manifestaciones frecuentes de inquietud interior, miedo o angustia, tanto en espacios abiertos como al quedarse sol@. "
                    . "También se identifica la presencia de pensamientos o imágenes que provocan temor, así como una tendencia a evitar ciertos lugares o situaciones por el malestar que generan. "
                    . "Es posible que experimente miedos repentinos sin una causa concreta o intuiciones persistentes de que algo malo va a suceder. "
                    . "Este patrón de funcionamiento se encuentra significativamente por encima de lo que se observa en la mayoría de las personas.";
            }
            return $descripcion;
        }

        if($valuestring == "Hostilidad"){
            
            $I24 = $value_t; // Valor correspondiente a la celda I24
            $descripcion = "";

            if ($I24 <= 3) {
                $descripcion = "El resultado indica que presenta una expresión de hostilidad considerablemente por debajo del promedio. "
                    . "Indica una baja presencia de reacciones de ira, agresividad o irritabilidad, así como escasa tendencia a tener conflictos verbales o físicos. "
                    . "También es poco frecuente la aparición de impulsos como lanzar objetos, discutir o experimentar pensamientos relacionados con el daño o la percepción constante de amenaza.";
            }
            elseif ($I24 <= 16) {
                $descripcion = "El resultado indica que presenta una expresión de hostilidad por debajo del promedio. "
                    . "Indica que las reacciones como el enojo, la irritabilidad, los impulsos agresivos o las discusiones interpersonales se presentan con menor frecuencia e intensidad que en la mayoría de las personas. "
                    . "Es posible que las conductas relacionadas con la pérdida de control emocional sean poco habituales.";
            }
            elseif ($I24 <= 84) {
                $descripcion = "El resultado indica que presenta una expresión de hostilidad dentro del rango promedio. "
                    . "Indica que las reacciones de enojo, irritabilidad o conflictos interpersonales se manifiestan con una frecuencia y una intensidad similares a las que se observan en la mayoría de las personas. "
                    . "Las expresiones de molestia, discusiones u otras manifestaciones de agresividad no destacan por ser ni especialmente frecuentes ni infrecuentes.";
            }
            elseif ($I24 <= 96) {
                $descripcion = "El resultado indica que presenta una expresión de hostilidad por encima del promedio. "
                    . "Indica una tendencia a experimentar reacciones de enojo que pueden incluir irritabilidad, dificultad para controlar la ira, discusiones frecuentes con otras personas o conductas impulsivas como lanzar objetos o manifestar agresividad verbal o física. "
                    . "También pueden aparecer pensamientos negativos relacionados con el entorno o con la percepción de peligro.";
            }
            elseif ($I24 >= 97) {
                $descripcion = "El resultado indica que presenta una expresión de hostilidad considerablemente por encima del promedio. "
                    . "Indica una mayor presencia de reacciones emocionales intensas que pueden manifestarse en impulsos de destruir objetos, irritabilidad frecuente, ataques de ira que resultan difíciles de controlar, discusiones constantes, o comportamientos que pueden incluir gritos, arrojar objetos o agresiones hacia otras personas.";
            }
            return $descripcion;
        }

        if($valuestring == "Somatización"){
            
            $I25 = $value_t; // Valor correspondiente a la celda I25
            $descripcion = "";

            if ($I25 <= 3) {
                $descripcion = "El resultado indica que presenta un nivel de síntomas somáticos considerablemente por debajo del promedio. "
                    . "Indica que síntomas como dolores corporales, molestias estomacales, mareos o dificultad respiratoria están ausentes o se manifiestan de forma infrecuente.";
            }
            elseif ($I25 <= 16) {
                $descripcion = "El resultado indica que presenta un nivel de síntomas somáticos por debajo del promedio. "
                    . "Indica una frecuencia menor de malestares corporales como palpitaciones, dolores musculares, náuseas o dificultad para respirar, en comparación con lo que se observa habitualmente en la población general.";
            }
            elseif ($I25 <= 84) {
                $descripcion = "El resultado indica que presenta un nivel de síntomas somáticos dentro del rango promedio. "
                    . "Indica que las manifestaciones físicas como molestias gastrointestinales, dolores de cabeza o tensión muscular se presentan con una frecuencia e intensidad similares a las observadas en la mayoría de las personas.";
            }
            elseif ($I25 <= 96) {
                $descripcion = "El resultado indica que presenta un nivel de síntomas somáticos por encima del promedio. "
                    . "Indica una mayor presencia de manifestaciones físicas como dolores musculares, palpitaciones, molestias estomacales, entumecimiento o sensación de ahogo, que pueden estar asociadas a desequilibrios funcionales vinculados a procesos de somatización.";
            }
            elseif ($I25 >= 97) {
                $descripcion = "El resultado indica que presenta un nivel de síntomas somáticos considerablemente por encima del promedio. "
                    . "Indica una presencia elevada de malestares corporales que pueden incluir palpitaciones, mareos, dolores musculares, molestias digestivas, dolor en el pecho o dificultad para respirar, los cuales pueden estar relacionados con procesos de somatización psicológica.";
            }
            return $descripcion;
        }

        if($valuestring == "Depresión"){
            
            $I26 = $value_t; // Valor correspondiente a la celda I26
            $descripcion = "";

            if ($I26 <= 3) {
                $descripcion = "El resultado indica que presenta un nivel de síntomas depresivos considerablemente por debajo del promedio. "
                    . "Indica una escasa presencia de manifestaciones relacionadas con la tristeza, la anhedonia, la desesperanza o el sentimiento de culpa. "
                    . "Las ideas de inutilidad, soledad o pensamientos relacionados con el deseo de desaparecer están prácticamente ausentes.";
            }
            elseif ($I26 <= 16) {
                $descripcion = "El resultado indica que presenta un nivel de síntomas depresivos por debajo del promedio. "
                    . "Indica que las sensaciones de tristeza, pérdida de interés, desesperanza o culpa son poco frecuentes. "
                    . "Asimismo, es poco habitual que exprese sentimientos de inutilidad, soledad o ideas relacionadas con el llanto o la ideación autodestructiva.";
            }
            elseif ($I26 <= 84) {
                $descripcion = "El resultado indica que presenta un nivel de síntomas depresivos dentro del rango promedio. "
                    . "Indica que las experiencias relacionadas con el desánimo, la falta de interés, el cansancio emocional o los sentimientos de inutilidad se manifiestan con una frecuencia similar a la de la mayoría de las personas, "
                    . "sin que predominen de forma constante o intensa.";
            }
            elseif ($I26 <= 96) {
                $descripcion = "El resultado indica que presenta un nivel de síntomas depresivos por encima del promedio. "
                    . "Indica que tiende a experimentar tristeza persistente, desánimo, escaso interés por las cosas, sentimientos de soledad, llanto fácil o dificultades para encontrar sentido a sus acciones. "
                    . "También pueden estar presentes sentimientos de culpa, cansancio emocional o pensamientos relacionados con la falta de esperanza.";
            }
            elseif ($I26 >= 97) {
                $descripcion = "El resultado indica que presenta un nivel de síntomas depresivos considerablemente por encima del promedio. "
                    . "Indica la presencia frecuente de sensaciones de tristeza, falta de energía, desesperanza sobre el futuro, pérdida de interés por las actividades cotidianas, "
                    . "sentimientos de inutilidad o culpa, así como pensamientos relacionados con la muerte o el deseo de desaparecer. "
                    . "También puede experimentar una sensación constante de vacío, soledad o necesidad de realizar grandes esfuerzos, incluso para actividades simples.";
            }
            return $descripcion;
        }

        if($valuestring == "Alteración de sueño"){
            
            $I27 = $value_t; // Valor correspondiente a la celda I27
            $descripcion = "";

            if ($I27 <= 3) {
                $descripcion = "El resultado indica que presenta alteraciones del sueño considerablemente por debajo del promedio. "
                    . "Indica que rara vez experimenta dificultades para conciliar el sueño, despertares durante la noche o sensación de sueño alterado.";
            }
            elseif ($I27 <= 16) {
                $descripcion = "El resultado indica que presenta alteraciones del sueño por debajo del promedio. "
                    . "Indica que las manifestaciones como dificultades para iniciar el sueño, interrupciones durante la noche o sueño agitado se presentan con menor frecuencia que en la mayoría de las personas.";
            }
            elseif ($I27 <= 84) {
                $descripcion = "El resultado indica que presenta alteraciones del sueño dentro del rango promedio. "
                    . "Indica que los problemas para dormir, como los despertares nocturnos o la sensación de un sueño inquieto, ocurren con una frecuencia similar a la que se observa comúnmente en la población general.";
            }
            elseif ($I27 <= 96) {
                $descripcion = "El resultado indica que presenta alteraciones del sueño por encima del promedio. "
                    . "Indica que las dificultades para conciliar el sueño, los despertares a lo largo de la noche o la sensación de tener un descanso alterado se manifiestan con mayor frecuencia que en la mayoría de las personas.";
            }
            elseif ($I27 >= 97) {
                $descripcion = "El resultado indica que presenta alteraciones del sueño considerablemente por encima del promedio. "
                    . "Indica que experimenta con frecuencia dificultades para iniciar el sueño, despertares durante la madrugada o un descanso nocturno agitado, lo cual puede repercutir en su bienestar general.";
            }
            return $descripcion;
        }

        if($valuestring == "Alteración de sueño - ampliada"){
            
            $I28 = $value_t; // Valor correspondiente a la celda I28
            $descripcion = "";

            if ($I28 <= 3) {
                $descripcion = "El resultado indica que presenta alteraciones del sueño ampliadas considerablemente por debajo del promedio. "
                    . "Indica que las dificultades relacionadas con el sueño, como los despertares nocturnos, el sueño agitado o la presencia de pensamientos asociados al temor o a la tristeza, "
                    . "están ausentes o se presentan de manera muy ocasional.";
            }
            elseif ($I28 <= 16) {
                $descripcion = "El resultado indica que presenta alteraciones del sueño ampliadas por debajo del promedio. "
                    . "Indica que las dificultades para dormir y las experiencias asociadas, como la tristeza, los pensamientos que generan temor o los sentimientos de soledad, son poco frecuentes.";
            }
            elseif ($I28 <= 84) {
                $descripcion = "El resultado indica que presenta alteraciones del sueño ampliadas dentro del rango promedio. "
                    . "Indica que los problemas relacionados con el sueño, así como los contenidos emocionales que se vinculan con estas dificultades —como la tristeza o los pensamientos inquietantes— "
                    . "se presentan con una frecuencia similar a la observada en la mayoría de las personas.";
            }
            elseif ($I28 <= 96) {
                $descripcion = "El resultado indica que presenta alteraciones del sueño ampliadas por encima del promedio. "
                    . "Indica que las dificultades relacionadas con el sueño, como el descanso interrumpido o la dificultad para iniciar el sueño, se asocian con la presencia de malestar emocional, "
                    . "expresado en sensaciones de tristeza, pensamientos que provocan miedo, soledad o percepciones negativas del entorno.";
            }
            elseif ($I28 >= 97) {
                $descripcion = "El resultado indica que presenta alteraciones del sueño ampliadas considerablemente por encima del promedio. "
                    . "Indica la presencia frecuente de dificultades para dormir, como despertares en la madrugada, sueño agitado o problemas para conciliar el sueño, acompañadas de "
                    . "sensaciones de tristeza, pensamientos o imágenes que generan temor, sentimientos de soledad o intuiciones de que algo malo podría suceder.";
            }

            return $descripcion;
        }
    }

    public function getTop($data_values,$data_ts){

        $data_tops = [];

        $data_response = [
            "Psicoreactividad" => "evalúa la sensibilidad en la percepción de uno mismo en relación con los demás y la propia imagen.",
            "Hipersensibilidad" =>"explora la sensibilidad tanto interpersonal como intrapersonal, incluye sentimientos de vergüenza, sensación de ser incomprendido, susceptibilidad a los comentarios de otros, y sentimientos de inferioridad.", 
            "Obsesión-Compulsión" => "examina la existencia de rituales o compulsiones, incluye preocupaciones por el orden, la necesidad de comprobar las cosas repetidamente, dificultades para tomar decisiones, y pensamientos intrusivos no deseados.",
            "Ansiedad" => "explora manifestaciones de ansiedad generalizada, pánico y ansiedad fóbica.",
            "Hostilidad" => "evalúa reacciones de pérdida de control emocional con manifestaciones de agresividad, ira o resentimiento.",
            "Somatización" => "explora la presencia de malestares somáticos o corporales debidos a procesos de somatización psicológica.",
            "Depresión" => "evalúa síntomas característicos de la depresión como tristeza, desesperanza, anhedonia e ideación autodestructiva.",
            "Alteración de sueño" => "explora problemas específicos relacionados con el sueño.",
            "Alteración de sueño - ampliada" => "evalúa la presencia específica de alteraciones del sueño junto con manifestaciones de las escalas Ansiedad y Depresión que clínicamente están asociadas a problemas de sueño."
            
        ];
        $i = 4;
        foreach ($data_values as $clave => $valor) {
            
            $message = $this->getResponse($clave,$data_ts["$clave"]);
            $data_tops[] = ["name"=>$clave,"valor"=>$valor,"message1"=>$message,"message2"=>$data_response["$clave"]];
            if($i == 1){
                break;
            }
            $i -=1; 
        }
        return $data_tops;
    }
}