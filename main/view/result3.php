<?php
include_once('../configs.php');

session_start();

include('../connection.php');
include("../models/model_register.php");
include("../models/model_question.php");
include("../models/model_answer.php");
include("../models/model_baremo.php");
include("../models/maci/model_baremo_americanas_mujeres_13_15.php");
include("../models/maci/model_baremo_americanas_mujeres_16_19.php");
include("../models/maci/model_baremo_americanas_varones_13_15.php");
include("../models/maci/model_baremo_americanas_varones_16_19.php");
include("../models/maci/model_baremo_espaniol_mujeres_13_15.php");
include("../models/maci/model_baremo_espaniol_mujeres_16_19.php");
include("../models/maci/model_baremo_espaniol_varones_13_15.php");
include("../models/maci/model_baremo_espaniol_varones_16_19.php");
include("../models/maci/model_maci_configuration.php");
$registerModel = new Register_Model();
$questionModel = new Question_Model();
$answerModel = new Answer_Model();
$baremoModel = new Baremo_Model();
$maciConfigurationModel = new ModelMaciConfiguration();
$idClient = 0;
$idpatient = 0;


if(!isset($_SESSION['REST_type_user'])){
    header("Location: ".LOCALHOST."/signin.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['baremo_id'])) {
        $baremo_id = intval($_POST['baremo_id']);
        $id_register = intval($_POST['id_register']);
        $id_user = intval($_POST['id_user']);
        $register = $registerModel->getById($id_user,$id_register);
        $response = $registerModel->updateClient($register['id'],$register['id_client'],$register['age'],$register['sex'],$register['id_type_question'],$baremo_id);
        
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

if( $_SESSION['REST_type_user'] == 'Administrador' &&  isset($_GET['client']) &&  isset($_GET['patient'])){

    $idClient = $_GET['client'];
    $idpatient = $_GET['patient'];
}

if($_SESSION['REST_type_user'] == 'CLIENTE' &&  isset($_GET['patient'])){
    $idClient = $_SESSION['REST_id_user'];
    $idpatient = $_GET['patient'];
}

$register = $registerModel->getById($idClient,$idpatient);
if($register == null){
    echo "<script>
			alert('FALLO DE ACCESO CODIGO #876 - ".$idpatient." redirigiendo...');
			window.location.href = 'https://www.google.com';
		</script>";
		exit;
    exit;
}
$baremos = $baremoModel->getAll($register['id_type_question']);
//echo json_encode($register);
$baremo_name = $register['name'];
$baremo = null;
if($register['baremo_id'] == 38){
    $baremo = new ModelMaciBaremoEspaniolVarones13_15();
}
if($register['baremo_id'] == 39){
    $baremo = new ModelMaciBaremoEspaniolVarones16_19();
}
if($register['baremo_id'] == 40){
    $baremo = new ModelMaciBaremoEspaniolMujeres13_15();
}
if($register['baremo_id'] == 41){
    $baremo = new ModelMaciBaremoEspaniolMujeres16_19();
}
if($register['baremo_id'] == 42){
    $baremo = new ModelMaciBaremoAmericanoVarones13_15();
}
if($register['baremo_id'] == 43){
    $baremo = new ModelMaciBaremoAmericanoVarones16_19();
}
if($register['baremo_id'] == 44){
    $baremo = new ModelMaciBaremoAmericanoMujeres13_15();
}
if($register['baremo_id'] == 45){
    $baremo = new ModelMaciBaremoAmericanoMujeres16_19();
}
$answers = $answerModel->getAll($register['codes']);
$answers_text = $answerModel->getAnswersTop($register['codes']);
$answers_text = $answers_text['response'];

//fiabilidad PD
$divisor = 60;
$fiabilidad_pd = [114,126];
$response_fiabilidad_pd = $answerModel->sumatoria($answers,$fiabilidad_pd);
//$response_fiabilidad_pd = round($response_fiabilidad_pd/$divisor,2);

//transparencia 
$itemA1 = [
    1   => 1,
    3   => 3,
    12  => 3,
    13  => 1,
    15  => 1,
    17  => 1,
    32  => 2,
    34  => 1,
    35  => 1,
    36  => 3,
    38  => 2,
    39  => 1,
    47  => 2,
    51  => 1,
    61  => 3,
    69  => 1,
    80  => 2,
    85  => 3,
    91  => 2,
    99  => 1,
    100 => 3,
    102 => 2,
    115 => 1,
    116 => 1,
    118 => 2,
    119 => 2,
    132 => 2,
    136 => 1,
    141 => 2,
    142 => 1,
    147 => 1,
    154 => 2,
];

$itemA0 = [
    2   => 2,
    24  => 1,
    56  => 1,
    59  => 2,
    70  => 2,
    77  => 2,
    86  => 1,
    111 => 1,
    143 => 1,
    145 => 2,
    146 => 1,
    152 => 1,
];
$item1A = $maciConfigurationModel->sumatoriaMaci($answers,$itemA1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$itemA0,0);

$item2A1 = [
    13  => 1,
    26  => 1,
    31  => 2,
    32  => 2,
    35  => 2,
    36  => 2,
    38  => 3,
    51  => 1,
    64  => 2,
    69  => 2,
    71  => 3,
    80  => 2,
    84  => 2,
    85  => 1,
    87  => 3,
    99  => 3,
    100 => 1,
    106 => 3,
    116 => 1,
    119 => 2,
    127 => 1,
    132 => 1,
    140 => 2,
    142 => 3,
    153 => 2,
    156 => 1,
];
$item2A0 = [
    10  => 2,
    18  => 1,
    24  => 2,
    59  => 2,
    62  => 1,
    68  => 1,
    70  => 2,
    77  => 1,
    117 => 2,
    143 => 2,
    149 => 2,
];
$item2A = $maciConfigurationModel->sumatoriaMaci($answers,$item2A1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item2A0,0);

$item2B1 = [
    19  => 1,
    20  => 3,
    25  => 2,
    42  => 2,
    43  => 2,
    47  => 3,
    54  => 2,
    63  => 1,
    64  => 3,
    79  => 2,
    84  => 2,
    85  => 1,
    91  => 3,
    95  => 2,
    98  => 3,
    107 => 2,
    110 => 2,
    118 => 2,
    121 => 3,
    140 => 1,
    147 => 2,
    153 => 3,
    154 => 1,
    158 => 1,
];
$item2B = $maciConfigurationModel->sumatoriaMaci($answers,$item2B1,1);

$item3A1 = [
    1   => 3,
    5   => 2,
    6   => 2,
    8   => 2,
    9   => 2,
    23  => 2,
    29  => 2,
    63  => 3,
    71  => 2,
    79  => 1,
    81  => 1,
    87  => 2,
    93  => 1,
    96  => 2,
    102 => 3,
    109 => 3,
    113 => 3,
    122 => 3,
    130 => 1,
    132 => 1,
    151 => 3,
];
$item3A0 = [
    3   => 1,
    4   => 1,
    10  => 1,
    18  => 1,
    21  => 2,
    28  => 2,
    41  => 2,
    44  => 1,
    52  => 2,
    60  => 1,
    68  => 2,
    75  => 1,
    78  => 2,
    88  => 1,
    92  => 2,
    97  => 2,
    101 => 1,
    117 => 1,
    128 => 2,
    131 => 2,
    147 => 1,
    148 => 1,
    150 => 2,
    155 => 1,
    157 => 2,
    158 => 1,
    160 => 1,
];

$item3A = $maciConfigurationModel->sumatoriaMaci($answers,$item3A1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item3A0,0);


$items41 = [
    10   => 2,
    24   => 3,
    28   => 1,
    40   => 1,
    56   => 3,
    59   => 3,
    70   => 3,
    75   => 1,
    77   => 3,
    86   => 2,
    92   => 1,
    101  => 2,
    103  => 3,
    111  => 1,
    135  => 1,
    143  => 1,
    148  => 1,
];
$items40 = [
    13  => 1,
    19  => 1,
    26  => 1,
    31  => 2,
    34  => 1,
    35  => 2,
    36  => 1,
    38  => 2,
    43  => 1,
    47  => 1,
    69  => 2,
    84  => 1,
    85  => 2,
    87  => 1,
    89  => 1,
    99  => 2,
    100 => 1,
    106 => 1,
    110 => 1,
    119 => 2,
    127 => 1,
    132 => 1,
    142 => 2,
    153 => 1,
];

$item4A = $maciConfigurationModel->sumatoriaMaci($answers,$items41,1)+$maciConfigurationModel->sumatoriaMaci($answers,$items40,0);

$item5A1 = [
    2   => 1,
    7   => 3,
    10  => 2,
    24  => 2,
    39  => 1,
    41  => 1,
    52  => 3,
    56  => 2,
    59  => 1,
    68  => 1,
    70  => 1,
    86  => 3,
    94  => 1,
    101 => 3,
    103 => 2,
    104 => 1,
    131 => 1,
    135 => 3,
    139 => 1,
    145 => 2,
    146 => 3,
];
$item5A0 = [
    1   => 1,
    19  => 1,
    20  => 1,
    25  => 1,
    26  => 1,
    31  => 2,
    34  => 1,
    38  => 2,
    63  => 2,
    69  => 2,
    71  => 1,
    84  => 2,
    91  => 1,
    99  => 2,
    115 => 1,
    127 => 2,
    140 => 2,
    151 => 1,
];
$item5A = $maciConfigurationModel->sumatoriaMaci($answers,$item5A1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item5A0,0);

$item6A1 = [
    18  => 2,
    21  => 3,
    28  => 2,
    39  => 3,
    41  => 2,
    44  => 2,
    52  => 1,
    57  => 2,
    58  => 3,
    59  => 1,
    68  => 2,
    73  => 2,
    76  => 3,
    77  => 2,
    92  => 3,
    104 => 2,
    111 => 2,
    117 => 3,
    120 => 1,
    135 => 1,
    143 => 2,
    148 => 3,
    149 => 2,
    150 => 1,
    152 => 1,
    155 => 3,
];
$item6A0 = [
    5   => 2,
    8   => 2,
    9   => 2,
    15  => 2,
    23  => 2,
    45  => 2,
    51  => 1,
    84  => 1,
    93  => 2,
    96  => 1,
    99  => 1,
    116 => 1,
    132 => 2,
];
$item6A = $maciConfigurationModel->sumatoriaMaci($answers,$item6A1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item6A0,0);

$item6B1 = [
    18  => 1,
    21  => 2,
    28  => 3,
    41  => 3,
    52  => 2,
    60  => 2,
    74  => 1,
    78  => 3,
    97  => 3,
    104 => 2,
    117 => 2,
    128 => 3,
    139 => 3,
    148 => 2,
    149 => 2,
    152 => 1,
    157 => 3,
];

$item6B0 = [
    5   => 2,
    9   => 1,
    50  => 1,
    71  => 1,
    81  => 2,
];
$item6B = $maciConfigurationModel->sumatoriaMaci($answers,$item6B1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item6B0,0);

$item71 = [
    6   => 1,
    9   => 3,
    15  => 2,
    23  => 3,
    27  => 1,
    50  => 3,
    93  => 3,
    96  => 3,
    130 => 3,
    145 => 2,
    159 => 3,
];
$item70 = [
    4   => 1,
    18  => 2,
    19  => 1,
    21  => 2,
    28  => 1,
    34  => 1,
    42  => 2,
    43  => 1,
    53  => 2,
    58  => 1,
    73  => 2,
    74  => 2,
    76  => 1,
    78  => 1,
    90  => 1,
    97  => 1,
    100 => 1,
    104 => 1,
    107 => 2,
    110 => 1,
    117 => 2,
    118 => 1,
    133 => 1,
    148 => 1,
    149 => 1,
    150 => 2,
    154 => 2,
    157 => 1,
];
$item7 = $maciConfigurationModel->sumatoriaMaci($answers,$item71,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item70,0);

$item8A1 = [
    4   => 3,
    16  => 1,
    18  => 1,
    19  => 2,
    22  => 1,
    25  => 3,
    28  => 1,
    34  => 1,
    37  => 2,
    39  => 2,
    41  => 1,
    49  => 1,
    54  => 2,
    57  => 1,
    66  => 2,
    67  => 3,
    70  => 1,
    73  => 2,
    78  => 2,
    88  => 2,
    90  => 1,
    91  => 2,
    95  => 2,
    97  => 2,
    105 => 1,
    107 => 2,
    110 => 3,
    117 => 2,
    118 => 3,
    127 => 1,
    128 => 1,
    134 => 1,
    136 => 3,
    147 => 2,
    148 => 1,
    149 => 2,
    157 => 2,
    158 => 1,
];

$item8A0 = [
    5   => 1,
    23  => 2,
    45  => 1,
    96  => 1,
    130 => 2,
];
$item8A = $maciConfigurationModel->sumatoriaMaci($answers,$item8A1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item8A0,0);

$item8B1 = [
    18  => 1,
    19  => 3,
    20  => 2,
    25  => 1,
    26  => 1,
    33  => 1,
    34  => 2,
    35  => 1,
    46  => 3,
    54  => 1,
    64  => 1,
    66  => 3,
    71  => 1,
    74  => 1,
    80  => 3,
    84  => 2,
    88  => 1,
    89  => 3,
    99  => 2,
    106 => 2,
    107 => 1,
    108 => 3,
    110 => 2,
    112 => 2,
    118 => 1,
    121 => 1,
    127 => 2,
    132 => 1,
    133 => 1,
    136 => 1,
    137 => 2,
    140 => 2,
    141 => 3,
    149 => 1,
    151 => 2,
    153 => 1,
    156 => 1,
    158 => 2,
    160 => 3,
];
$item8B0 = [
    2   => 2,
    6   => 1,
    10  => 1,
    27  => 1,
    68  => 2,
];
$item8B = $maciConfigurationModel->sumatoriaMaci($answers,$item8B1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item8B0,0);

//=REDONDEAR((1.5*M47)+(1.5*O40)+(2*Q27)+(0.7*S51)+(0.7*U44)+W42+Y42+(3*AA25)  +(0.7*AC42)+AE46+AG47, 0)

$transparencia = (1.5*$item1A)+(1.5*$item2A)+(2*$item2B)+(0.7*$item3A)+(0.7*$item4A)+$item5A+$item6A+(3*$item6B)+(0.7*$item7)+$item8A+$item8B;

$transparenciaPD = round($transparencia);

//echo $transparenciaPD;

$itemY1 = [
    2 => 1,
    5 => 1,
    9 => 1,
    10 => 1,
    23 => 1,
    24 => 1,
    50 => 1,
    70 => 1,
    86 => 1,
    93 => 1,
    96 => 1,
    101 => 1,
    130 => 1,
    131 => 1,
    145 => 1,
    146 => 1,
    159 => 1,
];

$deseabilidadPD = $maciConfigurationModel->sumatoriaMaci($answers,$itemY1,1);
//echo $deseabilidadPD.'<br>';

$itemZ1 = [
    25 => 1,
    34 => 1,
    43 => 1,
    64 => 1,
    71 => 1,
    79 => 1,
    80 => 1,
    84 => 1,
    106 => 1,
    112 => 1,
    133 => 1,
    140 => 1,
    141 => 1,
    147 => 1,
    153 => 1,
    154 => 1,
];
$alteracionPD = $maciConfigurationModel->sumatoriaMaci($answers,$itemZ1,1);

//echo $alteracionPD.'<br>';
$introversionPD = $item1A;

//echo $introversionPD.'<br>';

$inhibidoPD = $item2A;

//echo $inhibidoPD.'<br>';

$pesimistaPD =$item2B;

//echo $pesimistaPD.'<br>';

$sumisoPD = $item3A;


$histrionicoPD = $item4A;
//echo $histrionicoPD.'<br>';

$egocentricoPD = $item5A;
//echo $egocentricoPD.'<br>';

$rebeldePD = $item6A;

//echo $rebeldePD.'<br>';

$rudoPD = $item6B;

//echo $rudoPD.'<br>';

$conformistaPD = $item7;

//echo $conformistaPD.'<br>';

$oposicionistaPD = $item8A;
//echo $oposicionistaPD.'<br>';

$autopunitivoPD = $item8B;
//echo $autopunitivoPD.'<br>';

$item9A1 = [
    4 => 2,
    18 => 2,
    34 => 2,
    44 => 2,
    54 => 2,
    63 => 2,
    64 => 2,
    78 => 1,
    84 => 2,
    88 => 2,
    104 => 2,
    107 => 2,
    115 => 2,
    117 => 2,
    121 => 1,
    141 => 2,
    149 => 2,
    153 => 2,
    154 => 2,
];
$item9A0 = [2=>2,145=>2];
$item9A = $maciConfigurationModel->sumatoriaMaci($answers,$item9A1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item9A0,0);
$tendencia_limitePD = $item9A;
//echo $tendencia_limitePD.'<br>';

$itemAA1 = [
    3 => 1,
    12 => 2,
    17 => 1,
    20 => 1,
    29 => 1,
    34 => 3,
    41 => 1,
    42 => 1,
    47 => 2,
    49 => 1,
    52 => 2,
    66 => 1,
    71 => 1,
    88 => 2,
    95 => 1,
    115 => 3,
    118 => 2,
    120 => 1,
    122 => 2,
    134 => 1,
    141 => 1,
    146 => 1,
    147 => 1,
    154 => 3,
    155 => 2,
];
$itemAA0 = [
    2 => 3,
    9 => 1,
    11 => 1,
    70 => 1,
    130 => 1,
    135 => 1,
    145 => 3,
];
$difusionIdentidadPD = $maciConfigurationModel->sumatoriaMaci($answers,$itemAA1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$itemAA0,0);
//echo $difusionIdentidadPD.'<br>';
$itemAB1 = [
    4 => 2,
    19 => 2,
    20 => 1,
    25 => 2,
    26 => 3,
    31 => 2,
    35 => 2,
    38 => 2,
    42 => 3,
    46 => 1,
    47 => 2,
    63 => 1,
    69 => 1,
    71 => 2,
    80 => 2,
    82 => 1,
    84 => 3,
    87 => 2,
    99 => 2,
    106 => 1,
    107 => 2,
    109 => 1,
    110 => 1,
    112 => 2,
    115 => 1,
    118 => 1,
    119 => 1,
    121 => 1,
    125 => 1,
    127 => 3,
    140 => 3,
    141 => 2,
    151 => 2,
    153 => 2,
];
$itemAB0 = [
    10 => 2,
    68 => 2,
    131 => 2,
    145 => 1,
];

$desvalorizacionMismoPD = $maciConfigurationModel->sumatoriaMaci($answers,$itemAB1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$itemAB0,0);
//echo $desvalorizacionMismoPD.'<br>';

$itemAC1 = [
    11 => 1,
    14 => 1,
    26 => 1,
    29 => 2,
    31 => 3,
    48 => 2,
    65 => 2,
    99 => 2,
    105 => 1,
    112 => 3,
    123 => 1,
    124 => 1,
    138 => 1,
    144 => 2,
];
$itemAC0 = [
    10 => 3,
    68 => 3,
    131 => 3
];
$desagradoPropioPD = $maciConfigurationModel->sumatoriaMaci($answers,$itemAC1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$itemAC0,0);
//echo $desagradoPropioPD.'<br>';
$itemAD1 = [
    2 => 1,
    5 => 1,
    9 => 1,
    14 => 2,
    29 => 1,
    31 => 1,
    51 => 3,
    72 => 1,
    93 => 1,
    99 => 1,
    116 => 3,
    129 => 2,
    137 => 2,
];
$itemAD0 = [
    7 => 1,
    19 => 1,
    22 => 1,
    24 => 1,
    43 => 2,
    52 => 1,
    55 => 2,
    57 => 1,
    59 => 1,
    61 => 1,
    62 => 3,
    76 => 2,
    83 => 1,
    94 => 3,
    97 => 1,
    118 => 2,
    121 => 1,
    131 => 1,
    136 => 1,
    143 => 3,
    147 => 1,
    150 => 2,
    157 => 2,
    160 => 2,
];

$incomodidadRespetoPD = $maciConfigurationModel->sumatoriaMaci($answers,$itemAD1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$itemAD0,0);
//echo $incomodidadRespetoPD.'<br>';

$itemAE1 = [
    13 => 3,
    32 => 2,
    35 => 3,
    36 => 1,
    38 => 2,
    64 => 1,
    66 => 1,
    69 => 3,
    85 => 1,
    96 => 1,
    106 => 2,
    119 => 3,
    142 => 2,
];
$itemAE0 = [
    24 => 2,
    58 => 1,
    70 => 2,
    74 => 1,
    104 => 1,
    148 => 2,
];

$inseguridadIgualPD = $maciConfigurationModel->sumatoriaMaci($answers,$itemAE1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$itemAE0,0);
//echo $inseguridadIgualPD.'<br>';

$itemAF1 = [
    10 => 1,
    18 => 1,
    21 => 1,
    28 => 1,
    37 => 3,
    39 => 2,
    41 => 2,
    49 => 3,
    52 => 2,
    57 => 1,
    60 => 3,
    68 => 2,
    78 => 1,
    86 => 1,
    94 => 1,
    104 => 2,
    111 => 2,
    117 => 2,
    128 => 2,
    135 => 2,
    143 => 1,
    146 => 1,
    157 => 2,
];
$itemAF0 = [
    5 => 3,
    14 => 1,
    15 => 2,
    20 => 1,
    26 => 2,
    38 => 1,
    45 => 2,
    51 => 1,
    63 => 1,
    71 => 1,
    81 => 3,
    84 => 2,
    99 => 2,
    127 => 2,
    140 => 1,
    153 => 1,
];

$insencibilidadSocialPD = $maciConfigurationModel->sumatoriaMaci($answers,$itemAF1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$itemAF0,0);
//echo $insencibilidadSocialPD.'<br>';

$itemAG1 = [
    18 => 1,
    21 => 1,
    22 => 1,
    24 => 1,
    53 => 3,
    56 => 1,
    64 => 2,
    70 => 1,
    74 => 1,
    77 => 1,
    83 => 3,
    92 => 2,
    95 => 2,
    103 => 1,
    135 => 1,
    148 => 2,
    149 => 2,
    158 => 3,
];
$itemAG0 = [
    6 => 3,
    9 => 1,
    13 => 1,
    17 => 1,
    23 => 1,
    27 => 3,
    35 => 1,
    36 => 1,
    96 => 2,
    142 => 1,
];

$discordanciaFamiliarPD = $maciConfigurationModel->sumatoriaMaci($answers,$itemAG1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$itemAG0,0);
//echo $discordanciaFamiliarPD.'<br>';
$itemAH1 = [
    14 => 3,
    22 => 1,
    25 => 1,
    33 => 1,
    34 => 1,
    35 => 1,
    40 => 1,
    54 => 2,
    63 => 1,
    64 => 1,
    72 => 3,
    83 => 1,
    90 => 1,
    106 => 2,
    110 => 1,
    123 => 1,
    125 => 1,
    129 => 3,
    137 => 3,
    153 => 1,
    158 => 2,
];
$itemAH0 = [
    6 => 1,
    45 => 1,
    55 => 3,
];

$abusosInfanciaPD = $maciConfigurationModel->sumatoriaMaci($answers,$itemAH1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$itemAH0,0);
//echo $abusosInfanciaPD.'<br>';
$item_AA1 = [
    11 => 3,
    26 => 1,
    29 => 3,
    31 => 1,
    33 => 3,
    48 => 3,
    63 => 1,
    65 => 3,
    71 => 1,
    82 => 3,
    84 => 1,
    105 => 3,
    112 => 2,
    124 => 3,
    127 => 1,
    138 => 3,
    144 => 3,
];
$item_AA0 = [
    10 => 2,
    68 => 2,
    131 => 2,
];

$transtornoAlimentacionPD =  $maciConfigurationModel->sumatoriaMaci($answers,$item_AA1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item_AA0,0);
//echo $abusosInfanciaPD.'<br>';

$item_BB1 = [
    4 => 1,
    18 => 2,
    21 => 2,
    22 => 3,
    30 => 3,
    40 => 3,
    43 => 1,
    44 => 1,
    52 => 2,
    57 => 3,
    61 => 2,
    73 => 1,
    74 => 1,
    75 => 3,
    76 => 1,
    78 => 1,
    90 => 3,
    92 => 1,
    97 => 1,
    104 => 2,
    111 => 2,
    117 => 1,
    120 => 3,
    134 => 3,
    139 => 1,
    141 => 1,
    148 => 1,
    150 => 2,
    152 => 3,
];
$item_BB0 = [
    5 => 1,
    8 => 3,
    9 => 2,
    15 => 2,
    23 => 1,
    45 => 1,
];
$inclinacionAbusoSusPD = $maciConfigurationModel->sumatoriaMaci($answers,$item_BB1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item_BB0,0);
//echo $inclinacionAbusoSusPD.'<br>';
$item_CC1 = [
    10 => 1,
    12 => 1,
    21 => 2,
    28 => 1,
    41 => 1,
    68 => 1,
    73 => 3,
    76 => 1,
    78 => 1,
    92 => 1,
    94 => 1,
    111 => 3,
    117 => 2,
    148 => 2,
    150 => 3,
    152 => 1,
    155 => 1,
];
$item_CC0 = [
    5 => 1,
    8 => 1,
    15 => 3,
    26 => 1,
    32 => 1,
    45 => 3,
    46 => 1,
    65 => 1,
    69 => 1,
    71 => 2,
    81 => 1,
    84 => 2,
    99 => 2,
    106 => 2,
    125 => 2,
    127 => 1,
    140 => 1,
];

$predisposicionDeliPD = $maciConfigurationModel->sumatoriaMaci($answers,$item_CC1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item_CC0,0);
//echo $predisposicionDeliPD.'<br>';
$item_DD1 = [
    18 => 3,
    19 => 1,
    21 => 1,
    44 => 3,
    53 => 1,
    68 => 1,
    73 => 2,
    74 => 3,
    77 => 1,
    86 => 1,
    92 => 1,
    104 => 3,
    117 => 2,
    131 => 1,
    143 => 1,
    146 => 1,
    148 => 2,
    149 => 3,
];
$item_DD0 = [
    15 => 1,
    17 => 1,
    23 => 2,
    27 => 1,
    45 => 1,
    99 => 1,
];

$propensionInPD = $maciConfigurationModel->sumatoriaMaci($answers,$item_DD1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item_DD0,0);

$item_EE1 = [
    8 => 1,
    15 => 1,
    17 => 3,
    23 => 1,
    32 => 3,
    45 => 1,
    63 => 2,
    71 => 2,
    79 => 3,
    99 => 2,
    109 => 1,
    132 => 3,
    133 => 3,
];
$item_EE0 = [
    3 => 1,
    18 => 1,
    21 => 1,
    39 => 1,
    40 => 1,
    41 => 1,
    44 => 1,
    49 => 1,
    57 => 1,
    58 => 1,
    68 => 1,
    73 => 1,
    74 => 1,
    75 => 2,
    76 => 1,
    78 => 1,
    90 => 1,
    92 => 1,
    94 => 1,
    97 => 1,
    104 => 1,
    111 => 2,
    117 => 1,
    120 => 1,
    143 => 1,
    148 => 1,
    150 => 1,
    152 => 1,
    157 => 1,
];

$sentimientoAncPD =$maciConfigurationModel->sumatoriaMaci($answers,$item_EE1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item_EE0,0);
//echo $sentimientoAncPD.'<br>';
$item_FF1 = [
    1 => 1,
    15 => 1,
    16 => 3,
    26 => 2,
    31 => 1,
    42 => 2,
    43 => 3,
    45 => 1,
    63 => 2,
    64 => 2,
    69 => 1,
    71 => 2,
    80 => 2,
    84 => 2,
    95 => 3,
    98 => 1,
    99 => 2,
    106 => 2,
    107 => 1,
    112 => 1,
    118 => 1,
    125 => 3,
    127 => 1,
    133 => 1,
    141 => 1,
    142 => 2,
    147 => 3,
    153 => 2,
];
$item_FF0 = [
    10 => 2,
    39 => 1,
    77 => 1,
    111 => 2,
    131 => 1,
];

$afectoDepresivoPD =$maciConfigurationModel->sumatoriaMaci($answers,$item_FF1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item_FF0,0);
//echo $afectoDepresivoPD.'<br>';
$item_GG1 = [
    14 => 1,
    16 => 2,
    19 => 1,
    25 => 2,
    26 => 1,
    34 => 1,
    43 => 2,
    54 => 3,
    64 => 2,
    84 => 1,
    85 => 1,
    88 => 3,
    89 => 1,
    95 => 2,
    107 => 3,
    110 => 1,
    112 => 1,
    123 => 3,
    127 => 1,
    129 => 1,
    136 => 1,
    140 => 1,
    147 => 2,
    156 => 3,
];
$item_GG0 = [
    55 => 1];
$tendenciaSuicidioPD =$maciConfigurationModel->sumatoriaMaci($answers,$item_GG1,1)+$maciConfigurationModel->sumatoriaMaci($answers,$item_GG0,0);

//echo $tendenciaSuicidioPD.'<br><br>';
$transparenciaTB = "";
if ($baremo_name == "Baremos españoles. Varones de 13 a 15 años" ||
    $baremo_name == "Baremos españoles. Varones de 16 a 19 años" ||
    $baremo_name == "Baremos españoles. Mujeres de 13 a 15 años" ||
    $baremo_name == "Baremos españoles. Mujeres de 16 a 19 años") {
        
        $transparenciaTB = $maciConfigurationModel->obtenerPdxEspaniol($transparenciaPD);
        //echo $transparenciaTB.'<br>!';

} elseif ($baremo_name == "Baremos americanos. Varones de 13 a 15 años" ||
          $baremo_name == "Baremos americanos. Varones de 16 a 19 años" ||
          $baremo_name == "Baremos americanos. Mujeres de 13 a 15 años" ||
          $baremo_name == "Baremos americanos. Mujeres de 16 a 19 años") {
    
        $transparenciaTB = $maciConfigurationModel->obtenerPdxAmericano($transparenciaPD);
        //echo $transparenciaTB.'<br>!';
}


if($transparenciaPD<=200 || $transparenciaPD>=590){
    //echo "Reporte Invalido";
    die();
}

$deseabilidadTB = $baremo->getValueY($deseabilidadPD);
//echo $deseabilidadTB.'*<br>';
$alteracionTB = $baremo->getValueZ($alteracionPD);
//echo $alteracionTB.'*<br>';


$ajusteX = $maciConfigurationModel->getRawScoreScaleX($transparenciaPD);
$ajusteAD = 0;
if ($sentimientoAncPD < 85 && $afectoDepresivoPD < 85) {
    $ajusteAD = 0;
} elseif ($sentimientoAncPD >= 85 && $afectoDepresivoPD < 85) {
    $ajusteAD = $sentimientoAncPD - 84;
} elseif ($afectoDepresivoPD >= 85 && $sentimientoAncPD < 85) {
    $ajusteAD = $afectoDepresivoPD - 84;
} else {
    $ajusteAD = ($sentimientoAncPD - 84) + ($afectoDepresivoPD - 84);
}

$ajusteD1 = $maciConfigurationModel->getSettingAD($ajusteAD);
$introversionTB = $baremo->getValue1($introversionPD);
$introversionTB_total = $introversionTB + $ajusteX;//
//echo $introversionPD.'<br>';
//echo $introversionTB.'<br>';
$inhibidoTB = $baremo->getValue2A($inhibidoPD);
$inhibidoTB_total = $inhibidoTB+ ($ajusteX) +($ajusteD1);
//echo $inhibidoPD.'<br>';
//echo $inhibidoTB.'<br>';
$pesimistaTB = $baremo->getValue2B($pesimistaPD);
$pesimistaTB_total = $pesimistaTB + ($ajusteX) +($ajusteD1);
//echo $pesimistaTB.'<br>';
$sumisoTB = $baremo->getValue3($sumisoPD);
$sumisoTB_total = $sumisoTB+ $ajusteX;
//echo $sumisoTB.'<br>';
$histrionicoTB = $baremo->getValue4($histrionicoPD);
$histrionicoTB_total = $histrionicoTB + $ajusteX;
//echo $histrionicoTB.'<br>';

$egocentricoTB = $baremo->getValue5($egocentricoPD);
$egocentricoTB_total = $egocentricoTB + $ajusteX;

$rebeldeTB = $baremo->getValue6A($rebeldePD);
$rebeldeTB_total = $rebeldeTB + $ajusteX;
//echo $rebeldeTB.'<br>';

$rudoTB = $baremo->getValue6B($rudoPD);
$rudoTB_total = $rudoTB + $ajusteX;
//echo $rudoTB.'<br>';

$conformistaTB = $baremo->getValue7($conformistaPD);
$conformistaTB_total = $conformistaTB + $ajusteX;
//echo $conformistaTB.'<br>';

$oposicionistaTB = $baremo->getValue8A($oposicionistaPD);
$oposicionistaTB_total = ($oposicionistaTB + $ajusteX);
//echo $oposicionistaTB.'<br>';

$autopunitivoTB = $baremo->getValue8B($autopunitivoPD);
$autopunitivoTB_total = ($autopunitivoTB + ($ajusteX) +($ajusteD1));
//echo $autopunitivoTB.'<br>';
$tendencialimiteTB = $baremo->getValue9($tendencia_limitePD);
$tendencialimiteTB_total = $tendencialimiteTB + ($ajusteX) +($ajusteD1);
//echo $tendencialimiteTB.'<br>';
//----------------------------------
//echo $deseabilidadTB.'<br>';
//echo $alteracionTB.'<br>';
$indiceBuscar = abs($deseabilidadTB - $alteracionTB);
//echo $indiceBuscar.'<br>';
$ajusteD = 0;
if($indiceBuscar>4){
    $ajusteD = $maciConfigurationModel->getDifereceYZ($indiceBuscar);
}
//echo $ajusteD.'*****<br>';
////echo $introversionTB.'-'.$inhibidoTB.'-'.$pesimistaTB.'-'.$sumisoTB.'-'.$histrionicoTB.'-'.$egocentricoTB.'-'.$rebeldeTB.'-'.$rudoTB.'-'.$conformistaTB.'-'.$oposicionistaTB.'-'.$autopunitivoTB.'<br>';
$ajusteT = $maciConfigurationModel->getPrototipoPersonalidad([],$introversionTB,$inhibidoTB,$pesimistaTB,$sumisoTB,$histrionicoTB,$egocentricoTB,$rebeldeTB,$rudoTB,$conformistaTB,$oposicionistaTB,$autopunitivoTB);
$ajusteDC = $ajusteT['valor'];
//echo $ajusteDC.'+<br>';

$difusionIdentidadTB = $baremo->getValueA($difusionIdentidadPD) +($ajusteD) +($ajusteDC);
//echo $conformistaTB.'<br>';

$desvalorizacionMismoTB = $baremo->getValueB($desvalorizacionMismoPD) +($ajusteD)+($ajusteDC);
//echo $desvalorizacionMismoTB.'<br>';

$desagradoPropioTB = $baremo->getValueC($desagradoPropioPD) +($ajusteD);
//echo $desagradoPropioTB.'<br>';

$incomodidadRespetoTB = $baremo->getValueD($incomodidadRespetoPD) +($ajusteD);
//echo $incomodidadRespetoTB.'<br>';

$inseguridadIgualTB = $baremo->getValueE($inseguridadIgualPD) +($ajusteD);
//echo $inseguridadIgualTB.'<br>';

$insencibilidadSocialTB = $baremo->getValueF($insencibilidadSocialPD) +($ajusteD);
//echo $insencibilidadSocialTB.'<br>';

$discordanciaFamiliarTB = $baremo->getValueG($discordanciaFamiliarPD) +($ajusteD)+($ajusteDC);
//echo $discordanciaFamiliarTB.'<br>';

$abusosInfanciaTB = $baremo->getValueH($abusosInfanciaPD) +($ajusteD);
//echo $abusosInfanciaTB.'<br>';

$transtornoAlimentacionTB = $baremo->getValueAA($transtornoAlimentacionPD)+($ajusteD);
//echo $transtornoAlimentacionTB.'<br>';

$inclinacionAbusoSusTB = $baremo->getValueBB($inclinacionAbusoSusPD);
//echo $inclinacionAbusoSusTB.'<br>';

$predisposicionDeliTB = $baremo->getValueCC($predisposicionDeliPD);
//echo $predisposicionDeliTB.'<br>';

$propensionInTB = $baremo->getValueDD($propensionInPD);
//echo $propensionInTB.'<br>';

$sentimientoAncTB = $baremo->getValueEE($sentimientoAncPD)+($ajusteD)+($ajusteDC);
//echo $sentimientoAncTB.'<br>';

$afectoDepresivoTB = $baremo->getValueFF($afectoDepresivoPD)+($ajusteD)+($ajusteDC);
//echo $afectoDepresivoTB.'<br>';

$tendenciaSuicidioTB = $baremo->getValueGG($tendenciaSuicidioPD)+($ajusteD)+($ajusteDC);
//echo $tendenciaSuicidioTB.'<br>';
$mensaje_fiabilidad = "Valor no reconocido";
if ($response_fiabilidad_pd == 0) {
    $mensaje_fiabilidad = "protocolo válido.";
} elseif ($response_fiabilidad_pd == 1) {
    $mensaje_fiabilidad = "que el perfil debe interpretarse con cautela.";
} elseif ($response_fiabilidad_pd == 2) {
    $mensaje_fiabilidad = "protocolo inválido.";
}

//textos:
$validesV = "La escala V consta de 2 ítems que son improbables.  Una puntuación de 0 indica que el protocolo es válido. Una puntuación de 1 sugiere que ";
$validesV .= "los resultados deben interpretarse con cautela. Una puntuación de 2 indica que el protocolo es inválido. ";
$validesV .= $register['id_client']." ha obtenido una puntuación de ".$response_fiabilidad_pd." en la escala V  indica ".$mensaje_fiabilidad;

$mensaje_transparecia = "Valor no reconocido";
if ($transparenciaTB <= 2) {
    $mensaje_transparecia = "presenta un patrón de respuestas en el que minimiza de forma extrema sus síntomas, lo que invalida la interpretación del protocolo.";
} elseif ($transparenciaTB <= 34) {
    $mensaje_transparecia = "presenta un nivel bajo de transparencia, lo que indica una reserva en la revelación de aspectos personales.";
} elseif ($transparenciaTB <= 74) {
    $mensaje_transparecia = "el estilo de respuesta se sitúa en un nivel moderado, correspondiente a la media normativa en términos de apertura y sinceridad.";
} elseif ($transparenciaTB <= 84) {
    $mensaje_transparecia = "tendencia a estar por encima de la media, reflejando una mayor disposición a revelar información personal.";
} elseif ($transparenciaTB <= 98) {
    $mensaje_transparecia = "se evidencia una sinceridad elevada, es decir, se muestra altamente abierto y revelador en sus respuestas.";
} elseif ($transparenciaTB >= 99) {
    $mensaje_transparecia = "presenta un patrón de respuestas caracterizado por la maximización de síntomas, lo que también invalida la interpretabilidad de los resultados.";
}

$transpareciaX = "Esta escala mide el grado en que el adolescente ha sido abierto, sincero y revelador sobre sí mismo al responder el inventario. ";
$transpareciaX .= $register['id_client']." obtuvo una puntuación de TB ".$transparenciaTB.", ".$mensaje_transparecia;


$mensaje_deseabilidad = "Valor no reconocido";
if ($deseabilidadTB <= 34) {
    $mensaje_deseabilidad = "presenta un nivel bajo de deseabilidad, lo que implica una influencia mínima de la imagen positiva en su patrón de respuestas.";
} elseif ($deseabilidadTB <= 74) {
    $mensaje_deseabilidad = "presenta un estilo de respuesta en la media normativa, manifestándose de forma moderada la inclinación por proyectar una imagen favorable.";
} elseif ($deseabilidadTB <= 84) {
    $mensaje_deseabilidad = "presenta un estilo por encima de la media, lo que refleja una tendencia más marcada a mostrar una imagen idealizada.";
} elseif ($deseabilidadTB >= 85) {
    $mensaje_deseabilidad = "presenta una deseabilidad elevada, indicando que su perfil de respuestas se ve afectado por la intención de proyectar una imagen socialmente atractiva, moralmente virtuosa y emocionalmente serena.";
}
$deseabilidadY = "Esta escala mide la tendencia del adolescente a presentar una imagen positiva de sí mismo, posiblemente ocultando o minimizando sus dificultades.";
$deseabilidadY .= $register['id_client']." obtuvo una puntuación de TB ".$deseabilidadTB.", ".$mensaje_deseabilidad;


$mensaje_alteracion = "Valor fuera de rango";
if ($alteracionTB <= 34) {
    $mensaje_alteracion = "presenta respuestas que se consideran sinceras y una tendencia baja a exagerar problemas personales.";
} elseif ($alteracionTB <= 74) {
    $mensaje_alteracion = "exhibe un estilo de respuesta dentro de la media, sin manifestar elevaciones notables ni indicios de autoimagen extremadamente negativa.";
} elseif ($alteracionTB <= 84) {
    $mensaje_alteracion = "presenta una inclinación por encima de la media a mostrar dificultades emocionales o personales, denotando una tendencia a percibirse de manera más negativa de lo habitual.";
} elseif ($alteracionTB >= 85) {
    $mensaje_alteracion = "manifiesta una alteración elevada, caracterizada por una propensión a denigrarse o desvalorizarse, mostrando problemas emocionales y personales más complicados de lo que probablemente se descubriría mediante una revisión objetiva.";
}
$alteracionZ = "Esta escala evalúa la tendencia del adolescente a exagerar sus problemas o a presentarse de manera más perturbada de lo que realmente está.";
$alteracionZ .= $register['id_client']." obtuvo una puntuación de TB ".$alteracionTB. ", ".$mensaje_alteracion;

$mensaje_tendencia_limite = "valor fuera de rango";
if ($tendencialimiteTB_total <= 60) {
    $mensaje_tendencia_limite = "Indica una baja incidencia de las características asociadas con la tendencia límite.";
} elseif ($tendencialimiteTB_total <= 74) {
    $mensaje_tendencia_limite = "Se identifica una presencia muy leve de este patrón de personalidad, sin que ello represente un rasgo predominante o que afecte significativamente su funcionamiento. En estos casos, puede experimentar algunas fluctuaciones en su estado de ánimo o cierta inestabilidad en sus relaciones, pero sin que esto configure un patrón persistente de desregulación emocional o impulsividad.";
} elseif ($tendencialimiteTB_total <= 84) {
    $mensaje_tendencia_limite = "El patrón de personalidad de tendencia límite se encuentra presente, aunque sin ser el rasgo dominante en la configuración psicológica. Se observa una tendencia a experimentar estados emocionales intensos y variables, alternando entre episodios de abatimiento, ansiedad, irritabilidad o euforia. Su comportamiento puede tornarse caprichoso e impulsivo, con cambios abruptos en la forma en que percibe sus relaciones interpersonales. Es común que muestre una fuerte ambivalencia en sus vínculos, oscilando entre la idealización y la desvalorización de los demás. Puede manifestar temor al abandono, lo que lo lleva a reaccionar de manera extrema ante situaciones que percibe como amenazantes para su estabilidad emocional. Su sentido de identidad suele ser frágil, con dificultades para mantener una autoimagen estable y coherente a lo largo del tiempo.";
} elseif ($tendencialimiteTB_total >= 85) {
    $mensaje_tendencia_limite = "La expresión del prototipo de personalidad de tendencia límite se torna destacada o prominente. En este nivel, presenta una marcada desorganización interna, con una constante oscilación entre extremos opuestos en su comportamiento y estado emocional. Su inestabilidad afectiva se manifiesta en cambios abruptos de humor, con periodos de abatimiento y apatía que pueden alternarse con episodios de rabia intensa, ansiedad o euforia. En el ámbito interpersonal, predominan sentimientos contradictorios de amor, culpa y hostilidad hacia los demás, lo que dificulta la construcción de relaciones estables. Su estructura psíquica presenta una cohesión reducida, con dificultades para mantener una posición equilibrada entre la dependencia y la independencia, entre la impulsividad y la pasividad, o entre la obediencia y la oposición. En este nivel de expresión, la presencia de pensamientos autolesivos y suicidas puede ser recurrente, y algunos pueden llegar a actuar en función de estos impulsos. Su comportamiento tiende a ser errático, con una marcada dificultad para mantener la consistencia en sus decisiones y acciones. Reiteradamente, sabotea o contradice sus propios esfuerzos, reflejando un estado interno caracterizado por una profunda división intrapsíquica. Su funcionamiento se encuentra marcado por una fractura entre sus orientaciones internas y su forma de relacionarse con los demás, lo que genera un patrón de inestabilidad persistente tanto a nivel emocional como interpersonal. Este perfil de personalidad guarda similitudes con el trastorno límite de la personalidad descrito en el DSM, en la medida en que muestra una estructura psíquica caracterizada por una marcada discordia interna y una incapacidad para mantener un sentido coherente de sí mismo. Su funcionamiento se ve afectado por una polarización constante en sus emociones, relaciones y comportamientos, lo que lo lleva a alternar entre impulsividad y retraimiento, entre dependencia y oposición, y entre la búsqueda de aprobación y el rechazo activo de la misma. Su experiencia subjetiva está dominada por una sensación de vacío, inestabilidad y conflicto interno, lo que genera dificultades significativas en su capacidad para mantener relaciones interpersonales estables y una identidad consolidada.";
}
$gravestendencia = "Tendencia límite (Mide la inestabilidad emocional significativa, con fluctuaciones en el estado de ánimo, dificultades en la identidad y comportamientos autodestructivos) ";
$gravestendencia .= $register['id_client'] . " obtuvo una puntuación de TB ".$tendencialimiteTB_total .", ".$mensaje_tendencia_limite;

$introversionTB_totalt = $introversionTB_total + (12-36+2)*0.001;
$inhibidoTB_totalt = $inhibidoTB_total + (12-37+2)*0.001;
$pesimistaTB_totalt = $pesimistaTB_total + (12-38+2)*0.001;
$sumisoTB_totalt = $sumisoTB_total + (12-39+2)*0.001;
$histrionicoTB_totalt = $histrionicoTB_total + (12-39+2)*0.001;
$egocentricoTB_totalt = $egocentricoTB_total + (12-40+2)*0.001;
$rebeldeTB_totalt = $rebeldeTB_total + (12-41+2)*0.001;
$rudoTB_totalt = $rudoTB_total + (12-42+2)*0.001;
$conformistaTB_totalt = $conformistaTB_total + (12-43+2)*0.001;
$oposicionistaTB_totalt = $oposicionistaTB_total + (12-44+2)*0.001;
$autopunitivoTB_totalt = $autopunitivoTB_total + (12-45+2)*0.001;

$tendencialimiteTB_totalt = $tendencialimiteTB_total + (12-45+2)*0.001;

$primero = $maciConfigurationModel->getPrototipoPersonalidad([],$introversionTB_totalt,$inhibidoTB_totalt,$pesimistaTB_totalt,$sumisoTB_totalt,$histrionicoTB_totalt,$egocentricoTB_totalt,$rebeldeTB_totalt,$rudoTB_totalt,$conformistaTB_totalt,$oposicionistaTB_totalt,$autopunitivoTB_totalt);
$primero_texto = $maciConfigurationModel->getPersonalidadPP($primero['llave']);
$tiposresponsalbilidad = $register['id_client']." muestra patrones de personalidad de ".$primero['llave']." ".$primero_texto;
$primero_ajusteTT = $maciConfigurationModel->getPrototipoPersonalidad([],$introversionTB_total,$inhibidoTB_total,$pesimistaTB_total,$sumisoTB_total,$histrionicoTB_total,$egocentricoTB_total,$rebeldeTB_total,$rudoTB_total,$conformistaTB_total,$oposicionistaTB_total,$autopunitivoTB_total);
$primero_respuestaT = $maciConfigurationModel->getPersonalidadPPInterpretacion($primero['llave'],$introversionTB_total,$inhibidoTB_total,$pesimistaTB_total,$sumisoTB_total,$histrionicoTB_total,$egocentricoTB_total,$rebeldeTB_total,$rudoTB_total,$conformistaTB_total,$oposicionistaTB_total,$autopunitivoTB_total);
$tiposresponsalbilidad .= "Su puntuación de TB ".round($primero_ajusteTT['total']).", ".$primero_respuestaT;


$tiposresponsalbilidad2 = "Además de este patrón de personalidad ".$primero['llave'].", ".$register['id_client']." también presenta características de los siguientes prototipos, que destacan en su personalidad:";

$segundo = $maciConfigurationModel->getPrototipoPersonalidad([$primero['llave']],$introversionTB_totalt,$inhibidoTB_totalt,$pesimistaTB_totalt,$sumisoTB_totalt,$histrionicoTB_totalt,$egocentricoTB_totalt,$rebeldeTB_totalt,$rudoTB_totalt,$conformistaTB_totalt,$oposicionistaTB_totalt,$autopunitivoTB_totalt);
$segundo_texto = $maciConfigurationModel->getPersonalidadPP($segundo['llave']);
$segundo_ajusteTT = $maciConfigurationModel->getPrototipoPersonalidad([$primero['llave']],$introversionTB_total,$inhibidoTB_total,$pesimistaTB_total,$sumisoTB_total,$histrionicoTB_total,$egocentricoTB_total,$rebeldeTB_total,$rudoTB_total,$conformistaTB_total,$oposicionistaTB_total,$autopunitivoTB_total);

$tiposresponsalbilidad3 = $register['id_client']." muestra patrones de personalidad de ".$segundo['llave']." ".$segundo_texto;
$segundo_respuestaT = $maciConfigurationModel->getPersonalidadPPInterpretacion($segundo['llave'],$introversionTB_total,$inhibidoTB_total,$pesimistaTB_total,$sumisoTB_total,$histrionicoTB_total,$egocentricoTB_total,$rebeldeTB_total,$rudoTB_total,$conformistaTB_total,$oposicionistaTB_total,$autopunitivoTB_total);

$tiposresponsalbilidad3 .= "obtuvo una puntuación de TB ".round($segundo_ajusteTT['total']).", ".$segundo_respuestaT;

$tercero = $maciConfigurationModel->getPrototipoPersonalidad([$primero['llave'],$segundo['llave']],$introversionTB_totalt,$inhibidoTB_totalt,$pesimistaTB_totalt,$sumisoTB_totalt,$histrionicoTB_totalt,$egocentricoTB_totalt,$rebeldeTB_totalt,$rudoTB_totalt,$conformistaTB_totalt,$oposicionistaTB_totalt,$autopunitivoTB_totalt);
$tercero_texto = $maciConfigurationModel->getPersonalidadPP($tercero['llave']);

$tercero_ajusteTT = $maciConfigurationModel->getPrototipoPersonalidad([$primero['llave'],$segundo['llave']],$introversionTB_total,$inhibidoTB_total,$pesimistaTB_total,$sumisoTB_total,$histrionicoTB_total,$egocentricoTB_total,$rebeldeTB_total,$rudoTB_total,$conformistaTB_total,$oposicionistaTB_total,$autopunitivoTB_total);
$tiposresponsalbilidad4 = "Ademas muestra ".$tercero['llave']." ".$tercero_texto;
$tercero_respuestaT = $maciConfigurationModel->getPersonalidadPPInterpretacion($tercero['llave'],$introversionTB_total,$inhibidoTB_total,$pesimistaTB_total,$sumisoTB_total,$histrionicoTB_total,$egocentricoTB_total,$rebeldeTB_total,$rudoTB_total,$conformistaTB_total,$oposicionistaTB_total,$autopunitivoTB_total);

$tiposresponsalbilidad4 .= $register['id_client']." obtuvo una puntuación de TB ".round($tercero_ajusteTT['total']).", ".$tercero_respuestaT;

$cuarto = $maciConfigurationModel->getPrototipoPersonalidad([$primero['llave'],$segundo['llave'],$tercero['llave']],$introversionTB_totalt,$inhibidoTB_totalt,$pesimistaTB_totalt,$sumisoTB_totalt,$histrionicoTB_totalt,$egocentricoTB_totalt,$rebeldeTB_totalt,$rudoTB_totalt,$conformistaTB_totalt,$oposicionistaTB_totalt,$autopunitivoTB_totalt);
$cuarto_texto = $maciConfigurationModel->getPersonalidadPP($cuarto['llave']);

$cuarto_ajusteTT = $maciConfigurationModel->getPrototipoPersonalidad([$primero['llave'],$segundo['llave'],$tercero['llave']],$introversionTB_total,$inhibidoTB_total,$pesimistaTB_total,$sumisoTB_total,$histrionicoTB_total,$egocentricoTB_total,$rebeldeTB_total,$rudoTB_total,$conformistaTB_total,$oposicionistaTB_total,$autopunitivoTB_total);
$tiposresponsalbilidad5 = $cuarto['llave']." ".$cuarto_texto;
$cuarto_respuestaT = $maciConfigurationModel->getPersonalidadPPInterpretacion($cuarto['llave'],$introversionTB_total,$inhibidoTB_total,$pesimistaTB_total,$sumisoTB_total,$histrionicoTB_total,$egocentricoTB_total,$rebeldeTB_total,$rudoTB_total,$conformistaTB_total,$oposicionistaTB_total,$autopunitivoTB_total);

$tiposresponsalbilidad5 .= $register['id_client']." obtuvo una puntuación de TB ".round($cuarto_ajusteTT['total']).", ".$cuarto_respuestaT;

$tiposresponsalbilidad6 = "Los síndromes clínicos son un conjunto de comportamientos, pensamientos y sentimientos agrupados que indican un estado psicológico problemático activo. A diferencia de los prototipos de personalidad, que son patrones de personalidad más duraderos, los síndromes clínicos tienden a ser más estados relativamente diferenciados y transitorios, que crecen y disminuyen en periodo de tiempo, dependiendo de las situaciones. En el contexto del Inventario Clínico para Adolescentes de Millon (MACI), los síndromes clínicos se conceptualizan como  extensiones o distorsiones de la personalidad básica del adolescente. Son de tipo reactivo, siento substancialmente de una duración breve que los trastornos de personalidad, representan estados en los que se manifiesta claramente un proceso patológico activo. A continuación, se describirán los síndromes clínicos destacados en ";
$tiposresponsalbilidad6 .= $register['id_client'].":";

//sindromes clinicos
$transtornoAlimentacionTB_total = $transtornoAlimentacionTB + (7-84+2)*0.001;
$inclinacionAbusoSusTB_total = $inclinacionAbusoSusTB + (7-85+2)*0.001;
$predisposicionDeliTB_total = $predisposicionDeliTB + (7-86+2)*0.001;
$propensionInTB_total = $propensionInTB + (7-87+2)*0.001;
$sentimientoAncTB_total = $sentimientoAncTB + (7-88+2)*0.001;
$afectoDepresivoTB_total = $afectoDepresivoTB + (7-89+2)*0.001;
$tendenciaSuicidioTB_total = $tendenciaSuicidioTB + (7-90+2)*0.001;

$quinto = $maciConfigurationModel->getSindromeClinico([],$transtornoAlimentacionTB_total,$inclinacionAbusoSusTB_total,$predisposicionDeliTB_total,$propensionInTB_total,$sentimientoAncTB_total,$afectoDepresivoTB_total,$tendenciaSuicidioTB_total);
$quinto_texto = $maciConfigurationModel->getObjetivoSindromeClinico($quinto['llave']);
$quinto_ajusteTT = $maciConfigurationModel->getSindromeClinico([],$transtornoAlimentacionTB,$inclinacionAbusoSusTB,$predisposicionDeliTB,$propensionInTB,$sentimientoAncTB,$afectoDepresivoTB,$tendenciaSuicidioTB);
$tiposresponsalbilidad7 = $register['id_client'] . ' Muestra una puntuación TB '.round($quinto['total'])." en el síndrome de ".$quinto['llave'];
$tiposresponsalbilidad7 .= $quinto_texto.", El resultado ";
$quinto_respuestaT = $maciConfigurationModel->getSindromeClinicoInterpretacion($quinto['llave'],$transtornoAlimentacionTB,$inclinacionAbusoSusTB,$predisposicionDeliTB,$propensionInTB,$sentimientoAncTB,$afectoDepresivoTB,$tendenciaSuicidioTB);

$tiposresponsalbilidad7 .= $quinto_respuestaT;

$tiposresponsalbilidad8 = "Además de este síndrome, ".$register['id_client'] ." también presenta características de los siguientes síndromes clínicos, que pueden estar presentes en menor medida o ausentes:";

$sexto = $maciConfigurationModel->getSindromeClinico([$quinto['llave']],$transtornoAlimentacionTB_total,$inclinacionAbusoSusTB_total,$predisposicionDeliTB_total,$propensionInTB_total,$sentimientoAncTB_total,$afectoDepresivoTB_total,$tendenciaSuicidioTB_total);
$sexto_texto = $maciConfigurationModel->getObjetivoSindromeClinico($sexto['llave']);
$sexto_ajusteTT = $maciConfigurationModel->getSindromeClinico([$quinto['llave']],$transtornoAlimentacionTB,$inclinacionAbusoSusTB,$predisposicionDeliTB,$propensionInTB,$sentimientoAncTB,$afectoDepresivoTB,$tendenciaSuicidioTB);

$tiposresponsalbilidad9 = $sexto['llave'] . " ".$sexto_texto ;
$tiposresponsalbilidad9 .= $register['id_client'] . ' Muestra una puntuación TB '.round($sexto['total']).", lo que ";
$sexto_respuestaT = $maciConfigurationModel->getSindromeClinicoInterpretacion($sexto['llave'],$transtornoAlimentacionTB,$inclinacionAbusoSusTB,$predisposicionDeliTB,$propensionInTB,$sentimientoAncTB,$afectoDepresivoTB,$tendenciaSuicidioTB);
$tiposresponsalbilidad9 .= $sexto_respuestaT;


$septimo = $maciConfigurationModel->getSindromeClinico([$quinto['llave'],$sexto['llave']],$transtornoAlimentacionTB_total,$inclinacionAbusoSusTB_total,$predisposicionDeliTB_total,$propensionInTB_total,$sentimientoAncTB_total,$afectoDepresivoTB_total,$tendenciaSuicidioTB_total);
$septimo_texto = $maciConfigurationModel->getObjetivoSindromeClinico($septimo['llave']);
$septimo_ajusteTT = $maciConfigurationModel->getSindromeClinico([$quinto['llave'],$sexto['llave']],$transtornoAlimentacionTB,$inclinacionAbusoSusTB,$predisposicionDeliTB,$propensionInTB,$sentimientoAncTB,$afectoDepresivoTB,$tendenciaSuicidioTB);
$tiposresponsalbilidad10 = $septimo['llave'] . " ".$septimo_texto ;
$tiposresponsalbilidad10 .= $register['id_client'] . ' Muestra una puntuación TB '.round($septimo['total']).", lo que ";
$septimo_respuestaT = $maciConfigurationModel->getSindromeClinicoInterpretacion($septimo['llave'],$transtornoAlimentacionTB,$inclinacionAbusoSusTB,$predisposicionDeliTB,$propensionInTB,$sentimientoAncTB,$afectoDepresivoTB,$tendenciaSuicidioTB);
$tiposresponsalbilidad10 .= $septimo_respuestaT;
//PREOCUPACIONES EXPRESADAS

$octavo = $maciConfigurationModel->getPreocupacionesExpresadasTB([],$desagradoPropioTB,$difusionIdentidadTB,$insencibilidadSocialTB,$desvalorizacionMismoTB,$incomodidadRespetoTB,$inseguridadIgualTB,$discordanciaFamiliarTB,$abusosInfanciaTB);

$tiposresponsalbilidad11 = $register['id_client'].' obtuvo una puntuación de TB '.$octavo['total'].', en la escala de '.$octavo['llave']." (";
$tiposresponsalbilidad11 .= $octavo['objetivo']. "). La puntuación obtenida ".$octavo['interpretacion'];

$tiposresponsalbilidad12 = "Además de la escala de ".$octavo['llave'].", también presenta otras preocupaciones significativas, reflejadas en las siguientes escalas:";

$noveno = $maciConfigurationModel->getPreocupacionesExpresadasTB([$octavo['llave']],$desagradoPropioTB,$difusionIdentidadTB,$insencibilidadSocialTB,$desvalorizacionMismoTB,$incomodidadRespetoTB,$inseguridadIgualTB,$discordanciaFamiliarTB,$abusosInfanciaTB);
$tiposresponsalbilidad13 = "Se observa una puntuación de TB ".$noveno['total'].', en la escala de '.$noveno['llave']." (";
$tiposresponsalbilidad13 .= $noveno['objetivo']. "). La puntuación obtenida ".$noveno['interpretacion'];

$decimo = $maciConfigurationModel->getPreocupacionesExpresadasTB([$octavo['llave'],$noveno['llave']],$desagradoPropioTB,$difusionIdentidadTB,$insencibilidadSocialTB,$desvalorizacionMismoTB,$incomodidadRespetoTB,$inseguridadIgualTB,$discordanciaFamiliarTB,$abusosInfanciaTB);
$tiposresponsalbilidad14 = "También se observa una puntuación de TB ".$decimo['total'].', en la escala de '.$decimo['llave']." (";
$tiposresponsalbilidad14 .= $decimo['objetivo']. "). La puntuación obtenida ".$decimo['interpretacion'];

$decimo_uno = $maciConfigurationModel->getPreocupacionesExpresadasTB([$octavo['llave'],$noveno['llave'],$decimo['llave']],$desagradoPropioTB,$difusionIdentidadTB,$insencibilidadSocialTB,$desvalorizacionMismoTB,$incomodidadRespetoTB,$inseguridadIgualTB,$discordanciaFamiliarTB,$abusosInfanciaTB);
$tiposresponsalbilidad15 = "Por último, se observa una puntuación de TB ".$decimo_uno['total'].', en la escala de '.$decimo_uno['llave']." (";
$tiposresponsalbilidad15 .= $decimo_uno['objetivo']. "). La puntuación obtenida ".$decimo_uno['interpretacion'];

//puntos fuertes
$decimo_dos = $maciConfigurationModel->getPuntosFuertesTB([],$desagradoPropioTB,$difusionIdentidadTB,$insencibilidadSocialTB,$desvalorizacionMismoTB,$incomodidadRespetoTB,$inseguridadIgualTB,$discordanciaFamiliarTB,$abusosInfanciaTB);
$tiposresponsalbilidad16 = "No reporta Tasas Base (TB) menores o iguales a 35 como puntos fuertes.";

if($decimo_dos != null){
    $tiposresponsalbilidad16 = "Se observa una puntuación de TB ".$decimo_dos['total'].' en la escala de '.$decimo_dos['llave'].' (';
    $tiposresponsalbilidad16 .= $decimo_dos['objetivo']."), En este caso, la baja puntuación indica que ".$decimo_dos['interpretacion'];
}

$decimo_tres = $maciConfigurationModel->getPuntosFuertesTB([$decimo_dos['llave']],$desagradoPropioTB,$difusionIdentidadTB,$insencibilidadSocialTB,$desvalorizacionMismoTB,$incomodidadRespetoTB,$inseguridadIgualTB,$discordanciaFamiliarTB,$abusosInfanciaTB);

$tiposresponsalbilidad17 = "";
if($decimo_tres != null){
    $tiposresponsalbilidad17 = "Finalmente, se observa una puntuación de TB ".$decimo_tres['total'].' en la escala de '.$decimo_tres['llave'].' (';
    $tiposresponsalbilidad17 .= $decimo_tres['objetivo']."), En este caso, la baja puntuación indica que ".$decimo_tres['interpretacion'];
}
//otros
$tiposresponsalbilidad18 = $register['id_client']." identificó las siguientes problemáticas que le generan mayor preocupación:";

$answer_questions = $answerModel->getAll($register['codes'],1001,1100);

$tiposresponsalbilidad19 = "";
foreach($answer_questions as $answer){
    if($answer['response'] == 1){
        $tiposresponsalbilidad19 .= "<br>".$answer['question'];
    }
}

$answer_input = $answerModel->getMaciInputProblem($idpatient);

if($answer_input != null){
    $tiposresponsalbilidad19 .= "<br>".$answer_input['response_data'];
}

$tiposresponsalbilidad20 =$register['id_client']." contestó a los siguientes ítems que sugieren áreas problemáticas específicas que requieren investigar:";

$answer_questions2 = $answerModel->getAll($register['codes'],51,51)[0];

$tiposresponsalbilidad21 = "";//D
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad21 .= "No creo tener tanto interés por el sexo como la gente de mi edad. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],59,59)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad21 .= "Me incomoda coquetear (ligar). <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],62,62)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad21 .= "Me incomoda pensar en el sexo. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],94,94)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad21 .= "Me incomoda pensar que el sexo es placentero. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],116,116)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad21 .= "Muchas veces me desconcierta pensar en el sexo. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],131,131)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad21 .= "Me incomoda con la forma en que mi cuerpo se ha desarrollado. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],143,143)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad21 .= "Me incomoda que los sentimientos acerca del sexo se hayan convertido en una parte de mi vida. <br>";
}


