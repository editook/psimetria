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

    public function processForm(array $post,$force_terminate = false): array
    {
        $idUser    = $post['idClient'] ?? null;
        $idpatient = $post['patient'] ?? null;
        $codes     = $post['codes'] ?? null;

        $other_answer = $_POST['other_answer']?? null;//maci
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
        if($force_terminate){
            $status = 'TERMINADO';
        }
        $this->registerModel->updateStatus($idUser, $idpatient, $status);
        if($other_answer != null ){//save to maci
            $response_input = $this->answerModel->maciUpdateProblem($other_answer,$idpatient);
        }
        

        return [
            'is_share' => $post['is_share'] ?? 0,
            'patient'  => $idpatient
        ];
    }
    public function externalRedirect($result){
        if($result['is_share'] == '1'){
			echo "<script>
				alert('FALLO DE ACCESO CODIGO #876 - ".$result['patient']." redirigiendo...');
				window.location.href = 'https://www.google.com';
			</script>";
			exit;
		}
		else{
			header("Location: ".LOCALHOST);
			exit;
		}
    }
    public function externalFinishRedirect($status,$is_share){
        if($status == 'TERMINADO' && $is_share){
		echo "<script>
			alert('CUESTIONARIO TERMINADO redirigiendo...');
			window.location.href = 'https://www.google.com';
		</script>";
		exit;
	}
    }
}