<?php
class AnswerService
{
    private $answerModel;
    private $registerModel;

    public function __construct($answerModel, $registerModel)
    {
        $this->answerModel = $answerModel;
        $this->registerModel = $registerModel;
    }

    public function processForm(array $post, $force_terminate = false): array
    {
        $idUser    = $post['idClient'] ?? null;
        $idpatient = $post['patient'] ?? null;
        $codes     = $post['codes'] ?? null;

        $other_answer = $_POST['other_answer'] ?? null; //maci
        // Guardar respuestas
        foreach ($post as $key => $value) {
            if (strpos($key, 'question_') === 0) {
                $question_id = str_replace('question_', '', $key);
                $this->answerModel->update(
                    $question_id,
                    $idpatient,
                    (int)$value,
                    $codes
                );
            }
        }

        // Verificar estado
        $responseStatus = $this->answerModel->checkStatus($codes);
        $status = ((int)$responseStatus['count'] > 0) ? 'PENDIENTE' : 'TERMINADO';
        if ($force_terminate) {
            $status = 'TERMINADO';
        }
        $this->registerModel->updateStatus($idUser, $idpatient, $status);
        if ($other_answer != null) { //save to maci
            $response_input = $this->answerModel->maciUpdateProblem($other_answer, $idpatient);
        }


        return [
            'is_share' => $post['is_share'] ?? 0,
            'patient'  => $idpatient
        ];
    }
    public function saveFormMcmmi(array $post)
    {
        $idpatient = $post['patient'] ?? null;

        $region     = $post['region'] ?? '';
        $estudios     = $post['estudios'] ?? '';
        $ci     = $post['ci'] ?? '';
        $estado_civil     = $post['estado_civil'] ?? '';
        $estado_civil_otro     = $post['estado_civil_otro'] ?? '';
        
        $ambito     = $post['ambito'] ?? '';
        $duracion     = $post['duracion'] ?? '';

        if($estado_civil == ''){
            $estado_civil = $estado_civil_otro;
        }
        
        $problems = [
            'problem1' => 'Conyugal o familiar',
            'problem2' => 'Cambios de humor',
            'problem3' => 'Alcohol',
            'problem4' => 'Comportamiento antisocial',
            'problem5' => 'Laboral o académico',
            'problem6' => 'Confianza en mí mismo',
            'problem7' => 'Drogas',
            'problem8' => 'Soledad',
            'problem9' => 'Enfermedad o cansancio',
            'problem10' => 'Sexualidad',
        ];
        $first_problem = '';
        $second_problem = '';
        for ($i=1; $i < 11; $i++) { 
            $name = 'problem'.$i;
            $value = $post[$name] ?? '';
            if($value == '1'){
                $first_problem = $problems["$name"];
            }
            elseif ($value == '2'){
                $second_problem = $problems["$name"];
            }
        }
        if (!empty($post['problem11_texto'])) {
            if (($post['problem11'] ?? '') == '1') {
                $first_problem = $post['problem11_texto'];
            } elseif (($post['problem11'] ?? '') == '2') {
                $second_problem = $post['problem11_texto'];
            }
        }

        if($ambito==''){
            $ambito     = $post['ambito_otro'] ?? '';
        }
        $data = [];
        $data['region'] = $region;
        $data['estudios'] = $estudios;
        $data['ci'] = $ci;
        $data['estado_civil'] = $estado_civil;
        $data['ambito'] = $ambito;
        $data['duracion'] = $duracion;
        $data['one_problem'] = $first_problem;
        $data['two_problem'] = $second_problem;
        $info = $this->registerModel->getInputMcmmiById($idpatient);
        if($info == null){
            $res = $this->registerModel->insertMcmmi($idpatient,$data);
        }
        else{
            $res = $this->registerModel->updateMcmmi($idpatient,$data);
        }
        
        return [
            'patient'  => $idpatient
        ];
    }
    public function externalRedirect($result)
    {
        if ($result['is_share'] == '1') {
            echo "<script>
				alert('FALLO DE ACCESO CODIGO #876 - " . $result['patient'] . " redirigiendo...');
				window.location.href = 'https://www.google.com';
			</script>";
            exit;
        } else {
            header("Location: " . LOCALHOST);
            exit;
        }
    }
    public function externalFinishRedirect($status, $is_share)
    {
        if ($status == 'TERMINADO' && $is_share) {
            echo "<script>
			alert('CUESTIONARIO TERMINADO redirigiendo...');
			window.location.href = 'https://www.google.com';
		</script>";
            exit;
        }
    }
}