$tiposresponsalbilidad22 = "";//D
$answer_questions2 = $answerModel->getAll($register['codes'],55,55)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad22 .= "He sido abusado sexualmente. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],14,14)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad22 .= "Me da mucha vergüenza contarles a otras personas cómo abusaron de mí. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],129,129)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad22 .= "Me avergüenzo de algunas cosas terribles que me han hecho los adultos. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],137,137)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad22 .= "Hubo personas que hicieron cosas sexuales conmigo cuando yo, todavía, no podía entender. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],123,123)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad22 .= "He intentado suicidarme, en el pasado. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],72,72)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad22 .= "Odio recordar alguna de las formas en que abusaron de mí. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],153,153)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad22 .= "La mayor parte del tiempo me siento solo y vacío. <br>";
}
$tiposresponsalbilidad23 = "";//D
$answer_questions2 = $answerModel->getAll($register['codes'],62,62)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad23 .= "Disfruto pensando en el sexo. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],94,94)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad23 .= "El sexo es algo placentero. <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],59,59)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad23 .= "Me gusta mucho coquetear (ligar). <br>";
}
$answer_questions2 = $answerModel->getAll($register['codes'],143,143)[0];
if($answer_questions2['response'] == '1'){
    $tiposresponsalbilidad23 .= "Me agrada que ahora los sentimientos acerca del sexo se hayan convertido en una parte de mi vida. <br>";
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>

		<!-- Title -->
		<title> <?=WEB_TITLE?> </title>

		<!-- Favicon -->
		<link rel="icon" href="../../assets/img/brand/favicon.png" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="../../assets/css/icons.css" rel="stylesheet">

		<!-- Bootstrap css -->
		<link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- Internal Morris Css-->
		<link href="../../assets/plugins/morris.js/morris.css" rel="stylesheet">

		<!--  Right-sidemenu css -->
		<link href="../../assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!--  Custom Scroll bar-->
		<link href="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!--- Style css-->
		<link href="../../assets/css/style.css" rel="stylesheet">
		<link href="../../assets/css/style-dark.css" rel="stylesheet">
		<link href="../../assets/css/boxed.css" rel="stylesheet">
		<link href="../../assets/css/dark-boxed.css" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="../../assets/css/skin-modes.css" rel="stylesheet" />

		<!--- Animations css-->
		<link href="../../assets/css/animate.css" rel="stylesheet">
        <link href="https://db.onlinewebfonts.com/c/5f9ecd69838280dcd8a9f0072f92f6a6?family=Ronnia+W01+Regular" rel="stylesheet">
        <style>
            @font-face {
                font-family: "Ronnia W01 Regular";
                src: url("https://db.onlinewebfonts.com/t/5f9ecd69838280dcd8a9f0072f92f6a6.woff2") format("woff2"),
                    url("https://db.onlinewebfonts.com/t/5f9ecd69838280dcd8a9f0072f92f6a6.woff") format("woff");
                }
        </style>
        <link href="../../assets/css/style_profile.css?v=<?=VERSION_CODE?>" rel="stylesheet">
	</head>

	<body class="main-body">

		<!-- Loader -->
		<div id="global-loader">
			<img src="../../assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">
            <header>
                <!-- main-header opened -->
                <?php include("../include/header_top.php");?>
                <!-- /main-header -->
                <!--Horizontal-main -->
                <?php include("../include/header_bottom.php");?>
            </header>
			<!--Horizontal-main -->
			<!-- main-content opened -->
			<div class="main-content horizontal-content" >
                <br>
				<!-- container opened -->
				<div class="container" >


					<!-- row -->
					<div class="row row-sm">
                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
							<div id="contenido1" class="card card-maci">
								<div class="card-body">
                                    <div class="row row-sm">
                                        <div class="col-12 col-md-3 col-lg-2 img-container">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo"  src="../../assets/img/test_image/perfil-sf.png?v=<?=VERSION_CODE?>">
                                            <img alt="" class="float-sm-right wd-100p mg-sm-t-0 img-logo"  src="../../assets/img/test_image/logomaci.jpeg?v=<?=VERSION_CODE?>">
                                        </div>
                                        <div class="col-12 col-md-9 col-lg-10">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text setting-input">
                                                        <span class="input-group-text setting-input">Id</span>
                                                    </div><input class="form-control" style="color: black;" value="<?=$register['id_client']?>" type="text">
                                                </div><!-- input-group -->
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text setting-input">
                                                        <span class="input-group-text setting-input">Edad</span>
                                                    </div><input class="form-control" style="text-align: center;color: black;" value="<?=$register['age']?>" type="text">
                                                </div><!-- input-group -->
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text setting-input">
                                                        <span class="input-group-text setting-input">Sexo</span>
                                                    </div><input class="form-control" style="text-align: center;color: black;" value="<?=$register['sex']?>" type="text">
                                                </div><!-- input-group -->
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text setting-input">
                                                        <span class="input-group-text setting-input">Fecha</span>
                                                    </div><input class="form-control" style="text-align: center;color: black;" value="<?= date('Y-m-d H:i:s'); ?>" type="text">
                                                </div><!-- input-group -->
                                            </div>
                                        </div>
                                        <div class="row row-sm">
                                            
                                            <div class="col-md-12 col-lg-6">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text setting-input">
                                                        <span class="input-group-text setting-input">Baremo</span>
                                                    </div>
                                                    <form action="result2.php" method="post" id="form_baremo" style="margin:0;">
                                                        <input type="hidden" name="id_user" id="id_user" value="<?=$idClient?>">
                                                        <input type="hidden" name="id_register" id="id_register" value="<?=$register['id']?>">
                                                        <select style="margin:0px;border-radius: 15px;height: 35px;color: black;" class="form-control mg-t-20 select2-no-search" id="baremo_id" name="baremo_id">
                                                            <?php
                                                            foreach($baremos as $baremo){
                                                            ?>
                                                            <option value="<?=$baremo['id']?>" <?=$baremo['active']=='0'?'disabled':''?> <?=$register['baremo_id']==$baremo['id']?'selected':''?>>
                                                                <?=htmlspecialchars($baremo['name'])?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </form>
                                                </div><!-- input-group -->
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text setting-input">
                                                        <span class="input-group-text setting-input">Responsable de aplicación</span>
                                                    </div><input class="form-control" style="color: black;" value="Edgar Espinoza Jimenez" type="text">
                                                </div><!-- input-group -->
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    
									
								</div>
							</div>
						</div>
                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                            <div   id="contenido2" class="card" >
                                <div class="card-body margen-parent">
                                    <h2 style="place-self: flex-start;">Escalas,PD, TB y Grafico Asociado</h2>
                                    <div class="row row-sm">
                                        <div class="col-md-6" style="padding-right:0px;">
                                            <div class="card-body" style="padding-right: 0px;padding-left: 0px;">
                                                <div style="margin-bottom: 75px;">
                                                    
                                                    <div class="table-responsive">
                                                        <table class="table mg-b-0 text-md-nowrap">
                                                           
                                                            <tbody style="text-align: right;text-align: center;">

                                                                <tr  class="tr_fill" style="border-bottom: 2px solid #5e69aa !important;font-weight: bold;">
                                                                    <td class="td_fill"></td>
                                                                    <th scope="row"  class="text-primary td_name"></th>
                                                                    
                                                                    <td class="td_valuepd">PD</td>
                                                                    <td class="td_valuetb">TB</td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td class="td_fill">Fiabilidad</td>
                                                                    <th scope="row"  class="text-primary td_name">W</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($response_fiabilidad_pd)?></td>
                                                                    <td class="td_valuetb"></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                    <td class="td_fill">Transparencia</td>
                                                                    <th scope="row"  class="text-primary td_name">X</th>
                                                                    
                                                                    <td class="td_valuepd"><span><?=($transparenciaPD)?></td>
                                                                    <td class="td_valuetb"><?=$transparenciaTB?></td>
                                                                </tr>
                                                                
                                                                <tr class="tr_fill">
                                                                <td class="td_fill">Deseabilidad</td>
                                                                    <th scope="row"  class="text-primary td_name">Y</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($deseabilidadPD)?></td>
                                                                    <td class="td_valuetb"><?=$deseabilidadTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill">Alteración</td>
                                                                    <th scope="row"  class="text-primary td_name">Z</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($alteracionPD)?></td>
                                                                    <td class="td_valuetb"><?=$alteracionTB?></td>
                                                                </tr>
                                                                <tr  class="tr_fill" style="border-bottom: 2px solid #5e69aa !important;">
                                                                    
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Introversión</td>
                                                                    <th scope="row"  class="text-primary td_name">1</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($introversionPD)?></td>
                                                                    <td class="td_valuetb"><?=$introversionTB_total?></td>
                                                                </tr>
                                                                
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Inhibido</td>
                                                                    <th scope="row"  class="text-primary td_name">2A</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($inhibidoPD)?></td>
                                                                    <td class="td_valuetb"><?=$inhibidoTB_total?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Pesimista</td>
                                                                    <th scope="row"  class="text-primary td_name">2B</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($pesimistaPD)?></td>
                                                                    <td class="td_valuetb"><?=$pesimistaTB_total?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Sumiso</td>
                                                                    <th scope="row"  class="text-primary td_name">3</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($sumisoPD)?></td>
                                                                    <td class="td_valuetb"><?=$sumisoTB_total?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Histriónico</td>
                                                                    <th scope="row"  class="text-primary td_name">4</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($histrionicoPD)?></td>
                                                                    <td class="td_valuetb"><?=$histrionicoTB_total?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Egocéntrico</td>
                                                                    <th scope="row"  class="text-primary td_name">5</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($egocentricoPD)?></td>
                                                                    <td class="td_valuetb"><?=$egocentricoTB_total?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Rebelde</td>
                                                                    <th scope="row"  class="text-primary td_name">6A</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($rebeldePD)?></td>
                                                                    <td class="td_valuetb"><?=$rebeldeTB_total?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Rudo</td>
                                                                    <th scope="row"  class="text-primary td_name">6B</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($rudoPD)?></td>
                                                                    <td class="td_valuetb"><?=$rudoTB_total?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Conformista</td>
                                                                    <th scope="row"  class="text-primary td_name">7</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($conformistaPD)?></td>
                                                                    <td class="td_valuetb"><?=$conformistaTB_total?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Oposicionista</td>
                                                                    <th scope="row"  class="text-primary td_name">8A</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($oposicionistaPD)?></td>
                                                                    <td class="td_valuetb"><?=$oposicionistaTB_total?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Autopunitivo</td>
                                                                    <th scope="row"  class="text-primary td_name">8B</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($autopunitivoPD)?></td>
                                                                    <td class="td_valuetb"><?=$autopunitivoTB_total?></td>
                                                                </tr>
                                                                <tr  class="tr_fill" style="border-bottom: 2px solid #5e69aa !important;">
                                                                    
                                                                </tr>
                                                                <tr class="tr_fill" >
                                                                <td class="td_fill"> Tendencia límite</td>
                                                                    <th scope="row"  class="text-primary td_name">9</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($tendencia_limitePD)?></td>
                                                                    <td class="td_valuetb"><?=$tendencialimiteTB_total?></td>
                                                                </tr>
                                                                <tr  class="tr_fill" style="border-bottom: 2px solid #5e69aa !important;">
                                                                    
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Difusión de la identidad</td>
                                                                    <th scope="row"  class="text-primary td_name">A</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($difusionIdentidadPD)?></td>
                                                                    <td class="td_valuetb"><?=$difusionIdentidadTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Desvalorización de sí mismo</td>
                                                                    <th scope="row"  class="text-primary td_name">B</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($desvalorizacionMismoPD)?></td>
                                                                    <td class="td_valuetb"><?=$desvalorizacionMismoTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Desagrado por el propio cuerpo</td>
                                                                    <th scope="row"  class="text-primary td_name">C</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($desagradoPropioPD)?></td>
                                                                    <td class="td_valuetb"><?=$desagradoPropioTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Incomodidad respecto al sexo</td>
                                                                    <th scope="row"  class="text-primary td_name">D</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($incomodidadRespetoPD)?></td>
                                                                    <td class="td_valuetb"><?=$incomodidadRespetoTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Inseguridad con los iguales</td>
                                                                    <th scope="row"  class="text-primary td_name">E</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($inseguridadIgualPD)?></td>
                                                                    <td class="td_valuetb"><?=$inseguridadIgualTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Insensibilidad social</td>
                                                                    <th scope="row"  class="text-primary td_name">F</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($insencibilidadSocialPD)?></td>
                                                                    <td class="td_valuetb"><?=$insencibilidadSocialTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Discordancia familiar</td>
                                                                    <th scope="row"  class="text-primary td_name">G</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($discordanciaFamiliarPD)?></td>
                                                                    <td class="td_valuetb"><?=$discordanciaFamiliarTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Abusos en la infancia</td>
                                                                    <th scope="row"  class="text-primary td_name">H</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($abusosInfanciaPD)?></td>
                                                                    <td class="td_valuetb"><?=$abusosInfanciaTB?></td>
                                                                </tr>
                                                                <tr  class="tr_fill" style="border-bottom: 2px solid #5e69aa !important;">
                                                                    
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Trastornos de la alimentación</td>
                                                                    <th scope="row"  class="text-primary td_name">AA</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($transtornoAlimentacionPD)?></td>
                                                                    <td class="td_valuetb"><?=$transtornoAlimentacionTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Inclinación al abuso de sustancias</td>
                                                                    <th scope="row"  class="text-primary td_name">BB</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($inclinacionAbusoSusPD)?></td>
                                                                    <td class="td_valuetb"><?=$inclinacionAbusoSusTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Predisposición a la delincuencia</td>
                                                                    <th scope="row"  class="text-primary td_name">CC</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($predisposicionDeliPD)?></td>
                                                                    <td class="td_valuetb"><?=$predisposicionDeliTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Propensión a la impulsividad</td>
                                                                    <th scope="row"  class="text-primary td_name">DD</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($propensionInPD)?></td>
                                                                    <td class="td_valuetb"><?=$propensionInTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Sentimiento de ansiedad</td>
                                                                    <th scope="row"  class="text-primary td_name">EE</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($sentimientoAncPD)?></td>
                                                                    <td class="td_valuetb"><?=$sentimientoAncTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Afecto depresivo</td>
                                                                    <th scope="row"  class="text-primary td_name">FF</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($afectoDepresivoPD)?></td>
                                                                    <td class="td_valuetb"><?=$afectoDepresivoTB?></td>
                                                                </tr>
                                                                <tr class="tr_fill">
                                                                <td class="td_fill"> Tendencia al suicidio</td>
                                                                    <th scope="row"  class="text-primary td_name">GG</th>
                                                                    
                                                                    <td class="td_valuepd"><?=($tendenciaSuicidioPD)?></td>
                                                                    <td class="td_valuetb"><?=$tendenciaSuicidioTB?></td>
                                                                </tr>
                                                                <tr  class="tr_fill" style="border-bottom: 2px solid #5e69aa !important;">
                                                                    
                                                                </tr>
                                                                <tr  class="tr_fill" style="font-weight: bold;">
                                                                    <td class="td_fill"></td>
                                                                    <th scope="row"  class="text-primary td_name"></th>
                                                                    
                                                                    <td class="td_valuepd">PD</td>
                                                                    <td class="td_valuetb">TB</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding-left:0px;">
                                            <div class="card-body" style="padding-left: 0px;padding-right: 0px;">
                                                <div class="ht-100 ht-sm-300" style="margin-top: 9px;height: 780px !important;width: 400px;" id="colorss"></div>
                                                <div class="ht-100 ht-sm-300" style="margin-top: 15px;width: 400px;height: 110px !important;" id="flotLine2"></div>
                                                <div class="ht-100 ht-sm-300" style="width: 400px;height: 276px !important;margin-top: -9px;" id="flotLineIndGeneral"></div>
                                                <div class="ht-100 ht-sm-300" style="width: 400px;height: 40px !important;margin-top: -9px;" id="flotLineIndRiesgoPat"></div>
                                                <div class="ht-100 ht-sm-300" style="width: 400px;height: 205px !important;margin-top: -10px;" id="flotLineEscalasClinicas"></div>
                                                <div class="ht-100 ht-sm-300" style="width: 400px;height: 180px !important;margin-top: -10px;" id="flotLineSindromesClinicos"></div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
						
                        <div class="col-md-12">
                            <div id="contenido3" class="card card-body" style="padding-bottom: 100px;text-align: justify;">
                                <div class="main-content-label mg-b-5">
                                    <h1 style="text-align: center;">INFORME INTERPRETATIVO MACI</h1>
                                </div>
                                <div class="card-body">
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">ACTITUD ANTE LA PRUEBA</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13">En esta sección se analizan las puntuaciones obtenidas por el adolescente en las escalas de Validez (V), Transparencia (X), Deseabilidad (Y) y Alteración (Z). Estos indicadores afectan a la fiabilidad y validez de este Inventario clínico y pretenden detectar estilos infrecuentes de respuestas.</p>
                                    <br>
                                    
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">Validez (V)</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$validesV?></p>
                                    <br>
                                    
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">Transparencia  (X)</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$transpareciaX?></p>
                                    <br>

                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">Deseabilidad (Y)</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$deseabilidadY?></p>
                                    <br>

                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">Alteración (Z)</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$alteracionZ?></p>
                                    <br><br><br><br>

                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">EJE II SEVERIDAD DEL PERFIL CLÍNICO</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13">Este apartado refleja la posible existencia de puntuaciones destacadas en las escalas de <span class="title fw-semibold tx-13">Trastornos de la Personalidad Graves (Tendencias Límite):</span> </p>
                                    
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$gravestendencia?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">TIPOS DE RESPONSABILIDAD</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13">Los prototipos de personalidad en el MACI (Inventario Clínico para Adolescentes de Millon) miden patrones persistentes de pensamientos, sentimientos y comportamientos que caracterizan la forma en que un adolescente se relaciona consigo mismo y con los demás. En este apartado se detalla los patrones de personalidad en las que ha obtenido puntuaciones que indican la presencia de rasgos de personalidad:</p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad?></p>
                                    <br><br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad2?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad3?></p>
                                    <br><br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad4?></p>
                                    <br><br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad5?></p>
                                    <br><br>
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">EJE I: SÍNDROMES CLÍNICOS</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad6?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad7?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad8?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad9?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad10?></p>
                                    <br><br><br>
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">PREOCUPACIONES EXPRESADAS</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13">El MACI (Inventario Clínico para Adolescentes de Millon) las preocupaciones expresadas se centran en los sentimientos y actitudes acerca de cuestiones que tienden a preocupar a la mayoría de los adolescentes con problemas. La intensidad con que se experimenta queda reflejada en la evaluación de las puntuaciones de cada escala, hay que destacar que estas escalas representan percepciones más que criterios o comportamientos objetivamente observables. A continuación, se detallarán las preocupaciones destacadas:							</p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad11?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad12?></p>

                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad13?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad14?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad15?></p>
                                    <br><br><br>
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">PUNTOS FUERTES</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13">A continuación, se presentan los puntos fuertes identificados con tasas base (TB) menores o iguales a 35.</p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad16?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad17?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad18?></p>
                                    <br>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad19?></p>
                                    <br><br>
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">RESPUESTAS DESTACADAS</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad20?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">D. Incomodidad respecto al sexo</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad21?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">H. Abusos en la infancia</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad22?></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><span class="title fw-semibold tx-13">Otros respuestas relevantes</span></p>
                                    <br>
                                    <p class="tx-dark mb-0 tx-13"><?=$tiposresponsalbilidad23?></p>
                                </div>
                                
                            </div>
                            
                        </div>

					</div>
					<!-- row closed -->
				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

			<?php include("../include/footer.php");?>
			<!-- Footer closed -->

		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<?php include("../include/print_content.php");?>
		<!-- JQuery min js -->
		<script src="../../assets/plugins/jquery/jquery.min.js"></script>

		<!--Internal  Datepicker js -->
		<script src="../../assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

		<!-- Bootstrap Bundle js -->
		<script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

		<!-- Internal Flot js -->
		<script src="../../assets/plugins/jquery.flot/jquery.flot.js"></script>
		<script src="../../assets/plugins/jquery.flot/jquery.flot.pie.js"></script>
		<script src="../../assets/plugins/jquery.flot/jquery.flot.resize.js"></script>

		<!-- Ionicons js -->
		<script src="../../assets/plugins/ionicons/ionicons.js"></script>

		<!-- Moment js -->
		<script src="../../assets/plugins/moment/moment.js"></script>

		<!-- Internal Select2 js-->
		<script src="../../assets/plugins/select2/js/select2.min.js"></script>

		<!-- P-scroll js -->
		<script src="../../assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="../../assets/plugins/perfect-scrollbar/p-scroll.js"></script>

		<!-- eva-icons js -->
		<script src="../../assets/js/eva-icons.min.js"></script>

		<!-- Internal Chart flot js -->
		<!--script src="../../assets/js/chart.flot.js"></script-->

		<!-- Rating js-->
		<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="../../assets/plugins/rating/jquery.barrating.js"></script>

		<!-- Custom Scroll bar Js-->
		<script src="../../assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

		<!-- Horizontalmenu js-->
		<script src="../../assets/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>

				<!-- Sticky js -->
		<script src="../../assets/js/sticky.js"></script>

		<!-- Right-sidebar js -->
		<script src="../../assets/plugins/sidebar/sidebar.js"></script>
		<script src="../../assets/plugins/sidebar/sidebar-custom.js"></script>

		<!-- custom js -->
		<script src="../../assets/js/custom.js?v=<?=VERSION_CODE?>"></script>
        <script src="../../assets/js/print.js?v=<?=VERSION_CODE?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script>
            var pathprint = "<?php echo LOCALHOST; ?>";
            $(function() {
            'use strict';
                var colorLine = "black";
                var flotLine2 = [
                    [<?=$transparenciaTB?>,8],
                    [<?=$deseabilidadTB?>,3],
                    [<?=$alteracionTB?>,-2]
                ];
                
                var plot = $.plot($('#flotLine2'), [{
                    data: flotLine2,
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show:false
                    },
                    grid: {
                        borderWidth: 1,
                        borderColor: 'transparent',
                        hoverable: true,
                        show:true
                    },
                    yaxis: {
                        min: -5,
                        max: 15,
                        color: 'transparent',
                        ticks: [[0, ''], [13, '']], 
                        tickColor: 'black',
                        tickLength: 0,
                        font: {
                            size: 10,
                            color: 'black'
                        }
                    },
                    xaxis: {
                        color: 'black',
                        min:0,
                        max: 115,
                        tickColor: 'black',
                        show:false,
                        tickLength: 0,
                        font: {
                            size: 10,
                            color: 'black'
                        },
                        position:'top'
                    }
                });
                //segunda grafica
                var flotLineIndGeneral = [
                    [<?=$introversionTB_total?>, 100],
                    [<?=$inhibidoTB_total?>, 90],
                    [<?=$pesimistaTB_total?>, 80],
                    [<?=$sumisoTB_total?>, 70],
                    [<?=$histrionicoTB_total?>, 60],
                    [<?=$egocentricoTB_total?>, 50],
                    [<?=$rebeldeTB_total?>, 40],
                    [<?=$rudoTB_total?>, 30],
                    [<?=$conformistaTB_total?>, 20],
                    [<?=$oposicionistaTB_total?>, 10],
                    [<?=$autopunitivoTB_total?>, 0]
                ];
                
                var plot = $.plot($('#flotLineIndGeneral'), [{
                    data: flotLineIndGeneral,
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show:false
                    },
                    grid: {
                        borderWidth: 0,
                        borderColor: 'transparent',
                        hoverable: true,
                        show:true
                    },
                    yaxis: {
                        min: -5,
                        max: 105,
                        color: 'black',
                        ticks: [[0, ''], [105, '']], 
                        tickColor: 'rgba(171, 167, 167, 0)',
                        font: {
                            size: 10,
                            color: 'black'
                        }
                    },
                    xaxis: {
                        color: 'black',
                        min:0,
                        max: 115,
                        tickColor: 'rgba(171, 167, 167, 0)',
                        font: {
                            size: 10,
                            color: 'black'
                        },
                        position:'top',
                        show:false
                    }
                });
            //tercera grafica
            var flotLineIndRiesgoPat = [
                    [<?=34?>, 6]
                ];
                
                var plot = $.plot($('#flotLineIndRiesgoPat'), [{
                    data: flotLineIndRiesgoPat,
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show:false
                    },
                    grid: {
                        borderWidth: 0,
                        borderColor: 'transparent',
                        hoverable: true,
                        show:true,
                        tickColor: 'red',
                    },
                    yaxis: {
                        min: 0,
                        max: 12,
                        color: 'transparent',
                        ticks: [[0, ''], [12, '']], 
                        tickColor: 'transparent',
                        font: {
                            size: 10,
                            color: 'transparent'
                        }
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
                        max: 115,
                        tickColor: 'black',
                        font: {
                            size: 10,
                            color: 'black'
                        },
                        position:'top',
                        show:false
                    }
                });

                //cuarta grafica
                var flotLineEscalasClinicas = [
                    [<?=$difusionIdentidadTB?>, 70],
                    [<?=$desvalorizacionMismoTB?>, 60],
                    [<?=$desagradoPropioTB?>, 50],
                    [<?=$incomodidadRespetoTB?>, 40],
                    [<?=$inseguridadIgualTB?>, 30],
                    [<?=$insencibilidadSocialTB?>, 20],
                    [<?=$discordanciaFamiliarTB?>, 10],
                    [<?=$abusosInfanciaTB?>, 0],
                ];
                
                var plot = $.plot($('#flotLineEscalasClinicas'), [{
                    data: flotLineEscalasClinicas,
                    label: 'Data',
                    color: colorLine
                }], 
                     {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show:false
                    },
                    grid: {
                        borderWidth: 0,
                        borderColor: 'transparent',
                        hoverable: true,
                        show:true
                    },
                    yaxis: {
                        min: -7,
                        max: 74,
                        color: 'transparent',
                        ticks: [[0, ''], [75, '']], 
                        tickColor: 'rgba(171, 167, 167, 0)',
                        font: {
                            size: 10,
                            color: '#999'
                        }
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
                        max: 115,
                        tickColor: 'rgba(171, 167, 167, 0)',
                        font: {
                            size: 10,
                            color: '#999'
                        },
                        position:'top',
                        show:false
                    }
                });
            //quinta grafica 
            var flotLineSindromesClinicos = [
                    [<?=$transtornoAlimentacionTB?>, 60],
                    [<?=$inclinacionAbusoSusTB?>, 50],
                    [<?=$predisposicionDeliTB?>, 40],
                    [<?=$propensionInTB?>, 30],
                    [<?=$sentimientoAncTB?>, 20],
                    [<?=$afectoDepresivoTB?>, 10],
                    [<?=$tendenciaSuicidioTB?>, 0]
                ];
                
                var plot = $.plot($('#flotLineSindromesClinicos'), [{
                    data: flotLineSindromesClinicos,
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show:false
                    },
                    grid: {
                        borderWidth: 0,
                        borderColor: 'transparent',
                        hoverable: true,
                        show:true
                    },
                    yaxis: {
                        min: -5,
                        max: 65,
                        color: '#737f9e',
                        ticks: [[0, ''], [65, '']], 
                        tickColor: 'rgba(171, 167, 167, 0)',
                        font: {
                            size: 10,
                            color: '#999'
                        },
                        show:false
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
                        max: 115,
                        tickColor: 'black',
                        tickLength: 0,
                        ticks: [
                            [0, '0'],
                            [60, '60'],
                            [75, '75'],
                            [85, '85'],
                            [115, '115'],
                        ],
                        
                        position:'bottom',
                        font: {
                            size: 10,
                            color: 'black'
                        },
                        show:true,
                    }
                });

            var colores = $.plot($('#colorss'), [{
                    data: [],
                    label: 'Data',
                    color: colorLine
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2
                        },
                        shadowSize: 0
                    },
                    points: {
                        show: true,
                        radius:3,
                        fill: true,
                        fillColor: colorLine,
                        lineWidth:2.5
                    },
                    legend: {
                        noColumns: 1,
                        position: 'ne',
                        show:false
                    },
                    grid: {
                        borderWidth: 0,
                        borderColor: 'transparent',
                        hoverable: true,
                        show:true,
                        tickColor: 'rgba(171, 167, 167, 0)',
                         markings: [
                            {
                                xaxis: { from: 0, to: 60 },
                                color: '#d7d9ea'
                            },
                            {
                                xaxis: { from: 60, to: 75 }, 
                                color: '#b9bdda'
                            }
                            ,
                            {
                                xaxis: { from: 75, to: 85 }, 
                                color: '#9aa1ca'
                            }
                            ,
                            {
                                xaxis: { from: 85, to: 115 }, 
                                color: '#5e69aa'
                            },
                            { // Línea horizontal en y = 6
                                yaxis: { from: 10.5, to: 10.5 },
                                color: 'white', // color rojo
                                lineWidth: 3
                            },
                            { // Línea horizontal en y = 6
                                yaxis: { from: 6.2, to: 6.2 },
                                color: 'white', // color rojo
                                lineWidth: 3
                            }
                            ,
                            { // Línea horizontal en y = 6
                                yaxis: { from: 5.8, to: 5.8 },
                                color: 'white', // color rojo
                                lineWidth: 3
                            }
                            ,
                            { // Línea horizontal en y = 6
                                yaxis: { from: 2.67, to: 2.67 },
                                color: 'white', // color rojo
                                lineWidth: 3
                            }
                             ,
                            { // Línea horizontal en y = 6
                                yaxis: { from: 0.02, to: 0.02 },
                                color: 'white', // color rojo
                                lineWidth: 5
                            }
                        ]
                    },
                    yaxis: {
                        min: 0,
                        max: 12,
                        color: 'transparent',
                        ticks: [[0, ''], [12, '']], 
                        tickColor: 'transparent',
                        font: {
                            size: 10,
                            color: 'transparent'
                        },
                        show:false
                    },
                    xaxis: {
                        color: '#eee',
                        min:0,
                        max: 115,
                        tickColor: 'black',
                        tickLength: 0,
                        ticks: [
                            [0, '0'],
                            [60, '60'],
                            [75, '75'],
                            [85, '85'],
                            [115, '115'],
                        ],
                        
                        position:'top',
                        font: {
                            size: 10,
                            color: 'black'
                        },
                        show:true,
                    }
                });
            function labelFormatter(label, series) {
                return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
            }
        });
        setTimeout(function() {
            document.getElementById('colorss').style.position = 'absolute';
        }, 1000);
        document.getElementById('baremo_id').addEventListener('change', function() {
            document.getElementById('form_baremo').submit();
        });

        </script>
	</body>
</html>