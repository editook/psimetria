<?php
class ModelIpprConfiguration {
    public function sumatoria($answers,$options){
        $total = 0;
        foreach($answers as $answer){
            foreach($options as $option){
                if($answer['item_order'] == $option){
                    $value = 0;
                    if($answer['response'] == null || $answer['response'] == '-1'){
                        $value = 0;
                    }
                    else{
                        $value = ((int)$answer['response']);
                    }
                    $total += $value;
                }
            }
        }
        return $total;
    }
    
    public function getQuestion($answers,$item_order){
        foreach($answers as $answer){
            if($answer['item_order'] == $item_order){
                return $answer['response'];
            }
        }
        return "";
    }
    public function getByItemOrder($answers,$item_order){

        foreach($answers as $answer){
            if($answer['item_order'] == $item_order){
                return $answer;
            }
        }
        return [];
    }
    private function countItemAnswers($answers){
        $countA = 0;
        $countB = 0;
        $countC = 0;
        $countD = 0;

        foreach($answers as $answer){
            if($answer['response'] != null){
                switch($answer['response']){
                    case "2":$countA+=1;break;
                    case "1":$countB+=1;break;
                    case "0":$countC+=1;break;
                    case "-1":$countD+=1;break;
                }
            }
        }
        return
        [
            "total"=>($countA+$countB+$countC+$countD),
            "A"=>$countA,
            "B" => $countB,
            "C" => $countC,
            "D" => $countD,
        ];
    }
    public function getResponseJson($answers){
        /*
        |--------------------------------------------------------------------------
        | RESPUESTAS
        |--------------------------------------------------------------------------
        | Q = A
        | R = B
        | S = C
        | T = D
        |--------------------------------------------------------------------------
        */
        $counts = $this->countItemAnswers($answers);
        
        $totalRespondidas = $counts["total"];

        $countA = $counts["A"];
        $countB = $counts["D"];
        $countC = $counts["C"];
        $countD = $counts["D"];

        $porcentaje = round(($totalRespondidas / 180) * 100, 1);
        
        $texto =
             "Número de respuestas anotadas: {$totalRespondidas} de 180 elementos "
            . "({$porcentaje}%).\n"

            . "Distribución de respuestas: "
            . "A={$countA} | "
            . "B={$countB} | "
            . "C={$countC} | "
            . "D={$countD}";
        return ["text"=>nl2br($texto),"total"=>$totalRespondidas];
    }
    function getResponseJsonMessage(int $totalRespondidas){
        if ($totalRespondidas < 90) {

            $mensajeFinal = "ATENCIÓN: El porcentaje de respuestas es inferior al 50%. "
                . "Se considera que el resultado NO es adecuado para una interpretación. "
                . "Se recomienda repetir la aplicación.";

        } elseif ($totalRespondidas < 126) {

            $mensajeFinal = "PRECAUCIÓN: El porcentaje de respuestas es inferior al 70% "
                . "(126 elementos). La interpretación debe hacerse con cautela.";

        } else {

            $mensajeFinal = "El número de respuestas es adecuado para una interpretación válida (≥70%).";
        }
        return $mensajeFinal;
    }
    function evaluarInteres(int $valor) {
        if ($valor <= 3) {
            return "Muy bajo interés alas";
        } elseif ($valor <= 16) {
            return "Bajo interés alas";
        } elseif ($valor <= 84) {
            return "que se adapta alas";
        } elseif ($valor <= 97) {
            return "un Alto interés alas";
        } elseif ($valor <= 99) {
            return "Muy alto interés alas";
        } else {
            return "interés fuera de rango";
        }
    }
    public function GetValueOrder(
        int $cientifico_pr_pc,
        int $tecnico_pr_pc,
        int $sanidad_pr_pc,
        int $cientificosocial_pr_pc,
        int $juridicosocial_pr_pc,
        int $comunicacion_pr_pc,
        int $psicopedagogia_pr_pc,
        int $empresarial_admin_pr_pc,
        int $informatica_pr_pc,
        int $agrario_pr_pc,
        int $artistico_plastico_pr_pc,
        int $artistico_musical_pr_pc,
        int $fuerzas_pr_pc,
        int $deportes_pr_pc,
        int $turismo_pr_pc,
        //
        int $cientifico_ac_pc,
        int $tecnico_ac_pc,
        int $sanidad_ac_pc,
        int $cientificosocial_ac_pc,
        int $juridicosocial_ac_pc,
        int $comunicacion_ac_pc,
        int $psicopedagogia_ac_pc,
        int $emacesarial_admin_ac_pc,
        int $informatica_ac_pc,
        int $agrario_ac_pc,
        int $artistico_plastico_ac_pc,
        int $artistico_musical_ac_pc,
        int $fuerzas_ac_pc,
        int $deportes_ac_pc,
        int $turismo_ac_pc){

       $items_pr = [
        [htmlspecialchars("CIENTIFICO")=>["ac"=>$cientifico_ac_pc,"pr"=>$cientifico_pr_pc,"valor" => $cientifico_pr_pc+(15-14+2)*0.001,"interes"=>$this->evaluarInteres($cientifico_pr_pc),"profesion"=>"Geólogo, Biólogo, Astrónomo, Químico, Licenciado en Ciencias Ambientales, Físico."]],
        [htmlspecialchars("TECNICO")=>["ac"=>$tecnico_ac_pc,"pr"=>$tecnico_pr_pc,"valor" => $tecnico_pr_pc+(15-16+2)*0.001,"interes"=>$this->evaluarInteres($tecnico_pr_pc),"profesion"=>"Arquitecto, Aparejador, Ingeniero de Telecomunicación, Aeronáutico, en Electrónica, de Caminos o Industrial. Ingeniero técnico en cualquiera de estas materias."]],
        [htmlspecialchars("SANIDAD")=>["ac"=>$sanidad_ac_pc,"pr"=>$sanidad_pr_pc,"valor" => $sanidad_pr_pc+(15-18+2)*0.001,"interes"=>$this->evaluarInteres($sanidad_pr_pc),"profesion"=>"Médico, Fisioterapeuta, Odontólogo, Dietista, Oftalmólogo. Médico especialista (cardiólogo, pediatra, traumatólogo, etc.), Psicólogo, Psiquiatra."]],
        [htmlspecialchars("CIENTIFICO SOCIAL | HUMANIDADES")=>["ac"=>$cientificosocial_ac_pc,"pr"=>$cientificosocial_pr_pc,"valor" => $cientificosocial_pr_pc+(15-21+2)*0.001,"interes"=>$this->evaluarInteres($cientificosocial_pr_pc),"profesion"=>"Historiador, Especialista en arte (pintura, arquitectura, escultura, etc.), Sociólogo, Filósofo, Trabajador social, Arqueólogo, Antropólogo."]],
        [htmlspecialchars("JURÍDICO SOCIAL")=>["ac"=>$juridicosocial_ac_pc,"pr"=>$juridicosocial_pr_pc,"valor" => $juridicosocial_pr_pc+(15-23+2)*0.001,"interes"=>$this->evaluarInteres($juridicosocial_pr_pc),"profesion"=>"Abogado, Investigador privado, Diplomado en relaciones laborales, Diplomático, Licenciado en Ciencias del Trabajo, Criminólogo."]],
        [htmlspecialchars("COMUNICACION INFORMACION")=>["ac"=>$comunicacion_ac_pc,"pr"=>$comunicacion_pr_pc,"valor" => $comunicacion_pr_pc+(15-26+2)*0.001,"interes"=>$this->evaluarInteres($comunicacion_pr_pc),"profesion"=>"Periodista, Licenciado en Comunicación Audiovisual, Técnico en Imagen o en Sonido, Director-realizador de medios audiovisuales."]],
        [htmlspecialchars("PSICOPEDAGOGICO")=>["ac"=>$psicopedagogia_ac_pc,"pr"=>$psicopedagogia_pr_pc,"valor" => $psicopedagogia_pr_pc+(15-28+2)*0.001,"interes"=>$this->evaluarInteres($psicopedagogia_pr_pc),"profesion"=>"Pedagogo, Psicólogo escolar, Educador social, Maestro de educación especial, Maestro especialista en educación física, Técnico en educación infantil. Profesor (de Primaria, de Bachillerato, etc.)."]],
        [htmlspecialchars("EMPRESARIAL | ADMINISTRATIVO | COMERCIAL")=>["ac"=>$emacesarial_admin_ac_pc,"pr"=>$empresarial_admin_pr_pc,"valor" => $empresarial_admin_pr_pc+(15-31+2)*0.001,"interes"=>$this->evaluarInteres($empresarial_admin_pr_pc),"profesion"=>"Economista, Licenciado en Ciencias Actuariales y Financieras, Técnico en gestión comercial, Administrador de fincas, Agente de la propiedad inmobiliaria. Gestor administrativo."]],
        [htmlspecialchars("INFORMATICA")=>["ac"=>$informatica_ac_pc,"pr"=>$informatica_pr_pc,"valor" => $informatica_pr_pc+(15-33+2)*0.001,"interes"=>$this->evaluarInteres($informatica_pr_pc),"profesion"=>"Ingeniero en informática, Técnico superior en desarrollo de aplicaciones informáticas, Técnico superior en administración de sistemas informáticos, Ingeniero técnico en informática de gestión. Especialista en Telemática (combinación de servicios de informática y telecomunicación)."]],
        [htmlspecialchars("AGRARIO | AGROPECUARIO | AMBIENTAL")=>["ac"=>$agrario_ac_pc,"pr"=>$agrario_pr_pc,"valor" => $agrario_pr_pc+(15-36+2)*0.001,"interes"=>$this->evaluarInteres($agrario_pr_pc),"profesion"=>"Ingeniero agrónomo, Ingeniero de montes, Veterinario, Ingeniero técnico agrícola, Técnico en trabajos forestales y conservación del medio ambiente."]],
        [htmlspecialchars("ARTISTICO - PLASTICO | ARTESANIA | MODA")=>["ac"=>$artistico_plastico_ac_pc,"pr"=>$artistico_plastico_pr_pc,"valor" => $artistico_plastico_pr_pc+(15-38+2)*0.001,"interes"=>$this->evaluarInteres($artistico_plastico_pr_pc),"profesion"=>"Dibujante, Restaurador de bienes culturales, Ilustrador de publicaciones, Diseñador de interiores, Ceramista, Técnico en artes gráficas y diseño. Diseñador de moda."]],
        [htmlspecialchars("ARTÍSTICO MUSICAL | ESPECTÁCULO")=>["ac"=>$artistico_musical_ac_pc,"pr"=>$artistico_musical_pr_pc,"valor" => $artistico_musical_pr_pc+(15-41+2)*0.001,"interes"=>$this->evaluarInteres($artistico_musical_pr_pc),"profesion"=>"Cantante, Actor profesional, Actor de doblaje, Músico instrumentista, Bailarín, Musicólogo."]],
        [htmlspecialchars("FUERZAS ARMADAS | SEGURIDAD | PROTECCION")=>["ac"=>$fuerzas_ac_pc,"pr"=>$fuerzas_pr_pc,"valor" => $fuerzas_pr_pc+(15-43+2)*0.001,"interes"=>$this->evaluarInteres($fuerzas_pr_pc),"profesion"=>"Policía, Vigilante jurado, Oficial de carrera del Ejército, Bombero, Especialista del Ejército, Técnico en salvamento acuático."]],
        [htmlspecialchars("DEPORTIVO")=>["ac"=>$deportes_ac_pc,"pr"=>$deportes_pr_pc,"valor" => $deportes_pr_pc+(15-46+2)*0.001,"interes"=>$this->evaluarInteres($deportes_pr_pc),"profesion"=>"Conductor de actividades deportivas, Técnico deportivo, Licenciado en Ciencias de la Actividad Física, Masajista deportivo, Entrenador, Animador deportivo."]],
        [htmlspecialchars("TURISMO Y HOTELERIA")=>["ac"=>$turismo_ac_pc,"pr"=>$turismo_pr_pc,"valor" => $turismo_pr_pc+(15-48+2)*0.001,"interes"=>$this->evaluarInteres($turismo_pr_pc),"profesion"=>"Técnico de animación turística, Técnico en turismo, Tripulante de cabina o auxiliar de barco, Técnico en información turística. Técnico superior de alojamiento, Técnico en restauración."]]
       ];

       $actividades_ac = [
        htmlspecialchars("CIENTIFICO")=>["interes"=>"Estudiar los seres vivos, la tierra y sus componentes y los fenómenos del firmamento. Aplicar los conocimientos sobre propiedades de la materia a la medicina, la agricultura, la alimentación, etc. Aplicar conocimientos científicos sobre el medio ambiente a la conservación de recursos naturales. Investigar sobre el mar como fuente de riqueza. Investigar en óptica, electrónica, etc."],
        htmlspecialchars("TECNICO")=>["interes"=>"Proyectar edificios y zonas urbanas y dirigir las obras de los mismos. Diseñar instalaciones para las comunicaciones (radar, telefonía, radio, etc.). Realizar proyectos para construir puertos, carreteras o puentes. Desarrollar proyectos de electrónica aplicada a la industria. Controlar el tráfico aéreo."],
        htmlspecialchars("SANIDAD")=>["interes"=> "Examinar a los enfermos y establecer diagnósticos para diversas enfermedades. Realizar intervenciones quirúrgicas. Establecer y realizar tratamientos de rehabilitación. Tratar las enfermedades de la dentadura. Conocer los usos y efectos de los medicamentos. Establecer y controlar dietas y planes alimenticios. Colaborar con el médico en el tratamiento de los enfermos."],
        htmlspecialchars("CIENTIFICO SOCIAL | HUMANIDADES")=>["interes"=>"Estudiar la actuación del hombre a lo largo del tiempo. Aplicar los conocimientos sobre arte en la enseñanza o en publicaciones. Interpretar o traducir textos. Estudiar los grupos humanos y sus relaciones. Estudiar los fundamentos de la religión católica y la historia comparada de las religiones. Cooperar con las personas para resolver problemas sociales."],
        htmlspecialchars("JURÍDICO SOCIAL")=>["interes"=>"Intervenir ante los tribunales de justicia o formar parte de ellos. Asesorar sobre temas jurídicos. Hacer indagaciones sobre comportamientos delictivos. Asesorar en conflictos laborales. Representar a empresas o trabajadores ante tribunales de lo social. Analizar los crímenes o delitos y su relación con el delincuente. Representar al propio país en otros países."],
        htmlspecialchars("COMUNICACION INFORMACION")=>["interes"=>"Buscar y redactar noticias para publicarlas. Diseñar campañas o elementos de publicidad. Estudiar procesos y técnicas de medios audiovisuales. Obtener imágenes con cámara fotográfica, vídeo, cámara cinematográfica, etc., y presentarlas o publicarlas. Registrar y reproducir sonidos."],
        htmlspecialchars("PSICOPEDAGOGICO")=>["interes"=>"Analizar o idear técnicas de enseñanza y procedimientos educativos. Evaluar las aptitudes de los alumnos. Aconsejar sobre métodos para resolver problemas de aprendizaje o de adaptación. Trabajar en educación de adultos o integración de discapacitados. Enseñar a alumnos con necesidades especiales. Impartir enseñanzas de educación física. Cooperar en la educación de niños de cero a tres años."],
        htmlspecialchars("EMPRESARIAL | ADMINISTRATIVO | COMERCIAL")=>["interes"=>"Interpretar y resolver problemas prácticos en las empresas. Establecer planes de crecimiento en empresas. Aplicar conocimientos técnicos en el campo de los seguros. Realizar planes de comercialización de productos. Establecer comunidades de propietarios, elaborar las actas y los estatutos de las mismas. Actuar como mediador en alquiler, compra o venta de pisos o fincas. Realizar trámites administrativos en nombre de otros."],
        htmlspecialchars("INFORMATICA")=>["interes"=>"Realizar tareas especializadas en campos de la informática: análisis y arquitectura de los ordenadores. Efectuar la programación de aplicaciones informáticas. Crear o manejar los sistemas informáticos para la administración de empresas. Elaborar software de gestión para empresas. Realizar trabajos de informática aplicada a las comunicaciones. Trabajar en el tratamiento de datos aplicando informática, electrónica y telecomunicación."],
        htmlspecialchars("AGRARIO | AGROPECUARIO | AMBIENTAL")=>["interes"=>"Organizar explotaciones agrícolas o agropecuarias para mejorar productos vegetales y razas animales. Impulsar el desarrollo de espacios naturales. Decidir sobre la repoblación de bosques. Dirigir fincas agrícolas, mejorar su producción. Prevenir, diagnosticar y tratar las enfermedades de los animales. Realizar tareas de vigilancia y protección del medio ambiente en bosques, jardines o parques."],
        htmlspecialchars("ARTISTICO - PLASTICO | ARTESANIA | MODA")=>["interes"=>"Conservar y restaurar bienes culturales (esculturas, cuadros, elementos arqueológicos, etc.) sin alterarlos. Ilustrar libros empleando diversas técnicas de expresión gráfica. Crear diseños para la mejora de espacios interiores. Dibujar o diseñar con ordenador elementos para decoración textil, cerámica o mobiliario. Diseñar y elaborar elementos relacionados con la moda. Crear piezas de cerámica."],
        htmlspecialchars("ARTÍSTICO MUSICAL | ESPECTÁCULO")=>["interes"=>"Representar un personaje en el teatro, el cine o la televisión. Doblar las voces de actores extranjeros para las versiones traducidas de películas. Dar recitales o conciertos interpretando canciones como solista o formando parte de un grupo. Bailar en representaciones públicas interpretando danza clásica o moderna. Formar parte de una orquesta o actuar como solista tocando un instrumento. Investigar la historia de la música, sus técnicas y métodos."],
        htmlspecialchars("FUERZAS ARMADAS | SEGURIDAD | PROTECCION")=>["interes"=>"Realizar trabajos técnicos o de mando formando parte del Ejército. Trabajar para garantizar la seguridad de los ciudadanos y el ejercicio de las libertades. Custodiar establecimientos, oficinas, etc., para evitar robos u otros delitos. Apagar incendios o realizar trabajos para prevenirlos. Rescatar y practicar los primeros auxilios a personas en situación de riesgo. Ejecutar trabajos de mecánica, electricidad, electrónica, etc. formando parte del Ejército."],
        htmlspecialchars("DEPORTIVO")=>["interes"=>"Asesorar sobre deporte y actividad física en centros escolares o deportivos. Dirigir expediciones por senderos o zonas de montaña, andando, en bicicleta, etc. Enseñar la práctica de algún deporte. Ayudar a los deportistas a recuperarse de sus lesiones mediante masaje. Organizar actividades físicas en centros escolares, de salud, etc. Entrenar a deportistas."],
        htmlspecialchars("TURISMO Y HOTELERIA")=>["interes"=>"Establecer destinos o rutas turísticas. Preparar programas de actividades de animación y llevarlas a cabo. Procurar la mejora del turismo. Dirigir restaurantes o preparar alimentos. Atender a los pasajeros en aviones o barcos. Organizar la acogida de los clientes en un hotel."]
       ];

        $total_abs = $this->getValueAbs($cientifico_pr_pc , $cientifico_ac_pc);
        $total_abs += $this->getValueAbs($tecnico_pr_pc , $tecnico_ac_pc);
        $total_abs += $this->getValueAbs($sanidad_pr_pc , $sanidad_ac_pc);
        $total_abs += $this->getValueAbs($cientificosocial_pr_pc , $cientificosocial_ac_pc);
        $total_abs += $this->getValueAbs($juridicosocial_pr_pc , $juridicosocial_ac_pc);
        $total_abs += $this->getValueAbs($comunicacion_pr_pc , $comunicacion_ac_pc);
        $total_abs += $this->getValueAbs($psicopedagogia_pr_pc , $psicopedagogia_ac_pc);
        $total_abs += $this->getValueAbs($empresarial_admin_pr_pc , $emacesarial_admin_ac_pc);
        $total_abs += $this->getValueAbs($informatica_pr_pc , $informatica_ac_pc);
        $total_abs += $this->getValueAbs($agrario_pr_pc , $agrario_ac_pc);
        $total_abs += $this->getValueAbs($artistico_plastico_pr_pc , $artistico_plastico_ac_pc);
        $total_abs += $this->getValueAbs($artistico_musical_pr_pc , $artistico_musical_ac_pc);
        $total_abs += $this->getValueAbs($fuerzas_pr_pc , $fuerzas_ac_pc);
        $total_abs += $this->getValueAbs($deportes_pr_pc , $deportes_ac_pc);
        $total_abs += $this->getValueAbs($turismo_pr_pc , $turismo_ac_pc);
        
        usort($items_pr, function ($a, $b) {

            $valorA = current($a)["valor"];
            $valorB = current($b)["valor"];

            return $valorB <=> $valorA;

        });

        return ["resultados"=>$items_pr,"actividades"=>$actividades_ac,"discrepancia"=>$total_abs];
    }
    function getValueAbs(int $v1,int $v2){
        $result = abs($v1 - $v2) >= 10;
        if($result){
            return 1;
        }
        return 0;
    }
    function getValueRechazo(int $v1,int $v2){
        
        if($v1 <= 16 && $v2 <= 16){
            return 1;
        }
        return 0;
    }
    function clasificarNivel(float $valor){
        if ($valor >= 97) {
            return "muy elevado";
        }

        if ($valor >= 84) {
            return "elevado";
        }

        if ($valor >= 70) {
            return "medio alto";
        }

        if ($valor >= 30) {
            return "medio";
        }

        if ($valor >= 16) {
            return "medio bajo";
        }

        if ($valor >= 4) {
            return "bajo";
        }

        return "muy bajo";
    }
    function evaluarInteresSecundario(float $valor) {
        $valor = round($valor);
       
        if ($valor >= 97) {
            return "Interés muy elevado";
        } elseif ($valor >= 84) {
            return "Interés elevado";
        } elseif ($valor >= 70) {
            return "Interés medio alto";
        } elseif ($valor >= 30) {
            return "Interés medio";
        } elseif ($valor >= 16) {
            return "Interés medio bajo";
        } elseif ($valor >= 4) {
            return "Interés bajo";
        } else {
            return "Interés muy bajo";
        }
    }
}
