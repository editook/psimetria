<?php
// Auto-generated MCMI-IV scoring and interpretation configuration model
if (!class_exists('ModelBaremoEspania')) {
    include_once(__DIR__ . '/model_baremo_espania.php');
}
if (!class_exists('ModelBaremoEeuu')) {
    include_once(__DIR__ . '/model_baremo_eeuu.php');
}

class ModelMcmiConfiguration {
    private $scale_rules;
    private $sinceridad_adjustments;
    private $anx_dep_adjustments;
    private $facets_info;
    private $syndromes_info;

    public function __construct() {
        $this->scale_rules = [
            'Esquizoide' => [['item' => 6, 'response' => 'V', 'weight' => 2], ['item' => 15, 'response' => 'V', 'weight' => 2], ['item' => 43, 'response' => 'V', 'weight' => 2], ['item' => 90, 'response' => 'V', 'weight' => 2], ['item' => 119, 'response' => 'V', 'weight' => 2], ['item' => 139, 'response' => 'V', 'weight' => 2], ['item' => 149, 'response' => 'V', 'weight' => 2], ['item' => 180, 'response' => 'V', 'weight' => 2], ['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 24, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 92, 'response' => 'V', 'weight' => 1], ['item' => 190, 'response' => 'V', 'weight' => 1], ['item' => 30, 'response' => 'F', 'weight' => 1], ['item' => 154, 'response' => 'F', 'weight' => 1]],
            'Evitativo' => [['item' => 5, 'response' => 'V', 'weight' => 2], ['item' => 12, 'response' => 'V', 'weight' => 2], ['item' => 26, 'response' => 'V', 'weight' => 2], ['item' => 99, 'response' => 'V', 'weight' => 2], ['item' => 135, 'response' => 'V', 'weight' => 2], ['item' => 195, 'response' => 'V', 'weight' => 2], ['item' => 23, 'response' => 'V', 'weight' => 1], ['item' => 24, 'response' => 'V', 'weight' => 1], ['item' => 52, 'response' => 'V', 'weight' => 1], ['item' => 92, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 112, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1], ['item' => 184, 'response' => 'V', 'weight' => 1], ['item' => 193, 'response' => 'V', 'weight' => 1], ['item' => 46, 'response' => 'F', 'weight' => 1], ['item' => 67, 'response' => 'F', 'weight' => 1], ['item' => 154, 'response' => 'F', 'weight' => 1]],
            'Melancólico' => [['item' => 23, 'response' => 'V', 'weight' => 2], ['item' => 51, 'response' => 'V', 'weight' => 2], ['item' => 71, 'response' => 'V', 'weight' => 2], ['item' => 93, 'response' => 'V', 'weight' => 2], ['item' => 111, 'response' => 'V', 'weight' => 2], ['item' => 169, 'response' => 'V', 'weight' => 2], ['item' => 175, 'response' => 'V', 'weight' => 2], ['item' => 184, 'response' => 'V', 'weight' => 2], ['item' => 193, 'response' => 'V', 'weight' => 2], ['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 22, 'response' => 'V', 'weight' => 1], ['item' => 39, 'response' => 'V', 'weight' => 1], ['item' => 59, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 90, 'response' => 'V', 'weight' => 1], ['item' => 126, 'response' => 'V', 'weight' => 1], ['item' => 170, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1], ['item' => 53, 'response' => 'F', 'weight' => 1]],
            'Dependiente' => [['item' => 4, 'response' => 'V', 'weight' => 2], ['item' => 42, 'response' => 'V', 'weight' => 2], ['item' => 60, 'response' => 'V', 'weight' => 2], ['item' => 77, 'response' => 'V', 'weight' => 2], ['item' => 109, 'response' => 'V', 'weight' => 2], ['item' => 133, 'response' => 'V', 'weight' => 2], ['item' => 162, 'response' => 'V', 'weight' => 2], ['item' => 173, 'response' => 'V', 'weight' => 2], ['item' => 194, 'response' => 'V', 'weight' => 2], ['item' => 5, 'response' => 'V', 'weight' => 1], ['item' => 23, 'response' => 'V', 'weight' => 1], ['item' => 72, 'response' => 'V', 'weight' => 1], ['item' => 175, 'response' => 'V', 'weight' => 1], ['item' => 67, 'response' => 'F', 'weight' => 1]],
            'Histriónico' => [['item' => 10, 'response' => 'V', 'weight' => 2], ['item' => 30, 'response' => 'V', 'weight' => 2], ['item' => 46, 'response' => 'V', 'weight' => 2], ['item' => 84, 'response' => 'V', 'weight' => 2], ['item' => 117, 'response' => 'V', 'weight' => 2], ['item' => 154, 'response' => 'V', 'weight' => 2], ['item' => 171, 'response' => 'V', 'weight' => 2], ['item' => 8, 'response' => 'V', 'weight' => 1], ['item' => 75, 'response' => 'V', 'weight' => 1], ['item' => 155, 'response' => 'V', 'weight' => 1], ['item' => 6, 'response' => 'F', 'weight' => 1], ['item' => 15, 'response' => 'F', 'weight' => 1], ['item' => 24, 'response' => 'F', 'weight' => 1], ['item' => 26, 'response' => 'F', 'weight' => 1], ['item' => 139, 'response' => 'F', 'weight' => 1], ['item' => 178, 'response' => 'F', 'weight' => 1], ['item' => 195, 'response' => 'F', 'weight' => 1]],
            'Tempestuoso' => [['item' => 8, 'response' => 'V', 'weight' => 2], ['item' => 20, 'response' => 'V', 'weight' => 2], ['item' => 53, 'response' => 'V', 'weight' => 2], ['item' => 75, 'response' => 'V', 'weight' => 2], ['item' => 129, 'response' => 'V', 'weight' => 2], ['item' => 155, 'response' => 'V', 'weight' => 2], ['item' => 174, 'response' => 'V', 'weight' => 2], ['item' => 185, 'response' => 'V', 'weight' => 2], ['item' => 30, 'response' => 'V', 'weight' => 1], ['item' => 46, 'response' => 'V', 'weight' => 1], ['item' => 67, 'response' => 'V', 'weight' => 1], ['item' => 84, 'response' => 'V', 'weight' => 1], ['item' => 142, 'response' => 'V', 'weight' => 1], ['item' => 154, 'response' => 'V', 'weight' => 1], ['item' => 26, 'response' => 'F', 'weight' => 1], ['item' => 120, 'response' => 'F', 'weight' => 1], ['item' => 178, 'response' => 'F', 'weight' => 1]],
            'Narcisista' => [['item' => 29, 'response' => 'V', 'weight' => 2], ['item' => 38, 'response' => 'V', 'weight' => 2], ['item' => 54, 'response' => 'V', 'weight' => 2], ['item' => 67, 'response' => 'V', 'weight' => 2], ['item' => 87, 'response' => 'V', 'weight' => 2], ['item' => 106, 'response' => 'V', 'weight' => 2], ['item' => 132, 'response' => 'V', 'weight' => 2], ['item' => 142, 'response' => 'V', 'weight' => 2], ['item' => 159, 'response' => 'V', 'weight' => 2], ['item' => 189, 'response' => 'V', 'weight' => 2], ['item' => 10, 'response' => 'V', 'weight' => 1], ['item' => 19, 'response' => 'V', 'weight' => 1], ['item' => 83, 'response' => 'V', 'weight' => 1], ['item' => 117, 'response' => 'V', 'weight' => 1], ['item' => 171, 'response' => 'V', 'weight' => 1], ['item' => 191, 'response' => 'V', 'weight' => 1]],
            'Antisocial' => [['item' => 11, 'response' => 'V', 'weight' => 2], ['item' => 19, 'response' => 'V', 'weight' => 2], ['item' => 65, 'response' => 'V', 'weight' => 2], ['item' => 83, 'response' => 'V', 'weight' => 2], ['item' => 147, 'response' => 'V', 'weight' => 2], ['item' => 183, 'response' => 'V', 'weight' => 2], ['item' => 191, 'response' => 'V', 'weight' => 2], ['item' => 36, 'response' => 'V', 'weight' => 1], ['item' => 38, 'response' => 'V', 'weight' => 1], ['item' => 105, 'response' => 'V', 'weight' => 1], ['item' => 152, 'response' => 'V', 'weight' => 1], ['item' => 159, 'response' => 'V', 'weight' => 1], ['item' => 48, 'response' => 'F', 'weight' => 1], ['item' => 158, 'response' => 'F', 'weight' => 1]],
            'Sádico' => [['item' => 9, 'response' => 'V', 'weight' => 2], ['item' => 50, 'response' => 'V', 'weight' => 2], ['item' => 66, 'response' => 'V', 'weight' => 2], ['item' => 97, 'response' => 'V', 'weight' => 2], ['item' => 103, 'response' => 'V', 'weight' => 2], ['item' => 115, 'response' => 'V', 'weight' => 2], ['item' => 141, 'response' => 'V', 'weight' => 2], ['item' => 152, 'response' => 'V', 'weight' => 2], ['item' => 11, 'response' => 'V', 'weight' => 1], ['item' => 16, 'response' => 'V', 'weight' => 1], ['item' => 21, 'response' => 'V', 'weight' => 1], ['item' => 74, 'response' => 'V', 'weight' => 1], ['item' => 145, 'response' => 'V', 'weight' => 1], ['item' => 172, 'response' => 'V', 'weight' => 1]],
            'Compulsivo' => [['item' => 2, 'response' => 'V', 'weight' => 2], ['item' => 35, 'response' => 'V', 'weight' => 2], ['item' => 48, 'response' => 'V', 'weight' => 2], ['item' => 63, 'response' => 'V', 'weight' => 2], ['item' => 73, 'response' => 'V', 'weight' => 2], ['item' => 128, 'response' => 'V', 'weight' => 2], ['item' => 140, 'response' => 'V', 'weight' => 2], ['item' => 158, 'response' => 'V', 'weight' => 2], ['item' => 179, 'response' => 'V', 'weight' => 2], ['item' => 188, 'response' => 'V', 'weight' => 2], ['item' => 83, 'response' => 'F', 'weight' => 1], ['item' => 147, 'response' => 'F', 'weight' => 1], ['item' => 152, 'response' => 'F', 'weight' => 1]],
            'Negativista' => [['item' => 17, 'response' => 'V', 'weight' => 2], ['item' => 32, 'response' => 'V', 'weight' => 2], ['item' => 82, 'response' => 'V', 'weight' => 2], ['item' => 96, 'response' => 'V', 'weight' => 2], ['item' => 122, 'response' => 'V', 'weight' => 2], ['item' => 137, 'response' => 'V', 'weight' => 2], ['item' => 167, 'response' => 'V', 'weight' => 2], ['item' => 187, 'response' => 'V', 'weight' => 2], ['item' => 21, 'response' => 'V', 'weight' => 1], ['item' => 37, 'response' => 'V', 'weight' => 1], ['item' => 52, 'response' => 'V', 'weight' => 1], ['item' => 79, 'response' => 'V', 'weight' => 1], ['item' => 88, 'response' => 'V', 'weight' => 1], ['item' => 97, 'response' => 'V', 'weight' => 1], ['item' => 100, 'response' => 'V', 'weight' => 1], ['item' => 168, 'response' => 'V', 'weight' => 1], ['item' => 172, 'response' => 'V', 'weight' => 1], ['item' => 184, 'response' => 'V', 'weight' => 1]],
            'Masoquista' => [['item' => 39, 'response' => 'V', 'weight' => 2], ['item' => 59, 'response' => 'V', 'weight' => 2], ['item' => 85, 'response' => 'V', 'weight' => 2], ['item' => 100, 'response' => 'V', 'weight' => 2], ['item' => 126, 'response' => 'V', 'weight' => 2], ['item' => 166, 'response' => 'V', 'weight' => 2], ['item' => 192, 'response' => 'V', 'weight' => 2], ['item' => 4, 'response' => 'V', 'weight' => 1], ['item' => 12, 'response' => 'V', 'weight' => 1], ['item' => 23, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 156, 'response' => 'V', 'weight' => 1], ['item' => 164, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1], ['item' => 195, 'response' => 'V', 'weight' => 1], ['item' => 20, 'response' => 'F', 'weight' => 1], ['item' => 75, 'response' => 'F', 'weight' => 1]],
            'Esquizotípico' => [['item' => 13, 'response' => 'V', 'weight' => 2], ['item' => 24, 'response' => 'V', 'weight' => 2], ['item' => 44, 'response' => 'V', 'weight' => 2], ['item' => 92, 'response' => 'V', 'weight' => 2], ['item' => 112, 'response' => 'V', 'weight' => 2], ['item' => 156, 'response' => 'V', 'weight' => 2], ['item' => 165, 'response' => 'V', 'weight' => 2], ['item' => 190, 'response' => 'V', 'weight' => 2], ['item' => 18, 'response' => 'V', 'weight' => 1], ['item' => 58, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 90, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 121, 'response' => 'V', 'weight' => 1], ['item' => 123, 'response' => 'V', 'weight' => 1], ['item' => 126, 'response' => 'V', 'weight' => 1], ['item' => 148, 'response' => 'V', 'weight' => 1], ['item' => 163, 'response' => 'V', 'weight' => 1], ['item' => 167, 'response' => 'V', 'weight' => 1], ['item' => 172, 'response' => 'V', 'weight' => 1], ['item' => 195, 'response' => 'V', 'weight' => 1]],
            'Límite' => [['item' => 16, 'response' => 'V', 'weight' => 2], ['item' => 18, 'response' => 'V', 'weight' => 2], ['item' => 37, 'response' => 'V', 'weight' => 2], ['item' => 70, 'response' => 'V', 'weight' => 2], ['item' => 134, 'response' => 'V', 'weight' => 2], ['item' => 164, 'response' => 'V', 'weight' => 2], ['item' => 178, 'response' => 'V', 'weight' => 2], ['item' => 4, 'response' => 'V', 'weight' => 1], ['item' => 59, 'response' => 'V', 'weight' => 1], ['item' => 80, 'response' => 'V', 'weight' => 1], ['item' => 82, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 100, 'response' => 'V', 'weight' => 1], ['item' => 111, 'response' => 'V', 'weight' => 1], ['item' => 126, 'response' => 'V', 'weight' => 1], ['item' => 137, 'response' => 'V', 'weight' => 1], ['item' => 156, 'response' => 'V', 'weight' => 1], ['item' => 166, 'response' => 'V', 'weight' => 1], ['item' => 192, 'response' => 'V', 'weight' => 1], ['item' => 193, 'response' => 'V', 'weight' => 1]],
            'Paranoide' => [['item' => 21, 'response' => 'V', 'weight' => 2], ['item' => 52, 'response' => 'V', 'weight' => 2], ['item' => 79, 'response' => 'V', 'weight' => 2], ['item' => 88, 'response' => 'V', 'weight' => 2], ['item' => 104, 'response' => 'V', 'weight' => 2], ['item' => 136, 'response' => 'V', 'weight' => 2], ['item' => 153, 'response' => 'V', 'weight' => 2], ['item' => 172, 'response' => 'V', 'weight' => 2], ['item' => 13, 'response' => 'V', 'weight' => 1], ['item' => 24, 'response' => 'V', 'weight' => 1], ['item' => 68, 'response' => 'V', 'weight' => 1], ['item' => 96, 'response' => 'V', 'weight' => 1], ['item' => 148, 'response' => 'V', 'weight' => 1], ['item' => 167, 'response' => 'V', 'weight' => 1], ['item' => 180, 'response' => 'V', 'weight' => 1], ['item' => 195, 'response' => 'V', 'weight' => 1]],
            'Ansiedad generalizada' => [['item' => 31, 'response' => 'V', 'weight' => 2], ['item' => 72, 'response' => 'V', 'weight' => 2], ['item' => 89, 'response' => 'V', 'weight' => 2], ['item' => 113, 'response' => 'V', 'weight' => 2], ['item' => 123, 'response' => 'V', 'weight' => 2], ['item' => 143, 'response' => 'V', 'weight' => 2], ['item' => 33, 'response' => 'V', 'weight' => 1], ['item' => 41, 'response' => 'V', 'weight' => 1], ['item' => 44, 'response' => 'V', 'weight' => 1], ['item' => 51, 'response' => 'V', 'weight' => 1], ['item' => 91, 'response' => 'V', 'weight' => 1], ['item' => 108, 'response' => 'V', 'weight' => 1], ['item' => 109, 'response' => 'V', 'weight' => 1]],
            'Síntomas somáticos' => [['item' => 7, 'response' => 'V', 'weight' => 2], ['item' => 28, 'response' => 'V', 'weight' => 2], ['item' => 41, 'response' => 'V', 'weight' => 2], ['item' => 120, 'response' => 'V', 'weight' => 2], ['item' => 146, 'response' => 'V', 'weight' => 2], ['item' => 1, 'response' => 'V', 'weight' => 1], ['item' => 57, 'response' => 'V', 'weight' => 1], ['item' => 113, 'response' => 'V', 'weight' => 1], ['item' => 118, 'response' => 'V', 'weight' => 1], ['item' => 20, 'response' => 'F', 'weight' => 1]],
            'Espectro bipolar' => [['item' => 3, 'response' => 'V', 'weight' => 2], ['item' => 27, 'response' => 'V', 'weight' => 2], ['item' => 56, 'response' => 'V', 'weight' => 2], ['item' => 108, 'response' => 'V', 'weight' => 2], ['item' => 163, 'response' => 'V', 'weight' => 2], ['item' => 177, 'response' => 'V', 'weight' => 2], ['item' => 37, 'response' => 'V', 'weight' => 1], ['item' => 50, 'response' => 'V', 'weight' => 1], ['item' => 54, 'response' => 'V', 'weight' => 1], ['item' => 82, 'response' => 'V', 'weight' => 1], ['item' => 83, 'response' => 'V', 'weight' => 1], ['item' => 105, 'response' => 'V', 'weight' => 1], ['item' => 155, 'response' => 'V', 'weight' => 1]],
            'Depresión persistente' => [['item' => 14, 'response' => 'V', 'weight' => 2], ['item' => 34, 'response' => 'V', 'weight' => 2], ['item' => 64, 'response' => 'V', 'weight' => 2], ['item' => 118, 'response' => 'V', 'weight' => 2], ['item' => 151, 'response' => 'V', 'weight' => 2], ['item' => 170, 'response' => 'V', 'weight' => 2], ['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 28, 'response' => 'V', 'weight' => 1], ['item' => 39, 'response' => 'V', 'weight' => 1], ['item' => 51, 'response' => 'V', 'weight' => 1], ['item' => 71, 'response' => 'V', 'weight' => 1], ['item' => 77, 'response' => 'V', 'weight' => 1], ['item' => 85, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 101, 'response' => 'V', 'weight' => 1], ['item' => 111, 'response' => 'V', 'weight' => 1], ['item' => 114, 'response' => 'V', 'weight' => 1], ['item' => 120, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1], ['item' => 193, 'response' => 'V', 'weight' => 1], ['item' => 75, 'response' => 'F', 'weight' => 1]],
            'Consumo de alcohol' => [['item' => 25, 'response' => 'V', 'weight' => 2], ['item' => 45, 'response' => 'V', 'weight' => 2], ['item' => 94, 'response' => 'V', 'weight' => 2], ['item' => 130, 'response' => 'V', 'weight' => 2], ['item' => 161, 'response' => 'V', 'weight' => 2], ['item' => 65, 'response' => 'V', 'weight' => 1], ['item' => 83, 'response' => 'V', 'weight' => 1], ['item' => 126, 'response' => 'V', 'weight' => 1]],
            'Consumo de drogas' => [['item' => 36, 'response' => 'V', 'weight' => 2], ['item' => 61, 'response' => 'V', 'weight' => 2], ['item' => 81, 'response' => 'V', 'weight' => 2], ['item' => 105, 'response' => 'V', 'weight' => 2], ['item' => 116, 'response' => 'V', 'weight' => 2], ['item' => 124, 'response' => 'V', 'weight' => 2], ['item' => 144, 'response' => 'V', 'weight' => 2], ['item' => 11, 'response' => 'V', 'weight' => 1], ['item' => 65, 'response' => 'V', 'weight' => 1], ['item' => 152, 'response' => 'V', 'weight' => 1], ['item' => 158, 'response' => 'F', 'weight' => 1]],
            'Estrés postraumático' => [['item' => 62, 'response' => 'V', 'weight' => 2], ['item' => 76, 'response' => 'V', 'weight' => 2], ['item' => 91, 'response' => 'V', 'weight' => 2], ['item' => 125, 'response' => 'V', 'weight' => 2], ['item' => 150, 'response' => 'V', 'weight' => 2], ['item' => 44, 'response' => 'V', 'weight' => 1], ['item' => 47, 'response' => 'V', 'weight' => 1], ['item' => 57, 'response' => 'V', 'weight' => 1], ['item' => 74, 'response' => 'V', 'weight' => 1], ['item' => 89, 'response' => 'V', 'weight' => 1], ['item' => 110, 'response' => 'V', 'weight' => 1], ['item' => 113, 'response' => 'V', 'weight' => 1], ['item' => 143, 'response' => 'V', 'weight' => 1], ['item' => 157, 'response' => 'V', 'weight' => 1]],
            'Espectro esquizofrénico' => [['item' => 33, 'response' => 'V', 'weight' => 2], ['item' => 58, 'response' => 'V', 'weight' => 2], ['item' => 80, 'response' => 'V', 'weight' => 2], ['item' => 121, 'response' => 'V', 'weight' => 2], ['item' => 131, 'response' => 'V', 'weight' => 2], ['item' => 138, 'response' => 'V', 'weight' => 2], ['item' => 18, 'response' => 'V', 'weight' => 1], ['item' => 24, 'response' => 'V', 'weight' => 1], ['item' => 52, 'response' => 'V', 'weight' => 1], ['item' => 82, 'response' => 'V', 'weight' => 1], ['item' => 89, 'response' => 'V', 'weight' => 1], ['item' => 92, 'response' => 'V', 'weight' => 1], ['item' => 95, 'response' => 'V', 'weight' => 1], ['item' => 104, 'response' => 'V', 'weight' => 1], ['item' => 123, 'response' => 'V', 'weight' => 1], ['item' => 136, 'response' => 'V', 'weight' => 1], ['item' => 148, 'response' => 'V', 'weight' => 1], ['item' => 156, 'response' => 'V', 'weight' => 1], ['item' => 165, 'response' => 'V', 'weight' => 1], ['item' => 172, 'response' => 'V', 'weight' => 1], ['item' => 182, 'response' => 'V', 'weight' => 1]],
            'Depresión mayor' => [['item' => 1, 'response' => 'V', 'weight' => 2], ['item' => 22, 'response' => 'V', 'weight' => 2], ['item' => 57, 'response' => 'V', 'weight' => 2], ['item' => 78, 'response' => 'V', 'weight' => 2], ['item' => 101, 'response' => 'V', 'weight' => 2], ['item' => 107, 'response' => 'V', 'weight' => 2], ['item' => 114, 'response' => 'V', 'weight' => 2], ['item' => 28, 'response' => 'V', 'weight' => 1], ['item' => 41, 'response' => 'V', 'weight' => 1], ['item' => 59, 'response' => 'V', 'weight' => 1], ['item' => 64, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 80, 'response' => 'V', 'weight' => 1], ['item' => 111, 'response' => 'V', 'weight' => 1], ['item' => 118, 'response' => 'V', 'weight' => 1], ['item' => 120, 'response' => 'V', 'weight' => 1], ['item' => 170, 'response' => 'V', 'weight' => 1]],
            'Delirante' => [['item' => 68, 'response' => 'V', 'weight' => 2], ['item' => 95, 'response' => 'V', 'weight' => 2], ['item' => 127, 'response' => 'V', 'weight' => 2], ['item' => 148, 'response' => 'V', 'weight' => 2], ['item' => 182, 'response' => 'V', 'weight' => 2], ['item' => 13, 'response' => 'V', 'weight' => 1], ['item' => 54, 'response' => 'V', 'weight' => 1], ['item' => 79, 'response' => 'V', 'weight' => 1], ['item' => 88, 'response' => 'V', 'weight' => 1], ['item' => 112, 'response' => 'V', 'weight' => 1], ['item' => 121, 'response' => 'V', 'weight' => 1], ['item' => 136, 'response' => 'V', 'weight' => 1], ['item' => 172, 'response' => 'V', 'weight' => 1], ['item' => 189, 'response' => 'V', 'weight' => 1]],
            'Sinceridad' => [['item' => 2, 'response' => 'V', 'weight' => 1], ['item' => 4, 'response' => 'V', 'weight' => 1], ['item' => 5, 'response' => 'V', 'weight' => 1], ['item' => 6, 'response' => 'V', 'weight' => 1], ['item' => 8, 'response' => 'V', 'weight' => 1], ['item' => 9, 'response' => 'V', 'weight' => 1], ['item' => 10, 'response' => 'V', 'weight' => 1], ['item' => 11, 'response' => 'V', 'weight' => 1], ['item' => 12, 'response' => 'V', 'weight' => 1], ['item' => 15, 'response' => 'V', 'weight' => 1], ['item' => 16, 'response' => 'V', 'weight' => 1], ['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 19, 'response' => 'V', 'weight' => 1], ['item' => 20, 'response' => 'V', 'weight' => 1], ['item' => 21, 'response' => 'V', 'weight' => 1], ['item' => 22, 'response' => 'V', 'weight' => 1], ['item' => 23, 'response' => 'V', 'weight' => 1], ['item' => 24, 'response' => 'V', 'weight' => 1], ['item' => 26, 'response' => 'V', 'weight' => 1], ['item' => 29, 'response' => 'V', 'weight' => 1], ['item' => 30, 'response' => 'V', 'weight' => 1], ['item' => 32, 'response' => 'V', 'weight' => 1], ['item' => 35, 'response' => 'V', 'weight' => 1], ['item' => 36, 'response' => 'V', 'weight' => 1], ['item' => 37, 'response' => 'V', 'weight' => 1], ['item' => 38, 'response' => 'V', 'weight' => 1], ['item' => 39, 'response' => 'V', 'weight' => 1], ['item' => 42, 'response' => 'V', 'weight' => 1], ['item' => 43, 'response' => 'V', 'weight' => 1], ['item' => 46, 'response' => 'V', 'weight' => 1], ['item' => 48, 'response' => 'V', 'weight' => 1], ['item' => 50, 'response' => 'V', 'weight' => 1], ['item' => 51, 'response' => 'V', 'weight' => 1], ['item' => 52, 'response' => 'V', 'weight' => 1], ['item' => 53, 'response' => 'V', 'weight' => 1], ['item' => 54, 'response' => 'V', 'weight' => 1], ['item' => 59, 'response' => 'V', 'weight' => 1], ['item' => 60, 'response' => 'V', 'weight' => 1], ['item' => 63, 'response' => 'V', 'weight' => 1], ['item' => 65, 'response' => 'V', 'weight' => 1], ['item' => 66, 'response' => 'V', 'weight' => 1], ['item' => 67, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 71, 'response' => 'V', 'weight' => 1], ['item' => 72, 'response' => 'V', 'weight' => 1], ['item' => 73, 'response' => 'V', 'weight' => 1], ['item' => 74, 'response' => 'V', 'weight' => 1], ['item' => 75, 'response' => 'V', 'weight' => 1], ['item' => 77, 'response' => 'V', 'weight' => 1], ['item' => 79, 'response' => 'V', 'weight' => 1], ['item' => 82, 'response' => 'V', 'weight' => 1], ['item' => 83, 'response' => 'V', 'weight' => 1], ['item' => 84, 'response' => 'V', 'weight' => 1], ['item' => 85, 'response' => 'V', 'weight' => 1], ['item' => 87, 'response' => 'V', 'weight' => 1], ['item' => 88, 'response' => 'V', 'weight' => 1], ['item' => 90, 'response' => 'V', 'weight' => 1], ['item' => 92, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 96, 'response' => 'V', 'weight' => 1], ['item' => 97, 'response' => 'V', 'weight' => 1], ['item' => 99, 'response' => 'V', 'weight' => 1], ['item' => 100, 'response' => 'V', 'weight' => 1], ['item' => 103, 'response' => 'V', 'weight' => 1], ['item' => 105, 'response' => 'V', 'weight' => 1], ['item' => 106, 'response' => 'V', 'weight' => 1], ['item' => 109, 'response' => 'V', 'weight' => 1], ['item' => 111, 'response' => 'V', 'weight' => 1], ['item' => 112, 'response' => 'V', 'weight' => 1], ['item' => 115, 'response' => 'V', 'weight' => 1], ['item' => 117, 'response' => 'V', 'weight' => 1], ['item' => 119, 'response' => 'V', 'weight' => 1], ['item' => 120, 'response' => 'V', 'weight' => 1], ['item' => 122, 'response' => 'V', 'weight' => 1], ['item' => 126, 'response' => 'V', 'weight' => 1], ['item' => 128, 'response' => 'V', 'weight' => 1], ['item' => 129, 'response' => 'V', 'weight' => 1], ['item' => 132, 'response' => 'V', 'weight' => 1], ['item' => 133, 'response' => 'V', 'weight' => 1], ['item' => 135, 'response' => 'V', 'weight' => 1], ['item' => 137, 'response' => 'V', 'weight' => 1], ['item' => 139, 'response' => 'V', 'weight' => 1], ['item' => 140, 'response' => 'V', 'weight' => 1], ['item' => 141, 'response' => 'V', 'weight' => 1], ['item' => 142, 'response' => 'V', 'weight' => 1], ['item' => 145, 'response' => 'V', 'weight' => 1], ['item' => 147, 'response' => 'V', 'weight' => 1], ['item' => 149, 'response' => 'V', 'weight' => 1], ['item' => 152, 'response' => 'V', 'weight' => 1], ['item' => 154, 'response' => 'V', 'weight' => 1], ['item' => 155, 'response' => 'V', 'weight' => 1], ['item' => 156, 'response' => 'V', 'weight' => 1], ['item' => 158, 'response' => 'V', 'weight' => 1], ['item' => 159, 'response' => 'V', 'weight' => 1], ['item' => 162, 'response' => 'V', 'weight' => 1], ['item' => 164, 'response' => 'V', 'weight' => 1], ['item' => 166, 'response' => 'V', 'weight' => 1], ['item' => 167, 'response' => 'V', 'weight' => 1], ['item' => 168, 'response' => 'V', 'weight' => 1], ['item' => 169, 'response' => 'V', 'weight' => 1], ['item' => 170, 'response' => 'V', 'weight' => 1], ['item' => 171, 'response' => 'V', 'weight' => 1], ['item' => 172, 'response' => 'V', 'weight' => 1], ['item' => 173, 'response' => 'V', 'weight' => 1], ['item' => 174, 'response' => 'V', 'weight' => 1], ['item' => 175, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1], ['item' => 179, 'response' => 'V', 'weight' => 1], ['item' => 180, 'response' => 'V', 'weight' => 1], ['item' => 183, 'response' => 'V', 'weight' => 1], ['item' => 184, 'response' => 'V', 'weight' => 1], ['item' => 185, 'response' => 'V', 'weight' => 1], ['item' => 187, 'response' => 'V', 'weight' => 1], ['item' => 188, 'response' => 'V', 'weight' => 1], ['item' => 189, 'response' => 'V', 'weight' => 1], ['item' => 190, 'response' => 'V', 'weight' => 1], ['item' => 191, 'response' => 'V', 'weight' => 1], ['item' => 192, 'response' => 'V', 'weight' => 1], ['item' => 193, 'response' => 'V', 'weight' => 1], ['item' => 194, 'response' => 'V', 'weight' => 1], ['item' => 195, 'response' => 'V', 'weight' => 1]],
            'Deseabilidad social' => [['item' => 2, 'response' => 'V', 'weight' => 1], ['item' => 3, 'response' => 'V', 'weight' => 1], ['item' => 8, 'response' => 'V', 'weight' => 1], ['item' => 20, 'response' => 'V', 'weight' => 1], ['item' => 30, 'response' => 'V', 'weight' => 1], ['item' => 46, 'response' => 'V', 'weight' => 1], ['item' => 67, 'response' => 'V', 'weight' => 1], ['item' => 73, 'response' => 'V', 'weight' => 1], ['item' => 75, 'response' => 'V', 'weight' => 1], ['item' => 84, 'response' => 'V', 'weight' => 1], ['item' => 154, 'response' => 'V', 'weight' => 1], ['item' => 155, 'response' => 'V', 'weight' => 1], ['item' => 158, 'response' => 'V', 'weight' => 1], ['item' => 173, 'response' => 'V', 'weight' => 1], ['item' => 174, 'response' => 'V', 'weight' => 1], ['item' => 185, 'response' => 'V', 'weight' => 1], ['item' => 188, 'response' => 'V', 'weight' => 1], ['item' => 65, 'response' => 'F', 'weight' => 1], ['item' => 71, 'response' => 'F', 'weight' => 1], ['item' => 90, 'response' => 'F', 'weight' => 1], ['item' => 99, 'response' => 'F', 'weight' => 1], ['item' => 159, 'response' => 'F', 'weight' => 1], ['item' => 162, 'response' => 'F', 'weight' => 1], ['item' => 187, 'response' => 'F', 'weight' => 1]],
            'Devaluación' => [['item' => 1, 'response' => 'V', 'weight' => 1], ['item' => 14, 'response' => 'V', 'weight' => 1], ['item' => 16, 'response' => 'V', 'weight' => 1], ['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 18, 'response' => 'V', 'weight' => 1], ['item' => 22, 'response' => 'V', 'weight' => 1], ['item' => 28, 'response' => 'V', 'weight' => 1], ['item' => 31, 'response' => 'V', 'weight' => 1], ['item' => 32, 'response' => 'V', 'weight' => 1], ['item' => 34, 'response' => 'V', 'weight' => 1], ['item' => 37, 'response' => 'V', 'weight' => 1], ['item' => 39, 'response' => 'V', 'weight' => 1], ['item' => 41, 'response' => 'V', 'weight' => 1], ['item' => 44, 'response' => 'V', 'weight' => 1], ['item' => 51, 'response' => 'V', 'weight' => 1], ['item' => 64, 'response' => 'V', 'weight' => 1], ['item' => 74, 'response' => 'V', 'weight' => 1], ['item' => 78, 'response' => 'V', 'weight' => 1], ['item' => 80, 'response' => 'V', 'weight' => 1], ['item' => 101, 'response' => 'V', 'weight' => 1], ['item' => 107, 'response' => 'V', 'weight' => 1], ['item' => 109, 'response' => 'V', 'weight' => 1], ['item' => 112, 'response' => 'V', 'weight' => 1], ['item' => 113, 'response' => 'V', 'weight' => 1], ['item' => 120, 'response' => 'V', 'weight' => 1], ['item' => 151, 'response' => 'V', 'weight' => 1], ['item' => 164, 'response' => 'V', 'weight' => 1], ['item' => 170, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1], ['item' => 193, 'response' => 'V', 'weight' => 1]],
            'INVALIDEZ' => [['item' => 49, 'response' => 'V', 'weight' => 1], ['item' => 98, 'response' => 'V', 'weight' => 1], ['item' => 160, 'response' => 'V', 'weight' => 1]],
            'INCONSISTENCIA' => [[22, 170], [125, 143], [47, 157], [40, 181], [81, 116], [85, 126], [76, 150], [25, 94], [44, 121], [39, 59], [17, 184], [33, 89], [78, 164], [38, 171], [74, 115], [46, 154], [26, 99], [20, 174], [32, 122], [13, 112], [55, 110], [194, 173], [95, 127], [60, 162], [15, 149]],
            '1.1' => [['item' => 12, 'response' => 'V', 'weight' => 1], ['item' => 15, 'response' => 'V', 'weight' => 1], ['item' => 24, 'response' => 'V', 'weight' => 1], ['item' => 104, 'response' => 'V', 'weight' => 1], ['item' => 149, 'response' => 'V', 'weight' => 1], ['item' => 180, 'response' => 'V', 'weight' => 1], ['item' => 190, 'response' => 'V', 'weight' => 1], ['item' => 154, 'response' => 'F', 'weight' => 1], ['item' => 185, 'response' => 'F', 'weight' => 1]],
            '1.2' => [['item' => 26, 'response' => 'V', 'weight' => 1], ['item' => 99, 'response' => 'V', 'weight' => 1], ['item' => 139, 'response' => 'V', 'weight' => 1], ['item' => 175, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1], ['item' => 195, 'response' => 'V', 'weight' => 1], ['item' => 30, 'response' => 'F', 'weight' => 1], ['item' => 46, 'response' => 'F', 'weight' => 1], ['item' => 67, 'response' => 'F', 'weight' => 1]],
            '1.3' => [['item' => 6, 'response' => 'V', 'weight' => 1], ['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 43, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 90, 'response' => 'V', 'weight' => 1], ['item' => 92, 'response' => 'V', 'weight' => 1], ['item' => 111, 'response' => 'V', 'weight' => 1], ['item' => 118, 'response' => 'V', 'weight' => 1], ['item' => 119, 'response' => 'V', 'weight' => 1]],
            '2A.1' => [['item' => 15, 'response' => 'V', 'weight' => 1], ['item' => 26, 'response' => 'V', 'weight' => 1], ['item' => 99, 'response' => 'V', 'weight' => 1], ['item' => 139, 'response' => 'V', 'weight' => 1], ['item' => 30, 'response' => 'F', 'weight' => 1], ['item' => 46, 'response' => 'F', 'weight' => 1], ['item' => 84, 'response' => 'F', 'weight' => 1], ['item' => 154, 'response' => 'F', 'weight' => 1]],
            '2A.2' => [['item' => 23, 'response' => 'V', 'weight' => 1], ['item' => 58, 'response' => 'V', 'weight' => 1], ['item' => 111, 'response' => 'V', 'weight' => 1], ['item' => 135, 'response' => 'V', 'weight' => 1], ['item' => 156, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1], ['item' => 192, 'response' => 'V', 'weight' => 1], ['item' => 193, 'response' => 'V', 'weight' => 1], ['item' => 67, 'response' => 'F', 'weight' => 1]],
            '2A.3' => [['item' => 5, 'response' => 'V', 'weight' => 1], ['item' => 12, 'response' => 'V', 'weight' => 1], ['item' => 24, 'response' => 'V', 'weight' => 1], ['item' => 52, 'response' => 'V', 'weight' => 1], ['item' => 92, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 112, 'response' => 'V', 'weight' => 1], ['item' => 184, 'response' => 'V', 'weight' => 1], ['item' => 195, 'response' => 'V', 'weight' => 1]],
            '2B.1' => [['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 23, 'response' => 'V', 'weight' => 1], ['item' => 33, 'response' => 'V', 'weight' => 1], ['item' => 51, 'response' => 'V', 'weight' => 1], ['item' => 52, 'response' => 'V', 'weight' => 1], ['item' => 71, 'response' => 'V', 'weight' => 1], ['item' => 89, 'response' => 'V', 'weight' => 1], ['item' => 126, 'response' => 'V', 'weight' => 1], ['item' => 184, 'response' => 'V', 'weight' => 1]],
            '2B.2' => [['item' => 39, 'response' => 'V', 'weight' => 1], ['item' => 59, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 112, 'response' => 'V', 'weight' => 1], ['item' => 169, 'response' => 'V', 'weight' => 1], ['item' => 175, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1], ['item' => 192, 'response' => 'V', 'weight' => 1], ['item' => 195, 'response' => 'V', 'weight' => 1]],
            '2B.3' => [['item' => 22, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 90, 'response' => 'V', 'weight' => 1], ['item' => 101, 'response' => 'V', 'weight' => 1], ['item' => 107, 'response' => 'V', 'weight' => 1], ['item' => 111, 'response' => 'V', 'weight' => 1], ['item' => 170, 'response' => 'V', 'weight' => 1], ['item' => 193, 'response' => 'V', 'weight' => 1], ['item' => 53, 'response' => 'F', 'weight' => 1]],
            '3.1' => [['item' => 4, 'response' => 'V', 'weight' => 1], ['item' => 5, 'response' => 'V', 'weight' => 1], ['item' => 23, 'response' => 'V', 'weight' => 1], ['item' => 51, 'response' => 'V', 'weight' => 1], ['item' => 72, 'response' => 'V', 'weight' => 1], ['item' => 99, 'response' => 'V', 'weight' => 1], ['item' => 109, 'response' => 'V', 'weight' => 1], ['item' => 135, 'response' => 'V', 'weight' => 1], ['item' => 184, 'response' => 'V', 'weight' => 1]],
            '3.2' => [['item' => 26, 'response' => 'V', 'weight' => 1], ['item' => 60, 'response' => 'V', 'weight' => 1], ['item' => 162, 'response' => 'V', 'weight' => 1], ['item' => 169, 'response' => 'V', 'weight' => 1], ['item' => 173, 'response' => 'V', 'weight' => 1], ['item' => 194, 'response' => 'V', 'weight' => 1], ['item' => 185, 'response' => 'F', 'weight' => 1]],
            '3.3' => [['item' => 42, 'response' => 'V', 'weight' => 1], ['item' => 77, 'response' => 'V', 'weight' => 1], ['item' => 85, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 133, 'response' => 'V', 'weight' => 1], ['item' => 151, 'response' => 'V', 'weight' => 1], ['item' => 175, 'response' => 'V', 'weight' => 1], ['item' => 53, 'response' => 'F', 'weight' => 1], ['item' => 67, 'response' => 'F', 'weight' => 1]],
            '4A.1' => [['item' => 10, 'response' => 'V', 'weight' => 1], ['item' => 38, 'response' => 'V', 'weight' => 1], ['item' => 83, 'response' => 'V', 'weight' => 1], ['item' => 117, 'response' => 'V', 'weight' => 1], ['item' => 132, 'response' => 'V', 'weight' => 1], ['item' => 142, 'response' => 'V', 'weight' => 1], ['item' => 171, 'response' => 'V', 'weight' => 1]],
            '4A.2' => [['item' => 30, 'response' => 'V', 'weight' => 1], ['item' => 46, 'response' => 'V', 'weight' => 1], ['item' => 84, 'response' => 'V', 'weight' => 1], ['item' => 154, 'response' => 'V', 'weight' => 1], ['item' => 6, 'response' => 'F', 'weight' => 1], ['item' => 15, 'response' => 'F', 'weight' => 1], ['item' => 24, 'response' => 'F', 'weight' => 1], ['item' => 26, 'response' => 'F', 'weight' => 1], ['item' => 139, 'response' => 'F', 'weight' => 1], ['item' => 195, 'response' => 'F', 'weight' => 1]],
            '4A.3' => [['item' => 8, 'response' => 'V', 'weight' => 1], ['item' => 20, 'response' => 'V', 'weight' => 1], ['item' => 27, 'response' => 'V', 'weight' => 1], ['item' => 53, 'response' => 'V', 'weight' => 1], ['item' => 67, 'response' => 'V', 'weight' => 1], ['item' => 75, 'response' => 'V', 'weight' => 1], ['item' => 155, 'response' => 'V', 'weight' => 1], ['item' => 174, 'response' => 'V', 'weight' => 1], ['item' => 185, 'response' => 'V', 'weight' => 1], ['item' => 135, 'response' => 'F', 'weight' => 1], ['item' => 170, 'response' => 'F', 'weight' => 1], ['item' => 178, 'response' => 'F', 'weight' => 1]],
            '4B.1' => [['item' => 8, 'response' => 'V', 'weight' => 1], ['item' => 20, 'response' => 'V', 'weight' => 1], ['item' => 53, 'response' => 'V', 'weight' => 1], ['item' => 75, 'response' => 'V', 'weight' => 1], ['item' => 129, 'response' => 'V', 'weight' => 1], ['item' => 155, 'response' => 'V', 'weight' => 1], ['item' => 174, 'response' => 'V', 'weight' => 1], ['item' => 185, 'response' => 'V', 'weight' => 1]],
            '4B.2' => [['item' => 10, 'response' => 'V', 'weight' => 1], ['item' => 30, 'response' => 'V', 'weight' => 1], ['item' => 46, 'response' => 'V', 'weight' => 1], ['item' => 84, 'response' => 'V', 'weight' => 1], ['item' => 117, 'response' => 'V', 'weight' => 1], ['item' => 154, 'response' => 'V', 'weight' => 1], ['item' => 5, 'response' => 'F', 'weight' => 1], ['item' => 26, 'response' => 'F', 'weight' => 1], ['item' => 149, 'response' => 'F', 'weight' => 1]],
            '4B.3' => [['item' => 67, 'response' => 'V', 'weight' => 1], ['item' => 142, 'response' => 'V', 'weight' => 1], ['item' => 14, 'response' => 'F', 'weight' => 1], ['item' => 93, 'response' => 'F', 'weight' => 1], ['item' => 120, 'response' => 'F', 'weight' => 1], ['item' => 156, 'response' => 'F', 'weight' => 1], ['item' => 175, 'response' => 'F', 'weight' => 1], ['item' => 178, 'response' => 'F', 'weight' => 1]],
            '5.1' => [['item' => 10, 'response' => 'V', 'weight' => 1], ['item' => 19, 'response' => 'V', 'weight' => 1], ['item' => 38, 'response' => 'V', 'weight' => 1], ['item' => 83, 'response' => 'V', 'weight' => 1], ['item' => 117, 'response' => 'V', 'weight' => 1], ['item' => 132, 'response' => 'V', 'weight' => 1], ['item' => 159, 'response' => 'V', 'weight' => 1], ['item' => 171, 'response' => 'V', 'weight' => 1], ['item' => 183, 'response' => 'V', 'weight' => 1]],
            '5.2' => [['item' => 8, 'response' => 'V', 'weight' => 1], ['item' => 67, 'response' => 'V', 'weight' => 1], ['item' => 75, 'response' => 'V', 'weight' => 1], ['item' => 142, 'response' => 'V', 'weight' => 1], ['item' => 154, 'response' => 'V', 'weight' => 1], ['item' => 155, 'response' => 'V', 'weight' => 1], ['item' => 174, 'response' => 'V', 'weight' => 1], ['item' => 185, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'F', 'weight' => 1], ['item' => 178, 'response' => 'F', 'weight' => 1]],
            '5.3' => [['item' => 29, 'response' => 'V', 'weight' => 1], ['item' => 54, 'response' => 'V', 'weight' => 1], ['item' => 79, 'response' => 'V', 'weight' => 1], ['item' => 87, 'response' => 'V', 'weight' => 1], ['item' => 106, 'response' => 'V', 'weight' => 1], ['item' => 180, 'response' => 'V', 'weight' => 1], ['item' => 189, 'response' => 'V', 'weight' => 1], ['item' => 191, 'response' => 'V', 'weight' => 1]],
            '6A.1' => [['item' => 10, 'response' => 'V', 'weight' => 1], ['item' => 38, 'response' => 'V', 'weight' => 1], ['item' => 83, 'response' => 'V', 'weight' => 1], ['item' => 103, 'response' => 'V', 'weight' => 1], ['item' => 159, 'response' => 'V', 'weight' => 1], ['item' => 171, 'response' => 'V', 'weight' => 1], ['item' => 183, 'response' => 'V', 'weight' => 1], ['item' => 188, 'response' => 'F', 'weight' => 1]],
            '6A.2' => [['item' => 11, 'response' => 'V', 'weight' => 1], ['item' => 19, 'response' => 'V', 'weight' => 1], ['item' => 147, 'response' => 'V', 'weight' => 1], ['item' => 152, 'response' => 'V', 'weight' => 1], ['item' => 153, 'response' => 'V', 'weight' => 1], ['item' => 168, 'response' => 'V', 'weight' => 1], ['item' => 191, 'response' => 'V', 'weight' => 1], ['item' => 48, 'response' => 'F', 'weight' => 1], ['item' => 73, 'response' => 'F', 'weight' => 1], ['item' => 158, 'response' => 'F', 'weight' => 1]],
            '6A.3' => [['item' => 25, 'response' => 'V', 'weight' => 1], ['item' => 36, 'response' => 'V', 'weight' => 1], ['item' => 61, 'response' => 'V', 'weight' => 1], ['item' => 65, 'response' => 'V', 'weight' => 1], ['item' => 85, 'response' => 'V', 'weight' => 1], ['item' => 105, 'response' => 'V', 'weight' => 1], ['item' => 126, 'response' => 'V', 'weight' => 1], ['item' => 130, 'response' => 'V', 'weight' => 1], ['item' => 144, 'response' => 'V', 'weight' => 1], ['item' => 63, 'response' => 'F', 'weight' => 1]],
            '6B.1' => [['item' => 9, 'response' => 'V', 'weight' => 1], ['item' => 11, 'response' => 'V', 'weight' => 1], ['item' => 65, 'response' => 'V', 'weight' => 1], ['item' => 66, 'response' => 'V', 'weight' => 1], ['item' => 88, 'response' => 'V', 'weight' => 1], ['item' => 103, 'response' => 'V', 'weight' => 1], ['item' => 152, 'response' => 'V', 'weight' => 1], ['item' => 153, 'response' => 'V', 'weight' => 1], ['item' => 159, 'response' => 'V', 'weight' => 1], ['item' => 172, 'response' => 'V', 'weight' => 1], ['item' => 191, 'response' => 'V', 'weight' => 1]],
            '6B.2' => [['item' => 19, 'response' => 'V', 'weight' => 1], ['item' => 21, 'response' => 'V', 'weight' => 1], ['item' => 50, 'response' => 'V', 'weight' => 1], ['item' => 97, 'response' => 'V', 'weight' => 1], ['item' => 141, 'response' => 'V', 'weight' => 1], ['item' => 166, 'response' => 'V', 'weight' => 1], ['item' => 187, 'response' => 'V', 'weight' => 1]],
            '6B.3' => [['item' => 16, 'response' => 'V', 'weight' => 1], ['item' => 37, 'response' => 'V', 'weight' => 1], ['item' => 74, 'response' => 'V', 'weight' => 1], ['item' => 115, 'response' => 'V', 'weight' => 1], ['item' => 137, 'response' => 'V', 'weight' => 1], ['item' => 145, 'response' => 'V', 'weight' => 1], ['item' => 168, 'response' => 'V', 'weight' => 1]],
            '7.1' => [['item' => 2, 'response' => 'V', 'weight' => 1], ['item' => 20, 'response' => 'V', 'weight' => 1], ['item' => 35, 'response' => 'V', 'weight' => 1], ['item' => 63, 'response' => 'V', 'weight' => 1], ['item' => 174, 'response' => 'V', 'weight' => 1], ['item' => 188, 'response' => 'V', 'weight' => 1], ['item' => 85, 'response' => 'F', 'weight' => 1], ['item' => 118, 'response' => 'F', 'weight' => 1]],
            '7.2' => [['item' => 23, 'response' => 'V', 'weight' => 1], ['item' => 44, 'response' => 'V', 'weight' => 1], ['item' => 51, 'response' => 'V', 'weight' => 1], ['item' => 52, 'response' => 'V', 'weight' => 1], ['item' => 99, 'response' => 'V', 'weight' => 1], ['item' => 128, 'response' => 'V', 'weight' => 1], ['item' => 131, 'response' => 'V', 'weight' => 1], ['item' => 135, 'response' => 'V', 'weight' => 1], ['item' => 137, 'response' => 'V', 'weight' => 1], ['item' => 140, 'response' => 'V', 'weight' => 1], ['item' => 169, 'response' => 'V', 'weight' => 1], ['item' => 179, 'response' => 'V', 'weight' => 1]],
            '7.3' => [['item' => 48, 'response' => 'V', 'weight' => 1], ['item' => 73, 'response' => 'V', 'weight' => 1], ['item' => 158, 'response' => 'V', 'weight' => 1], ['item' => 19, 'response' => 'F', 'weight' => 1], ['item' => 83, 'response' => 'F', 'weight' => 1], ['item' => 147, 'response' => 'F', 'weight' => 1], ['item' => 152, 'response' => 'F', 'weight' => 1], ['item' => 183, 'response' => 'F', 'weight' => 1], ['item' => 191, 'response' => 'F', 'weight' => 1]],
            '8A.1' => [['item' => 21, 'response' => 'V', 'weight' => 1], ['item' => 32, 'response' => 'V', 'weight' => 1], ['item' => 79, 'response' => 'V', 'weight' => 1], ['item' => 88, 'response' => 'V', 'weight' => 1], ['item' => 96, 'response' => 'V', 'weight' => 1], ['item' => 100, 'response' => 'V', 'weight' => 1], ['item' => 122, 'response' => 'V', 'weight' => 1], ['item' => 167, 'response' => 'V', 'weight' => 1], ['item' => 172, 'response' => 'V', 'weight' => 1]],
            '8A.2' => [['item' => 12, 'response' => 'V', 'weight' => 1], ['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 24, 'response' => 'V', 'weight' => 1], ['item' => 34, 'response' => 'V', 'weight' => 1], ['item' => 39, 'response' => 'V', 'weight' => 1], ['item' => 51, 'response' => 'V', 'weight' => 1], ['item' => 52, 'response' => 'V', 'weight' => 1], ['item' => 59, 'response' => 'V', 'weight' => 1], ['item' => 153, 'response' => 'V', 'weight' => 1], ['item' => 184, 'response' => 'V', 'weight' => 1], ['item' => 75, 'response' => 'F', 'weight' => 1]],
            '8A.3' => [['item' => 9, 'response' => 'V', 'weight' => 1], ['item' => 37, 'response' => 'V', 'weight' => 1], ['item' => 74, 'response' => 'V', 'weight' => 1], ['item' => 82, 'response' => 'V', 'weight' => 1], ['item' => 97, 'response' => 'V', 'weight' => 1], ['item' => 115, 'response' => 'V', 'weight' => 1], ['item' => 137, 'response' => 'V', 'weight' => 1], ['item' => 145, 'response' => 'V', 'weight' => 1], ['item' => 168, 'response' => 'V', 'weight' => 1], ['item' => 187, 'response' => 'V', 'weight' => 1]],
            '8B.1' => [['item' => 4, 'response' => 'V', 'weight' => 1], ['item' => 12, 'response' => 'V', 'weight' => 1], ['item' => 23, 'response' => 'V', 'weight' => 1], ['item' => 39, 'response' => 'V', 'weight' => 1], ['item' => 52, 'response' => 'V', 'weight' => 1], ['item' => 59, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 164, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1], ['item' => 192, 'response' => 'V', 'weight' => 1], ['item' => 195, 'response' => 'V', 'weight' => 1]],
            '8B.2' => [['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 40, 'response' => 'V', 'weight' => 1], ['item' => 85, 'response' => 'V', 'weight' => 1], ['item' => 100, 'response' => 'V', 'weight' => 1], ['item' => 126, 'response' => 'V', 'weight' => 1], ['item' => 156, 'response' => 'V', 'weight' => 1], ['item' => 166, 'response' => 'V', 'weight' => 1], ['item' => 167, 'response' => 'V', 'weight' => 1], ['item' => 184, 'response' => 'V', 'weight' => 1]],
            '8B.3' => [['item' => 92, 'response' => 'V', 'weight' => 1], ['item' => 107, 'response' => 'V', 'weight' => 1], ['item' => 170, 'response' => 'V', 'weight' => 1], ['item' => 20, 'response' => 'F', 'weight' => 1], ['item' => 53, 'response' => 'F', 'weight' => 1], ['item' => 67, 'response' => 'F', 'weight' => 1], ['item' => 75, 'response' => 'F', 'weight' => 1], ['item' => 154, 'response' => 'F', 'weight' => 1], ['item' => 155, 'response' => 'F', 'weight' => 1]],
            'S.1' => [['item' => 18, 'response' => 'V', 'weight' => 1], ['item' => 33, 'response' => 'V', 'weight' => 1], ['item' => 44, 'response' => 'V', 'weight' => 1], ['item' => 89, 'response' => 'V', 'weight' => 1], ['item' => 92, 'response' => 'V', 'weight' => 1], ['item' => 121, 'response' => 'V', 'weight' => 1], ['item' => 123, 'response' => 'V', 'weight' => 1], ['item' => 131, 'response' => 'V', 'weight' => 1], ['item' => 163, 'response' => 'V', 'weight' => 1]],
            'S.2' => [['item' => 5, 'response' => 'V', 'weight' => 1], ['item' => 58, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 90, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 111, 'response' => 'V', 'weight' => 1], ['item' => 126, 'response' => 'V', 'weight' => 1], ['item' => 156, 'response' => 'V', 'weight' => 1], ['item' => 165, 'response' => 'V', 'weight' => 1], ['item' => 195, 'response' => 'V', 'weight' => 1], ['item' => 154, 'response' => 'F', 'weight' => 1]],
            'S.3' => [['item' => 13, 'response' => 'V', 'weight' => 1], ['item' => 24, 'response' => 'V', 'weight' => 1], ['item' => 68, 'response' => 'V', 'weight' => 1], ['item' => 79, 'response' => 'V', 'weight' => 1], ['item' => 88, 'response' => 'V', 'weight' => 1], ['item' => 106, 'response' => 'V', 'weight' => 1], ['item' => 112, 'response' => 'V', 'weight' => 1], ['item' => 148, 'response' => 'V', 'weight' => 1], ['item' => 167, 'response' => 'V', 'weight' => 1], ['item' => 172, 'response' => 'V', 'weight' => 1], ['item' => 190, 'response' => 'V', 'weight' => 1]],
            'C.1' => [['item' => 14, 'response' => 'V', 'weight' => 1], ['item' => 70, 'response' => 'V', 'weight' => 1], ['item' => 101, 'response' => 'V', 'weight' => 1], ['item' => 111, 'response' => 'V', 'weight' => 1], ['item' => 151, 'response' => 'V', 'weight' => 1], ['item' => 156, 'response' => 'V', 'weight' => 1], ['item' => 170, 'response' => 'V', 'weight' => 1], ['item' => 178, 'response' => 'V', 'weight' => 1]],
            'C.2' => [['item' => 4, 'response' => 'V', 'weight' => 1], ['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 39, 'response' => 'V', 'weight' => 1], ['item' => 59, 'response' => 'V', 'weight' => 1], ['item' => 93, 'response' => 'V', 'weight' => 1], ['item' => 100, 'response' => 'V', 'weight' => 1], ['item' => 126, 'response' => 'V', 'weight' => 1], ['item' => 134, 'response' => 'V', 'weight' => 1], ['item' => 166, 'response' => 'V', 'weight' => 1], ['item' => 192, 'response' => 'V', 'weight' => 1], ['item' => 193, 'response' => 'V', 'weight' => 1]],
            'C.3' => [['item' => 16, 'response' => 'V', 'weight' => 1], ['item' => 18, 'response' => 'V', 'weight' => 1], ['item' => 37, 'response' => 'V', 'weight' => 1], ['item' => 74, 'response' => 'V', 'weight' => 1], ['item' => 80, 'response' => 'V', 'weight' => 1], ['item' => 82, 'response' => 'V', 'weight' => 1], ['item' => 115, 'response' => 'V', 'weight' => 1], ['item' => 137, 'response' => 'V', 'weight' => 1], ['item' => 164, 'response' => 'V', 'weight' => 1], ['item' => 187, 'response' => 'V', 'weight' => 1]],
            'P.1' => [['item' => 12, 'response' => 'V', 'weight' => 1], ['item' => 15, 'response' => 'V', 'weight' => 1], ['item' => 21, 'response' => 'V', 'weight' => 1], ['item' => 24, 'response' => 'V', 'weight' => 1], ['item' => 104, 'response' => 'V', 'weight' => 1], ['item' => 149, 'response' => 'V', 'weight' => 1], ['item' => 153, 'response' => 'V', 'weight' => 1], ['item' => 180, 'response' => 'V', 'weight' => 1], ['item' => 195, 'response' => 'V', 'weight' => 1]],
            'P.2' => [['item' => 17, 'response' => 'V', 'weight' => 1], ['item' => 52, 'response' => 'V', 'weight' => 1], ['item' => 79, 'response' => 'V', 'weight' => 1], ['item' => 88, 'response' => 'V', 'weight' => 1], ['item' => 172, 'response' => 'V', 'weight' => 1], ['item' => 182, 'response' => 'V', 'weight' => 1], ['item' => 184, 'response' => 'V', 'weight' => 1]],
            'P.3' => [['item' => 13, 'response' => 'V', 'weight' => 1], ['item' => 32, 'response' => 'V', 'weight' => 1], ['item' => 68, 'response' => 'V', 'weight' => 1], ['item' => 96, 'response' => 'V', 'weight' => 1], ['item' => 106, 'response' => 'V', 'weight' => 1], ['item' => 112, 'response' => 'V', 'weight' => 1], ['item' => 122, 'response' => 'V', 'weight' => 1], ['item' => 136, 'response' => 'V', 'weight' => 1], ['item' => 148, 'response' => 'V', 'weight' => 1], ['item' => 167, 'response' => 'V', 'weight' => 1]],
        ];
        $this->sinceridad_adjustments = [
            '0' => ['personality' => 10, 'severe_clinical' => 5],
            '1' => ['personality' => 10, 'severe_clinical' => 5],
            '2' => ['personality' => 10, 'severe_clinical' => 5],
            '3' => ['personality' => 10, 'severe_clinical' => 5],
            '4' => ['personality' => 10, 'severe_clinical' => 5],
            '5' => ['personality' => 10, 'severe_clinical' => 5],
            '6' => ['personality' => 10, 'severe_clinical' => 5],
            '7' => ['personality' => 10, 'severe_clinical' => 5],
            '8' => ['personality' => 9, 'severe_clinical' => 5],
            '9' => ['personality' => 8, 'severe_clinical' => 4],
            '10' => ['personality' => 7, 'severe_clinical' => 4],
            '11' => ['personality' => 6, 'severe_clinical' => 3],
            '12' => ['personality' => 5, 'severe_clinical' => 3],
            '13' => ['personality' => 4, 'severe_clinical' => 2],
            '14' => ['personality' => 4, 'severe_clinical' => 2],
            '15' => ['personality' => 3, 'severe_clinical' => 2],
            '16' => ['personality' => 3, 'severe_clinical' => 2],
            '17' => ['personality' => 2, 'severe_clinical' => 1],
            '18' => ['personality' => 2, 'severe_clinical' => 1],
            '19' => ['personality' => 1, 'severe_clinical' => 1],
            '20' => ['personality' => 1, 'severe_clinical' => 1],
            '21' => ['personality' => 0, 'severe_clinical' => 0],
            '22' => ['personality' => 0, 'severe_clinical' => 0],
            '23' => ['personality' => 0, 'severe_clinical' => 0],
            '24' => ['personality' => 0, 'severe_clinical' => 0],
            '25' => ['personality' => 0, 'severe_clinical' => 0],
            '26' => ['personality' => 0, 'severe_clinical' => 0],
            '27' => ['personality' => 0, 'severe_clinical' => 0],
            '28' => ['personality' => 0, 'severe_clinical' => 0],
            '29' => ['personality' => 0, 'severe_clinical' => 0],
            '30' => ['personality' => 0, 'severe_clinical' => 0],
            '31' => ['personality' => 0, 'severe_clinical' => 0],
            '32' => ['personality' => 0, 'severe_clinical' => 0],
            '33' => ['personality' => 0, 'severe_clinical' => 0],
            '34' => ['personality' => 0, 'severe_clinical' => 0],
            '35' => ['personality' => 0, 'severe_clinical' => 0],
            '36' => ['personality' => 0, 'severe_clinical' => 0],
            '37' => ['personality' => 0, 'severe_clinical' => 0],
            '38' => ['personality' => 0, 'severe_clinical' => 0],
            '39' => ['personality' => 0, 'severe_clinical' => 0],
            '40' => ['personality' => 0, 'severe_clinical' => 0],
            '41' => ['personality' => 0, 'severe_clinical' => 0],
            '42' => ['personality' => 0, 'severe_clinical' => 0],
            '43' => ['personality' => 0, 'severe_clinical' => 0],
            '44' => ['personality' => 0, 'severe_clinical' => 0],
            '45' => ['personality' => 0, 'severe_clinical' => 0],
            '46' => ['personality' => 0, 'severe_clinical' => 0],
            '47' => ['personality' => 0, 'severe_clinical' => 0],
            '48' => ['personality' => 0, 'severe_clinical' => 0],
            '49' => ['personality' => 0, 'severe_clinical' => 0],
            '50' => ['personality' => 0, 'severe_clinical' => 0],
            '51' => ['personality' => 0, 'severe_clinical' => 0],
            '52' => ['personality' => 0, 'severe_clinical' => 0],
            '53' => ['personality' => 0, 'severe_clinical' => 0],
            '54' => ['personality' => 0, 'severe_clinical' => 0],
            '55' => ['personality' => 0, 'severe_clinical' => 0],
            '56' => ['personality' => 0, 'severe_clinical' => 0],
            '57' => ['personality' => 0, 'severe_clinical' => 0],
            '58' => ['personality' => 0, 'severe_clinical' => 0],
            '59' => ['personality' => 0, 'severe_clinical' => 0],
            '60' => ['personality' => 0, 'severe_clinical' => 0],
            '61' => ['personality' => -1, 'severe_clinical' => -1],
            '62' => ['personality' => -1, 'severe_clinical' => -1],
            '63' => ['personality' => -1, 'severe_clinical' => -1],
            '64' => ['personality' => -1, 'severe_clinical' => -1],
            '65' => ['personality' => -1, 'severe_clinical' => -1],
            '66' => ['personality' => -1, 'severe_clinical' => -1],
            '67' => ['personality' => -2, 'severe_clinical' => -1],
            '68' => ['personality' => -2, 'severe_clinical' => -1],
            '69' => ['personality' => -2, 'severe_clinical' => -1],
            '70' => ['personality' => -2, 'severe_clinical' => -1],
            '71' => ['personality' => -2, 'severe_clinical' => -1],
            '72' => ['personality' => -3, 'severe_clinical' => -2],
            '73' => ['personality' => -3, 'severe_clinical' => -2],
            '74' => ['personality' => -3, 'severe_clinical' => -2],
            '75' => ['personality' => -3, 'severe_clinical' => -2],
            '76' => ['personality' => -3, 'severe_clinical' => -2],
            '77' => ['personality' => -4, 'severe_clinical' => -2],
            '78' => ['personality' => -4, 'severe_clinical' => -2],
            '79' => ['personality' => -4, 'severe_clinical' => -2],
            '80' => ['personality' => -4, 'severe_clinical' => -2],
            '81' => ['personality' => -4, 'severe_clinical' => -2],
            '82' => ['personality' => -4, 'severe_clinical' => -2],
            '83' => ['personality' => -5, 'severe_clinical' => -3],
            '84' => ['personality' => -5, 'severe_clinical' => -3],
            '85' => ['personality' => -5, 'severe_clinical' => -3],
            '86' => ['personality' => -5, 'severe_clinical' => -3],
            '87' => ['personality' => -5, 'severe_clinical' => -3],
            '88' => ['personality' => -6, 'severe_clinical' => -3],
            '89' => ['personality' => -6, 'severe_clinical' => -3],
            '90' => ['personality' => -6, 'severe_clinical' => -3],
            '91' => ['personality' => -6, 'severe_clinical' => -3],
            '92' => ['personality' => -6, 'severe_clinical' => -3],
            '93' => ['personality' => -6, 'severe_clinical' => -3],
            '94' => ['personality' => -7, 'severe_clinical' => -4],
            '95' => ['personality' => -7, 'severe_clinical' => -4],
            '96' => ['personality' => -7, 'severe_clinical' => -4],
            '97' => ['personality' => -7, 'severe_clinical' => -4],
            '98' => ['personality' => -7, 'severe_clinical' => -4],
            '99' => ['personality' => -8, 'severe_clinical' => -4],
            '100' => ['personality' => -8, 'severe_clinical' => -4],
            '101' => ['personality' => -8, 'severe_clinical' => -4],
            '102' => ['personality' => -8, 'severe_clinical' => -4],
            '103' => ['personality' => -8, 'severe_clinical' => -4],
            '104' => ['personality' => -8, 'severe_clinical' => -4],
            '105' => ['personality' => -9, 'severe_clinical' => -5],
            '106' => ['personality' => -9, 'severe_clinical' => -5],
            '107' => ['personality' => -9, 'severe_clinical' => -5],
            '108' => ['personality' => -9, 'severe_clinical' => -5],
            '109' => ['personality' => -9, 'severe_clinical' => -5],
            '110' => ['personality' => -10, 'severe_clinical' => -5],
            '111' => ['personality' => -10, 'severe_clinical' => -5],
            '112' => ['personality' => -10, 'severe_clinical' => -5],
            '113' => ['personality' => -10, 'severe_clinical' => -5],
            '114' => ['personality' => -10, 'severe_clinical' => -5],
            '115' => ['personality' => -10, 'severe_clinical' => -5],
            '116' => ['personality' => -10, 'severe_clinical' => -5],
            '117' => ['personality' => -10, 'severe_clinical' => -5],
            '118' => ['personality' => -10, 'severe_clinical' => -5],
            '119' => ['personality' => -10, 'severe_clinical' => -5],
            '120' => ['personality' => -10, 'severe_clinical' => -5],
        ];
        $this->anx_dep_adjustments = [
            '0' => ['mel_mas_lim' => 0, 'evi_szt' => 0],
            '1' => ['mel_mas_lim' => -1, 'evi_szt' => -1],
            '2' => ['mel_mas_lim' => -1, 'evi_szt' => -1],
            '3' => ['mel_mas_lim' => -1, 'evi_szt' => -1],
            '4' => ['mel_mas_lim' => -1, 'evi_szt' => -1],
            '5' => ['mel_mas_lim' => -2, 'evi_szt' => -1],
            '6' => ['mel_mas_lim' => -2, 'evi_szt' => -1],
            '7' => ['mel_mas_lim' => -2, 'evi_szt' => -1],
            '8' => ['mel_mas_lim' => -2, 'evi_szt' => -1],
            '9' => ['mel_mas_lim' => -2, 'evi_szt' => -1],
            '10' => ['mel_mas_lim' => -3, 'evi_szt' => -2],
            '11' => ['mel_mas_lim' => -3, 'evi_szt' => -2],
            '12' => ['mel_mas_lim' => -3, 'evi_szt' => -2],
            '13' => ['mel_mas_lim' => -3, 'evi_szt' => -2],
            '14' => ['mel_mas_lim' => -3, 'evi_szt' => -2],
            '15' => ['mel_mas_lim' => -4, 'evi_szt' => -2],
            '16' => ['mel_mas_lim' => -4, 'evi_szt' => -2],
            '17' => ['mel_mas_lim' => -4, 'evi_szt' => -2],
            '18' => ['mel_mas_lim' => -4, 'evi_szt' => -2],
            '19' => ['mel_mas_lim' => -4, 'evi_szt' => -2],
            '20' => ['mel_mas_lim' => -5, 'evi_szt' => -3],
            '21' => ['mel_mas_lim' => -5, 'evi_szt' => -3],
            '22' => ['mel_mas_lim' => -5, 'evi_szt' => -3],
            '23' => ['mel_mas_lim' => -5, 'evi_szt' => -3],
            '24' => ['mel_mas_lim' => -5, 'evi_szt' => -3],
            '25' => ['mel_mas_lim' => -5, 'evi_szt' => -3],
            '26' => ['mel_mas_lim' => -5, 'evi_szt' => -3],
            '27' => ['mel_mas_lim' => -5, 'evi_szt' => -3],
            '28' => ['mel_mas_lim' => -5, 'evi_szt' => -3],
            '29' => ['mel_mas_lim' => -5, 'evi_szt' => -3],
            '30' => ['mel_mas_lim' => -6, 'evi_szt' => -3],
            '31' => ['mel_mas_lim' => -6, 'evi_szt' => -3],
            '32' => ['mel_mas_lim' => -6, 'evi_szt' => -3],
            '33' => ['mel_mas_lim' => -6, 'evi_szt' => -3],
            '34' => ['mel_mas_lim' => -6, 'evi_szt' => -3],
            '35' => ['mel_mas_lim' => -6, 'evi_szt' => -3],
            '36' => ['mel_mas_lim' => -6, 'evi_szt' => -3],
            '37' => ['mel_mas_lim' => -6, 'evi_szt' => -3],
            '38' => ['mel_mas_lim' => -6, 'evi_szt' => -3],
            '39' => ['mel_mas_lim' => -6, 'evi_szt' => -3],
            '40' => ['mel_mas_lim' => -7, 'evi_szt' => -4],
            '41' => ['mel_mas_lim' => -7, 'evi_szt' => -4],
            '42' => ['mel_mas_lim' => -7, 'evi_szt' => -4],
            '43' => ['mel_mas_lim' => -7, 'evi_szt' => -4],
            '44' => ['mel_mas_lim' => -7, 'evi_szt' => -4],
            '45' => ['mel_mas_lim' => -7, 'evi_szt' => -4],
            '46' => ['mel_mas_lim' => -7, 'evi_szt' => -4],
            '47' => ['mel_mas_lim' => -7, 'evi_szt' => -4],
            '48' => ['mel_mas_lim' => -7, 'evi_szt' => -4],
            '49' => ['mel_mas_lim' => -7, 'evi_szt' => -4],
            '50' => ['mel_mas_lim' => -8, 'evi_szt' => -4],
            '51' => ['mel_mas_lim' => -8, 'evi_szt' => -4],
            '52' => ['mel_mas_lim' => -8, 'evi_szt' => -4],
            '53' => ['mel_mas_lim' => -8, 'evi_szt' => -4],
            '54' => ['mel_mas_lim' => -8, 'evi_szt' => -4],
            '55' => ['mel_mas_lim' => -8, 'evi_szt' => -4],
            '56' => ['mel_mas_lim' => -8, 'evi_szt' => -4],
            '57' => ['mel_mas_lim' => -8, 'evi_szt' => -4],
            '58' => ['mel_mas_lim' => -8, 'evi_szt' => -4],
            '59' => ['mel_mas_lim' => -8, 'evi_szt' => -4],
            '60' => ['mel_mas_lim' => -9, 'evi_szt' => -5],
            '61' => ['mel_mas_lim' => -9, 'evi_szt' => -5],
            '62' => ['mel_mas_lim' => -9, 'evi_szt' => -5],
            '63' => ['mel_mas_lim' => -9, 'evi_szt' => -5],
            '64' => ['mel_mas_lim' => -9, 'evi_szt' => -5],
            '65' => ['mel_mas_lim' => -9, 'evi_szt' => -5],
            '66' => ['mel_mas_lim' => -9, 'evi_szt' => -5],
            '67' => ['mel_mas_lim' => -9, 'evi_szt' => -5],
            '68' => ['mel_mas_lim' => -9, 'evi_szt' => -5],
            '69' => ['mel_mas_lim' => -9, 'evi_szt' => -5],
            '70' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
            '71' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
            '72' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
            '73' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
            '74' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
            '75' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
            '76' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
            '77' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
            '78' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
            '79' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
            '80' => ['mel_mas_lim' => -10, 'evi_szt' => -5],
        ];
        $this->facets_info = [
            '1.1' => "una disposición a permanecer indiferente y distante respecto de las acciones y sentimientos ajenos, con preferencia por las actividades solitarias y un mínimo interés por las demás personas; tiende a situarse en un segundo plano y a asumir un papel secundario en los ámbitos social, escolar y familiar, sin establecer ni desear vínculos estrechos",
            '1.2' => "una carencia de representaciones objetales interiorizadas, que se encuentran mínimamente articuladas y, en su mayoría, vacías de las percepciones y recuerdos propios de las relaciones con los demás, todo lo cual deriva en una escasa interacción dinámica entre los impulsos psíquicos y los conflictos",
            '1.3' => "una insensibilidad innata y una frialdad afectiva, con pocas necesidades afectivas o sexuales y una aparente incapacidad para experimentar placer, tristeza o ira con cierta intensidad",
            '2A.1' => "una evitación de las actividades que suponen relaciones personales estrechas, sobre un sustrato de ansiedad social y desconfianza; busca la aceptación, no obstante se muestra poco dispuesto a implicarse en los vínculos a menos que tenga la certeza de agradar, en la medida en que mantiene la distancia para preservar su privacidad y evitar la vergüenza y la humillación",
            '2A.2' => "una representación de sí mismo como socialmente inepto, incompetente e inferior, lo cual justifica a sus ojos el aislamiento y el rechazo recibido; se percibe personalmente poco atractivo, subestima sus logros y experimenta una persistente sensación de vacío",
            '2A.3' => "una serie de representaciones interiorizadas compuestas de recuerdos de relaciones tempranas problemáticas, intensos y conflictivos, que se reactivan fácilmente; por consiguiente, dispone de limitadas opciones para sentir satisfacción o evocar momentos satisfactorios, así como de pocos mecanismos para canalizar sus necesidades o evitar los estresores externos",
            '2B.1' => "una actitud derrotista y fatalista ante prácticamente todo y una tendencia a ver el lado más adverso de las cosas y a esperar lo peor; tiende a sentirse agobiado, desanimado y abatido, en tanto que su interpretación de los acontecimientos resulta consistentemente pesimista",
            '2B.2' => "una representación de sí mismo como alguien que no vale nada, insignificante e irrelevante, sobre un sustrato de tristeza generalizada; el menor error puede sumirlo en un estado profundo de desánimo, en la medida en que se ve a sí mismo como alguien que merece ser criticado y menospreciado",
            '2B.3' => "un estado apenado y malhumorado, intensificado por su tendencia a preocuparse, ver el lado negativo de todo y sentirse culpable; puede relacionarse con los demás, si bien lo hace de manera mecánica y con poco entusiasmo, todo lo cual merma su capacidad de disfrutar de la vida",
            '3.1' => "una desvinculación de las responsabilidades propias de los adultos; tiende a ser dócil y pasivo, muestra escasas capacidades funcionales y evita la asertividad, en la medida en que carece de la seguridad propia de la madurez y busca el afecto, la atención y la protección de los demás a la manera infantil",
            '3.2' => "una entrega ante figuras más fuertes y protectoras, sin las cuales puede sentirse angustiadamente solo y desvalido; necesita recibir consejos y seguridad de forma constante y se muestra obediente, transigente y conciliador, en tanto que teme quedarse sin nadie que se ocupe de él",
            '3.3' => "una representación de sí mismo como débil, frágil e incompetente, sobre un sustrato de menosprecio de las propias capacidades; carece de confianza para actuar por sí solo, si bien gran parte de esta autodevaluación opera, al margen de la conciencia, como una estrategia para obtener elogios y apoyo de los demás",
            '4A.1' => "una reactividad voluble, provocadora y cautivadora; tiende a ser caprichoso, a entusiasmarse con facilidad y a no tolerar los fracasos, los retrasos ni las desilusiones, de manera que reacciona de forma impulsiva, teatral y emocionalmente intensa, en tanto que se siente atraído por las experiencias estimulantes y las situaciones de novedad",
            '4A.2' => "una búsqueda activa de elogios y la manipulación de los demás para obtener la seguridad, atención y aprobación que necesita; tiende a mostrarse exigente, coqueto, engreído y seductoramente exhibicionista, en particular cuando quiere ser el centro de atención",
            '4A.3' => "una sensibilidad emocional y la expresión de sentimientos, positivos y negativos, que cambian con facilidad; pasa con rapidez de la alegría y el entusiasmo a la impulsividad, el enfado o el aburrimiento, sobre un alto nivel de activación autónoma",
            '4B.1' => "una conducta enérgica, decidida, emocionalmente excitable y entusiasta, sobre un sustrato de vitalidad sostenida y una inquietud que rara vez se aplaca; este ánimo sostenido, no obstante, no se traduce necesariamente en logros efectivos y, cuando esto sucede, puede derivar en obstinación con los demás y en conductas cáusticas o agresivas",
            '4B.2' => "una disposición optimista y animada en los vínculos sociales, junto con el intento de atraer a los demás mediante un entusiasmo contagioso; no obstante, bajo presión o en estados eufóricos puede volverse entrometido, autoritario e innecesariamente intruso",
            '4B.3' => "una representación de sí mismo como una fuerza imponente, inspiradora y vigorosa, cuya energía omnipresente activa y estimula a los demás; tiende a creerse invencible y capaz de emprender y lograr más de lo objetivamente posible",
            '5.1' => "un sentido de privilegio, una falta de empatía y la expectativa de favores especiales a cambio de nada; no valora a los demás y los utiliza abiertamente para satisfacer sus propios deseos y destacar",
            '5.2' => "una imaginación expansiva y un pensamiento centrado en fantasías inmaduras de éxito, belleza o amor; la realidad objetiva lo limita poco, en la medida en que hace su propia interpretación de los hechos y, en ocasiones, los distorsiona para sostener las fantasías sobre sí mismo",
            '5.3' => "una representación de sí mismo como elogiable, especial, único y digno de toda admiración; actúa con grandiosidad y seguridad en sí mismo, a menudo sin que existan motivos objetivos para hacerlo, en tanto que sostiene una autoestima elevada a pesar de que los demás puedan percibirlo como egocéntrico, desconsiderado y arrogante",
            '6A.1' => "una disposición a actuar como persona desleal en la que no se puede confiar, que incumple o elude deliberadamente sus obligaciones personales, no respeta a los demás y vulnera sus derechos; sus conductas engañosas e ilegales conllevan la transgresión de los códigos sociales establecidos",
            '6A.2' => "una percepción de sí mismo como libre tanto de las restricciones de las normas sociales como de la obligación de mantenerse leal a otras personas; valora la idea de libertad y disfruta sintiéndose sin responsabilidades, en tanto que siente que no está limitado por personas, lugares, obligaciones o rutinas",
            '6A.3' => "una evitación de las tensiones internas a través de la expresión sin limitación de pensamientos ofensivos y la realización de acciones malintencionadas; no transforma los impulsos socialmente repulsivos en formas sublimadas, sino que los libera directa e impetuosamente, por lo general al margen del sentimiento de culpa y del remordimiento",
            '6B.1' => "una falta de sensibilidad hacia los demás y una inclinación a discutir y polemizar, con reacciones de arrebatos repentinos, inesperados e injustificados; se muestra impasible ante el dolor y poco intimidado por los peligros o castigos, en tanto que ante insultos u ofensas se inclina a actuar por venganza",
            '6B.2' => "una gratificación psicológica inmediata al intimidar, coaccionar, humillar o menospreciar a los demás; tiende a ser ofensivo verbalmente y, posiblemente, agresivo física o sexualmente",
            '6B.3' => "una energía interior de naturaleza agresiva o sexual que se va acumulando y acaba manifestándose en arrebatos impetuosos que amenazan con desbordar el autocontrol; experiencias dolorosas tempranas han dado lugar a emociones residuales que expresa con inmediatez y de forma persistente",
            '7.1' => "una vida muy estructurada y estrictamente organizada, en una conducta estricta y responsable y en la necesidad de mantener las emociones bajo control; su búsqueda del perfeccionismo puede resultar limitante y dificultar la realización completa de las tareas habituales",
            '7.2' => "una construcción del mundo en términos de reglas, normas, planificaciones y jerarquías sociales; tiende a ser inflexible y obstinado respecto al cumplimiento de las normas convencionales y, ante situaciones inciertas, a menudo acaba bloqueado, incapaz de tomar una decisión",
            '7.3' => "una representación de sí mismo como eficiente, disciplinado, meticuloso y diligente, sobre un sustrato de dedicación al trabajo y a las responsabilidades; tiende a restar importancia a las actividades recreativas y de ocio, en tanto que teme ser visto como irresponsable o como alguien que no cumple las expectativas de los demás",
            '8A.1' => "una resistencia a cumplir las expectativas de los demás, con tendencia a la dilación, la ineficiencia, la obstinación y el oposicionismo; al margen de la conciencia, exterioriza una satisfacción al socavar los placeres y aspiraciones ajenos",
            '8A.2' => "una representación de sí mismo como incomprendido, desafortunado, poco valorado y menospreciado por los demás; reconoce su propio resentimiento, insatisfacción y desilusión con la vida, en tanto que experimenta envidia y rencor hacia quienes considera que tienen una vida más fácil",
            '8A.3' => "un estado malhumorado, obstinado y resentido, con una baja tolerancia a la frustración; fácilmente se exaspera ante lo que hacen los demás, en tanto que tiende a replegarse huraño y en silencio",
            '8B.1' => "una tendencia a humillarse y a considerarse merecedor de deshonras, reproches y menosprecios; tiende a centrarse en sus peores características y, ante elogios o reconocimientos, suele considerarlos observaciones erróneas, en tanto que ante el incumplimiento de expectativas siente que merece consecuencias dolorosas",
            '8B.2' => "una tendencia a sentir placer cuando la reacción más apropiada sería el dolor y dolor cuando la más adecuada sería el placer; esta transposición recurrente de la gratificación de las necesidades se traduce, por consiguiente, en frustración y, en ocasiones, en autosabotaje",
            '8B.3' => "un estado oscilante entre la ansiedad y la inquietud y el ánimo apenado y triste; experimenta angustia y tormento con frecuencia, en tanto que tiende a mostrarse deliberadamente quejumbroso y melancólico para provocar sentimientos de culpa y malestar en los demás",
            'S.1' => "una mezcla de la comunicación social con irrelevancias personales, lenguaje circunstancial, ideas de referencia y comentarios metafóricos al margen; tiende a mostrarse absorto en sí mismo y sumido en sus fantasías, con un ocasional pensamiento mágico, ilusiones corporales y distorsión entre realidad y fantasía",
            'S.2' => "una confusión respecto de sí mismo y una perplejidad respecto de la sociedad, con experiencias aisladas de despersonalización y alteración de la conciencia; se ve a sí mismo apenado, con pensamientos recurrentes sobre el vacío y la falta de sentido de la vida, en tanto que su percepción deficiente y su afectividad incongruente hacen que sólo pueda vivir los acontecimientos con desánimo e incomprensión",
            'S.3' => "una maraña de recuerdos diversos, impulsos erráticos y canales desorganizados de regulación de la tensión; esta mezcla casi aleatoria de objetos, impulsos y pensamientos vuelve ineficaz y desorganizada la regulación de tensiones, necesidades y objetivos",
            'C.1' => "una confusión generada por un sentido de la identidad inmaduro, indefinido o fluctuante, con sentimientos subyacentes de vacío; aparenta una incapacidad para elegir un rumbo o rol a partir del cual formarse un sentido de sí mismo homogéneo y duradero, en tanto que tiende a redimir los actos impulsivos con expresiones de remordimiento y conductas autopunitivas",
            'C.2' => "una estructura psíquica interior inconsistente e incongruente, caracterizada por una inusual combinación de elementos claramente segmentados; los niveles de conciencia pueden cambiar de repente y dar lugar a percepciones, recuerdos y afectos opuestos, todo lo cual potencialmente conlleva episodios psicóticos breves relacionados con el estrés",
            'C.3' => "una inestabilidad emocional con un estado de ánimo poco acorde a la realidad; el desánimo y la apatía crónicos se intercalan con periodos breves de ira, euforia o ansiedad, en tanto que puede predominar un componente depresivo autocompasivo que da paso periódicamente a una agitación ansiosa o a arrebatos impulsivos",
            'P.1' => "una actitud constante de alerta, cautela y desconfianza para protegerse anticipadamente de los engaños y la malicia de los demás; es tenaz y se resiste con firmeza a las influencias externas y a ser controlado, en tanto que se muestra tenso e inquieto, con una actitud defensiva que lo lleva a reaccionar bruscamente ante la mínima ofensa real o percibida",
            'P.2' => "una suspicacia permanente respecto de las intenciones de los demás y una tendencia a interpretar erróneamente acciones inofensivas como pruebas de hipocresía o de conspiración; capta cualquier detalle por trivial que sea, lo magnifica y lo distorsiona para confirmar sus peores expectativas",
            'P.3' => "una no aceptación de sus cualidades e intenciones despreciables, que atribuye a los demás; permanece ciego a su propia conducta y a sus rasgos indeseables, en tanto que advierte los defectos más intrascendentes de los otros, sobre un sustrato de susceptibilidad e irritabilidad que lo mantiene siempre dispuesto a descalificar y a menospreciar a quienes considera sospechosos",
        ];
        $this->syndromes_info = [
            'A' => ['name' => "de ansiedad generalizada", 'desc' => "un estado generalizado de tensión que se traduce en la incapacidad de relajarse, en movimientos nerviosos y en una tendencia a reaccionar y sobresaltarse fácilmente, sobre un sustrato de quejas frecuentes por molestias físicas de distinto tipo (dolores musculares mal definidos, sudoración excesiva, náuseas), junto con inquietud y temor por problemas que cree inminentes, un estado de alerta excesivo hacia todo lo que lo rodea y una irritabilidad generalizada"],
            'H' => ['name' => "de síntomas somáticos", 'desc' => "una preocupación frecuente por su mala salud y por toda una serie de dolores desmesurados pero en gran medida inespecíficos en distintas partes del cuerpo; tiende a interpretar los periodos persistentes de fatiga o las molestias físicas de poca importancia como indicadores de enfermedades graves y, cuando realmente padece alguna enfermedad, a sobrevalorarla pese a que los médicos le digan que puede estar tranquilo, en la medida en que utiliza los problemas somáticos para llamar la atención"],
            'N' => ['name' => "del espectro bipolar", 'desc' => "la experiencia de síntomas que pueden ir desde rasgos ciclotímicos hasta cuadros bipolares de mayor gravedad, con periodos de euforia superficial, autoestima exagerada, hiperactividad y falta de atención, nerviosismo, presión del habla, impulsividad e irritabilidad; actúa con un entusiasmo poco selectivo, planifica en exceso objetivos poco realistas y es entrometido, cuando no dominante y exigente, en las relaciones interpersonales, en tanto que necesita dormir menos, tiene fugas de ideas y cambios de humor rápidos e inestables, todo lo cual, en los casos extremos, puede dar lugar a procesos psicóticos, como delirios y alucinaciones"],
            'D' => ['name' => "de depresión persistente", 'desc' => "una participación en la vida diaria pero, durante años, con angustia, sentimientos de desánimo o culpa, falta de iniciativa, apatía y baja autoestima, así como expresiones frecuentes de inutilidad y comentarios autodenigrantes; durante los periodos depresivos pueden observarse muchos momentos de llanto, ideación suicida, visión pesimista del futuro, aislamiento social, falta de apetito o apetito excesivo, fatiga crónica, falta de concentración y una notable pérdida de interés por las actividades placenteras, todo lo cual contribuye a que el evaluado(a) lleve a cabo las tareas cotidianas con menor eficacia"],
            'B' => ['name' => "de consumo de alcohol", 'desc' => "una historia probable de alcoholismo recurrente o reciente y la dificultad para superar el problema, en virtud de la cual el evaluado(a) se siente muy mal en el ámbito familiar y laboral"],
            'T' => ['name' => "de consumo de sustancias", 'desc' => "una historia probable de drogadicción recurrente o reciente, en la medida en que le suele costar reprimir sus impulsos o mantenerlos dentro de los límites sociales convencionales y, en muchos casos, una incapacidad para gestionar las consecuencias personales de su conducta"],
            'R' => ['name' => "de estrés postraumático", 'desc' => "la vivencia o el haber presenciado un acontecimiento relacionado con la muerte o con lesiones graves, ya sea real o amenaza, que le ha causado un miedo intenso, sentimientos de impotencia u horror; estos acontecimientos traumáticos se reviven a menudo a través de sueños, pesadillas o recuerdos que producen mucho malestar y ansiedad, en el contexto de síntomas de activación ansiosa, como los sobresaltos exagerados y la hipervigilancia, así como del esfuerzo por evitar todo aquello que asocia con el trauma"],
            'SS' => ['name' => "del espectro esquizofrénico", 'desc' => "conductas incongruentes, desorganizadas o regresivas que aparecen periódicamente, en las que a menudo parece confuso y desorientado, con afectos inapropiados, alucinaciones aisladas y delirios no sistemáticos; sus pensamientos pueden estar fragmentados o ser extraños y sus sentimientos aplanados, en tanto que tiende a sentirse aislado de los demás e incomprendido, con conductas retraídas, solitarias y reservadas"],
            'CC' => ['name' => "de depresión mayor", 'desc' => "una incapacidad para funcionar en un entorno normal, una visión pesimista del futuro, ideación suicida y un sentimiento generalizado de resignación sin esperanza, con miedos repetitivos y un estado meditabundo; físicamente puede observarse un notable deterioro motor o, por el contrario, una inquietud incesante con lamentos sobre su deplorable estado, así como insomnio, una sensación de cansancio acentuado y pérdida o ganancia de peso"],
            'PP' => ['name' => "delirante", 'desc' => "un estado paranoide agudo en el que periódicamente puede mostrar agresividad y expresar delirios irracionales pero interconectados, de temática celosa, persecutoria o de grandeza; presenta indicios de alteración del pensamiento e ideas de referencia, así como recelo y vigilancia constante ante una posible traición, en el contexto de un estado de ánimo hostil, en la medida en que se siente acosado y maltratado por los demás"],
        ];
    }

    public function score($answers, $baremo_id) {
        $baremo = ($baremo_id == 59) ? new ModelBaremoEspania() : new ModelBaremoEeuu();
        
        // 1. Convert answers list to map item_order -> response
        $responses = [];
        foreach ($answers as $ans) {
            $responses[intval($ans['item_order'])] = intval($ans['response']);
        }
        
        // 2. Calculate Raw Scores (PD)
        $raw_scores = [];
        $scale_map = [
            'Esquizoide' => '1', 'Evitativo' => '2A', 'Melancólico' => '2B', 'Dependiente' => '3',
            'Histriónico' => '4A', 'Tempestuoso' => '4B', 'Narcisista' => '5', 'Antisocial' => '6A',
            'Sádico' => '6B', 'Compulsivo' => '7', 'Negativista' => '8A', 'Masoquista' => '8B',
            'Esquizotípico' => 'S', 'Límite' => 'C', 'Paranoide' => 'P', 'Ansiedad generalizada' => 'A',
            'Síntomas somáticos' => 'H', 'Espectro bipolar' => 'N', 'Depresión persistente' => 'D',
            'Consumo de alcohol' => 'B', 'Consumo de drogas' => 'T', 'Estrés postraumático' => 'R',
            'Espectro esquizofrénico' => 'SS', 'Depresión mayor' => 'CC', 'Delirante' => 'PP',
            'Sinceridad' => 'X', 'Deseabilidad social' => 'Y', 'Devaluación' => 'Z'
        ];
        
        foreach ($scale_map as $scale_name => $code) {
            $raw_scores[$code] = 0;
            if (isset($this->scale_rules[$scale_name])) {
                foreach ($this->scale_rules[$scale_name] as $rule) {
                    $item = $rule['item'];
                    $expected = ($rule['response'] === 'V') ? 1 : 0;
                    $actual = $responses[$item] ?? 0;
                    if ($actual === $expected) {
                        $raw_scores[$code] += $rule['weight'];
                    }
                }
            }
        }
        
        // Calculate raw scores for all facets
        foreach ($this->scale_rules as $scale_name => $rules) {
            if (preg_match('/^[0-9A-Z_\.]+\.[0-9]+$/', $scale_name)) {
                $raw_scores[$scale_name] = 0;
                foreach ($rules as $rule) {
                    $item = $rule['item'];
                    $expected = ($rule['response'] === 'V') ? 1 : 0;
                    $actual = $responses[$item] ?? 0;
                    if ($actual === $expected) {
                        $raw_scores[$scale_name] += $rule['weight'];
                    }
                }
            }
        }
        
        // Calculate Invalidez (V) and Inconsistencia (W)
        $invalidez = 0;
        foreach ($this->scale_rules['INVALIDEZ'] as $rule) {
            $item = $rule['item'];
            $expected = ($rule['response'] === 'V') ? 1 : 0;
            $actual = $responses[$item] ?? 0;
            if ($actual === $expected) {
                $invalidez += $rule['weight'];
            }
        }
        
        $inconsistencia = 0;
        foreach ($this->scale_rules['INCONSISTENCIA'] as $pair) {
            $ansA = $responses[$pair[0]] ?? 0;
            $ansB = $responses[$pair[1]] ?? 0;
            if ($ansA !== $ansB) {
                $inconsistencia++;
            }
        }
        
        // 3. Convert PD to Initial TB using Baremos
        $initial_tbs = [];
        foreach ($scale_map as $scale_name => $code) {
            $pd = $raw_scores[$code];
            $method_name = "getValue" . str_replace('.', '_', $code);
            if (method_exists($baremo, $method_name)) {
                $initial_tbs[$code] = $baremo->$method_name($pd);
            } else {
                $initial_tbs[$code] = 0;
            }
        }
        
        // 4. Calculate Adjustments
        // Sinceridad X Adjustment
        $x_pd = $raw_scores['X'];
        $x_adj = $this->sinceridad_adjustments[strval($x_pd)] ?? ['personality' => 0, 'severe_clinical' => 0];
        
        // Anxiety/Depression A/CC Adjustment
        $a_tb = $initial_tbs['A'];
        $cc_tb = $initial_tbs['CC'];
        $w3 = max(0, $a_tb - 75);
        $w4 = max(0, $cc_tb - 75);
        $w5 = $w3 + $w4;
        
        $ad_adj = $this->anx_dep_adjustments[strval($w5)] ?? ['mel_mas_lim' => 0, 'evi_szt' => 0];
        
        // 5. Apply Adjustments to get Final TB
        $final_tbs = [];
        $adjustments_applied = [];
        
        $personality_scales = ['1', '2A', '2B', '3', '4A', '4B', '5', '6A', '6B', '7', '8A', '8B'];
        $severe_personality_scales = ['S', 'C', 'P'];
        $clinical_syndromes = ['A', 'H', 'N', 'D', 'B', 'T', 'R'];
        $severe_clinical_syndromes = ['SS', 'CC', 'PP'];
        
        foreach ($scale_map as $scale_name => $code) {
            if (in_array($code, ['X', 'Y', 'Z'])) {
                $final_tbs[$code] = $initial_tbs[$code];
                $adjustments_applied[$code] = ['x' => 0, 'ad' => 0];
                continue;
            }
            
            $init_tb = $initial_tbs[$code];
            $x_val = 0;
            $ad_val = 0;
            
            // Apply X adjustment
            if (in_array($code, $personality_scales)) {
                $x_val = $x_adj['personality'];
            } else {
                $x_val = $x_adj['severe_clinical'];
            }
            
            // Apply A/CC adjustment
            if ($code === '2A' || $code === 'S') {
                $ad_val = $ad_adj['evi_szt'];
            } elseif ($code === '2B' || $code === '8B' || $code === 'C') {
                $ad_val = $ad_adj['mel_mas_lim'];
            }
            
            $final_tb = $init_tb + $x_val + $ad_val;
            $final_tb = max(0, min(115, $final_tb));
            $final_tbs[$code] = $final_tb;
            $adjustments_applied[$code] = ['x' => $x_val, 'ad' => $ad_val];
        }
        
        // 6. Look up Percentiles (PC)
        $percentiles = [];
        foreach ($scale_map as $scale_name => $code) {
            $tb = $final_tbs[$code];
            $method_name = "getPercentil" . str_replace('.', '_', $code);
            if (method_exists($baremo, $method_name)) {
                $percentiles[$code] = $baremo->$method_name($tb);
            } else {
                $percentiles[$code] = 0;
            }
        }
        
        // Facets PC and TB (looked up directly from Raw Scores)
        $facets_tb = [];
        foreach ($this->scale_rules as $scale_name => $rules) {
            if (preg_match('/^[0-9A-Z_\.]+\.[0-9]+$/', $scale_name)) {
                $pd = $raw_scores[$scale_name];
                
                $method_name = "getPercentilFacet" . str_replace('.', '_', $scale_name);
                if (method_exists($baremo, $method_name)) {
                    $percentiles[$scale_name] = $baremo->$method_name($pd);
                } else {
                    $percentiles[$scale_name] = 0;
                }
                
                $method_name_tb = "getTbFacet" . str_replace('.', '_', $scale_name);
                if (method_exists($baremo, $method_name_tb)) {
                    $facets_tb[$scale_name] = $baremo->$method_name_tb($pd);
                } else {
                    $facets_tb[$scale_name] = 0;
                }
            }
        }
        
        // 7. Generate Narratives
        $validity = $this->getValidityStatus($invalidez, $inconsistencia);
        $report = [];
        $report['validity_text'] = $validity['message'];
        $report['validity_status'] = $validity['status'];
        
        if ($validity['status'] === 'INVALID') {
            $report['personality'] = "El protocolo se considera inválido para su interpretación.";
            $report['facets'] = "El protocolo se considera inválido para su interpretación.";
            $report['syndromes'] = "El protocolo se considera inválido para su interpretación.";
        } else {
            $report['personality'] = $this->getPersonalityReport($final_tbs, $percentiles);
            $report['facets'] = $this->getFacetsReport($final_tbs, $percentiles, $facets_tb);
            $report['syndromes'] = $this->getSyndromesReport($final_tbs, $percentiles);
        }
        
        return [
            'raw_scores' => $raw_scores,
            'initial_tbs' => $initial_tbs,
            'adjustments' => $adjustments_applied,
            'final_tbs' => $final_tbs,
            'percentiles' => $percentiles,
            'invalidez' => $invalidez,
            'inconsistencia' => $inconsistencia,
            'report' => $report
        ];
    }
    
    public function getValidityStatus($invalidez, $inconsistencia) {
        if ($invalidez >= 2 && $inconsistencia >= 20) {
            return [
                'status' => 'INVALID',
                'message' => "El protocolo debe considerarse inválido a partir de los indicadores de respuestas aleatorias, por lo que no debe llevarse a cabo su interpretación. Las escalas V (Invalidez) y W (Inconsistencia) configuran de manera conjunta un patrón de respuesta compatible con un proceder aleatorio, lo que puede deberse a problemas de lectura o limitaciones lingüísticas, dificultad para mantener la atención, deterioro cognitivo, descuido, indiferencia, fatiga o falta de cooperación. En estos casos deben investigarse las posibles causas y, hasta que no se averigüe el motivo de la aleatoriedad, los resultados no deben interpretarse."
            ];
        }
        if ($invalidez >= 2) {
            return [
                'status' => 'INVALID',
                'message' => "El protocolo debe considerarse inválido a partir de los indicadores de respuestas aleatorias, por lo que no debe llevarse a cabo su interpretación. La escala V (Invalidez) presenta una puntuación compatible con un proceder aleatorio frente al contenido del inventario, lo que puede deberse a problemas de lectura o limitaciones lingüísticas, dificultad para mantener la atención, deterioro cognitivo, descuido, indiferencia, fatiga o falta de cooperación. En estos casos deben investigarse las posibles causas y, hasta que no se averigüe el motivo de la aleatoriedad, los resultados no deben interpretarse."
            ];
        }
        if ($inconsistencia >= 20) {
            return [
                'status' => 'INVALID',
                'message' => "El protocolo debe considerarse inválido a partir de los indicadores de respuestas aleatorias, por lo que no debe llevarse a cabo su interpretación. La escala W (Inconsistencia) evidencia discrepancias entre pares de ítems compatibles con un patrón de respuestas contradictorias, lo que puede deberse a problemas de lectura o limitaciones lingüísticas, dificultad para mantener la atención, deterioro cognitivo, descuido, indiferencia, fatiga o falta de cooperación. En estos casos deben investigarse las posibles causas y, hasta que no se averigüe el motivo de la aleatoriedad, los resultados no deben interpretarse."
            ];
        }
        if ($inconsistencia >= 9 && $inconsistencia <= 19) {
            return [
                'status' => 'QUESTIONABLE',
                'message' => "El protocolo se sitúa en el rango de los considerados cuestionables a partir del indicador de respuestas aleatorias W (Inconsistencia), que evidencia un número llamativo de respuestas contradictorias entre pares de ítems con contenido similar, lo cual sugiere una falta de receptividad al contenido de los ítems por parte del evaluado(a). Entre las causas habituales de tal patrón se incluyen problemas de lectura o limitaciones lingüísticas, dificultad para mantener la atención, deterioro cognitivo, descuido, fatiga o una falta de cooperación deliberada; cabe investigar la posible incidencia de tales factores en las respuestas del evaluado(a) y, entretanto, los resultados deben interpretarse con cautela y contrastarse con la información obtenida más allá del inventario, es decir, entrevista clínica, historial psicosocial y otras fuentes, antes de extraer conclusiones definitivas."
            ];
        }
        if ($invalidez == 1) {
            return [
                'status' => 'QUESTIONABLE',
                'message' => "El protocolo se sitúa en el rango de los considerados cuestionables a partir del indicador de respuestas aleatorias V (Invalidez), que presenta una puntuación que, sin alcanzar el umbral de invalidez, reduce la consistencia general del perfil. Tal patrón puede deberse a problemas de lectura o limitaciones lingüísticas, dificultad para mantener la atención, deterioro cognitivo, descuido, indiferencia, fatiga o falta de cooperación; cabe investigar las posibles causas y, entretanto, las elevaciones del perfil deben contrastarse con la información obtenida más allá del inventario, es decir, entrevista clínica, historial psicosocial y otras fuentes, antes de extraer conclusiones definitivas."
            ];
        }
        return [
            'status' => 'VALID',
            'message' => "El perfil es interpretable: las escalas V (Invalidez) y W (Inconsistencia) no muestran un patrón compatible con respuestas aleatorias, de modo que el perfil puede analizarse a partir de las elevaciones que presenta."
        ];
    }
    
    private function getPersonalityReport($final_tbs, $percentiles) {
        // Find top clinical personality scales
        $p_scales = [
            '1' => $final_tbs['1'] + $percentiles['1']/1000 + $final_tbs['1']/1000000,
            '2A' => $final_tbs['2A'] + $percentiles['2A']/1000 + $final_tbs['2A']/1000000,
            '2B' => $final_tbs['2B'] + $percentiles['2B']/1000 + $final_tbs['2B']/1000000,
            '3' => $final_tbs['3'] + $percentiles['3']/1000 + $final_tbs['3']/1000000,
            '4A' => $final_tbs['4A'] + $percentiles['4A']/1000 + $final_tbs['4A']/1000000,
            '4B' => $final_tbs['4B'] + $percentiles['4B']/1000 + $final_tbs['4B']/1000000,
            '5' => $final_tbs['5'] + $percentiles['5']/1000 + $final_tbs['5']/1000000,
            '6A' => $final_tbs['6A'] + $percentiles['6A']/1000 + $final_tbs['6A']/1000000,
            '6B' => $final_tbs['6B'] + $percentiles['6B']/1000 + $final_tbs['6B']/1000000,
            '7' => $final_tbs['7'] + $percentiles['7']/1000 + $final_tbs['7']/1000000,
            '8A' => $final_tbs['8A'] + $percentiles['8A']/1000 + $final_tbs['8A']/1000000,
            '8B' => $final_tbs['8B'] + $percentiles['8B']/1000 + $final_tbs['8B']/1000000
        ];
        
        arsort($p_scales);
        $sorted_codes = array_keys($p_scales);
        
        $aq205 = $sorted_codes[0];
        $aq206 = $final_tbs[$aq205];
        
        $aq207 = $sorted_codes[1];
        $aq208 = $final_tbs[$aq207];
        
        $aq209 = $sorted_codes[2];
        $aq210 = $final_tbs[$aq209];
        
        // Find highest severe scale (S, C, P)
        $severe_scales = [
            'S' => $final_tbs['S'],
            'C' => $final_tbs['C'],
            'P' => $final_tbs['P']
        ];
        arsort($severe_scales);
        $aq211 = array_keys($severe_scales)[0];
        $aq212 = $severe_scales[$aq211];
        if ($aq212 < 60) {
            $aq211 = "";
            $aq212 = 0;
        }
        
        $text = "";
        
        // AR186 (Severe personality scale narrative)
        if ($aq212 >= 60) {
            $sev_name = ($aq211 === 'S') ? "esquizotípico" : (($aq211 === 'C') ? "límite" : "paranoide");
            $sev_range = "";
            if ($aq212 >= 85) {
                $sev_range = "alcanza el rango de un trastorno clínicamente significativo de la personalidad y organiza la interpretación del resto del perfil. ";
            } elseif ($aq212 >= 75) {
                $sev_range = "alcanza el rango de un tipo de personalidad y organiza la interpretación del resto del perfil. ";
            } else {
                $sev_range = "se sitúa en el rango de un estilo de personalidad y matiza, en consecuencia, la interpretación del resto del perfil. ";
            }
            
            $text .= "Sobresale como configuración nuclear del perfil un cuadro " . $sev_name . ", que " . $sev_range;
            
            if ($aq211 === 'S') {
                $pref = ($aq212 >= 85) ? "prefiere" : "muestra preferencia por";
                $text .= "El evaluado(a) " . $pref . " estar aislado socialmente y sostener mínimos vínculos y obligaciones personales; su funcionamiento cognitivo tiende a ser desorganizado, piensa tangencialmente y a menudo parece estar absorto en sí mismo y pensativo, se distingue por sus excentricidades y a menudo es visto por los demás como una persona rara o diferente, en tanto que si su patrón básico es activo muestra desconfianza ansiosa e hipersensibilidad y si es pasivo muestra aplanamiento emocional y afecto deficiente. ";
            } elseif ($aq211 === 'C') {
                $carac = ($aq212 >= 85) ? "caracteriza" : "manifiesta";
                $text .= "El evaluado(a) se " . $carac . " por su inestabilidad y labilidad afectiva, experimenta estados de ánimo endógenos intensos, con periodos recurrentes de abatimiento y apatía, a menudo intercalados con periodos de ira, ansiedad o euforia, alberga pensamientos recurrentes de autolesiones y suicidio, parece extremadamente preocupado por conservar el afecto de los demás y tiene dificultades para mantener el sentido de su propia identidad, en tanto que a menudo muestra una ambivalencia cognitivo-afectiva que se evidencia en sentimientos conflictivos de rabia, amor y culpa hacia los demás. ";
            } elseif ($aq211 === 'P') {
                $muestra = ($aq212 >= 85) ? "muestra" : "manifiesta";
                $text .= "El evaluado(a) se " . $muestra . " desconfiado y en alerta hacia los demás, tenso y a la defensiva ante posibles críticas y engaños, presenta una irritabilidad desabrida y tiende a hacer que los demás se exasperen o se enfaden, se distingue, asimismo, por la inmutabilidad de sus sentimientos y la inflexibilidad de su pensamiento, en tanto que a menudo expresa miedo a perder la independencia, lo que lo lleva a resistirse enérgicamente a las influencias y al control externo. ";
            }
        }
        
        // AR190 / AR191 (Primary clinical personality scale narrative)
        if ($aq206 >= 60) {
            if ($aq212 >= 60) {
                $text .= "Sobre esta configuración nuclear se manifiesta, a la manera de un patrón clínico premórbido, ";
            } else {
                $text .= "El perfil del evaluado(a) refleja, como configuración principal del estilo básico de la personalidad, ";
            }
            
            if ($aq206 >= 85) {
                $text .= "un trastorno clínicamente significativo de la personalidad de tipo ";
            } elseif ($aq206 >= 75) {
                $text .= "un tipo de personalidad ";
            } else {
                $text .= "un estilo de personalidad ";
            }
            
            $desc_map = [
                '1' => "esquizoide. El evaluado(a) se caracteriza por su falta de deseo y su incapacidad para sentir placer o dolor intenso, se muestra indiferente ante las relaciones sociales y tiende a ser apático, distante y asocial; sus emociones y necesidades afectivas son mínimas y actúa como un observador pasivo, desligado del beneficio y del afecto que aportan las relaciones humanas, así como de los requerimientos de las mismas. ",
                '2A' => "evitativo. El evaluado(a) experimenta pocos refuerzos positivos procedentes de sí mismo o de los demás y está siempre alerta, preparado para distanciarse de las experiencias dolorosas o negativas de la vida; su estrategia adaptativa refleja miedo y desconfianza hacia los demás, en virtud de la cual mantiene una vigilancia constante para evitar que su anhelo de afecto resulte en la repetición del dolor y la angustia que ha experimentado con otras personas, de modo que, a pesar de sus deseos de relacionarse con los demás, ha aprendido que es mejor negar estos sentimientos y mantener la distancia interpersonal necesaria. ",
                '2B' => "melancólico. El evaluado(a) experimenta el dolor como un estado permanente en el que el placer ya no se considera posible y muestra un estilo de desesperanza ante las pérdidas importantes, todo lo cual configura una perspectiva sin esperanzas que puede estar determinada tanto por una predisposición biológica o química hacia el pesimismo y el desánimo como por la experiencia de un entorno sin interés. ",
                '3' => "dependiente. El evaluado(a) destaca por su falta de iniciativa y autonomía, habiendo aprendido no solo a recurrir a los demás para obtener afecto, cuidados y seguridad, sino también a esperar pasivamente a que sean ellos quienes lo dirijan; tiende a buscar relaciones en las que pueda apoyarse para conseguir afecto y orientación, a asumir un rol pasivo en las relaciones interpersonales, a aceptar las atenciones y el apoyo que pueda encontrar y a someterse voluntariamente a los deseos de los demás a fin de conservar su afecto. ",
                '4A' => "histriónico. El evaluado(a), al igual que los sujetos dependientes, recurre a los demás, pero maximiza la atención y los favores que recibe, manipulando los hechos de una forma superficial y entusiasta; su comportamiento social inteligente y a menudo ingenioso transmite confianza y seguridad en sí mismo, si bien, bajo esta apariencia, subyace el miedo a la autonomía real y la necesidad de recibir señales recurrentes de aceptación y aprobación casi constantemente. ",
                '4B' => "tempestuoso. El evaluado(a) se muestra muy alegre y animado, si bien su persistente euforia, entrometimiento y volubilidad pueden resultar irritantes para los demás; aunque apasionado y entusiasta, se aburre con demasiada facilidad y carece de los recursos y la regularidad necesarios para llevar a término sus objetivos y planes, todo lo cual da lugar a un patrón de conducta impredecible, de pensamiento disperso y de acciones y estados de ánimo impetuosos e impulsivos, interrumpidos por arrebatos de ira momentánea y ansiedad temerosa que, sin control, pueden derivar en una conducta más extrema, temeraria y errática y conducir, con bastante frecuencia, al agotamiento depresivo. ",
                '5' => "narcisista. El evaluado(a) destaca por su egocentrismo egotista, por sentir placer simplemente centrándose en sí mismo; sus sentimientos de superioridad pueden no estar basados en logros reales o maduros, si bien conserva un aire arrogante de seguridad en sí mismo y, sin pensarlo demasiado ni pretenderlo conscientemente, explota a los demás en beneficio propio, no necesitando logros reales o aprobación social para mantener su aire de esnobismo y superioridad pretenciosa, todo lo cual da lugar a una confianza extrema que hace que no se sienta motivado a implicarse en las interacciones propias de la vida social. ",
                '6A' => "antisocial. El evaluado(a) destaca por su desconfianza hacia los demás, su deseo de autonomía y su anhelo de venganza y recompensa por lo que considera injusticias del pasado; para contrarrestar el dolor y los estragos que prevé que le causen otras personas, se comporta de forma engañosa o comete actos ilegales en beneficio propio, es irresponsable e impulsivo y justifica estas cualidades porque considera que los demás son desleales y no se puede confiar en ellos, en tanto que su insensibilidad y crueldad constituyen sus únicos medios de evitar el abuso y la victimización. ",
                '6B' => "sádico. El evaluado(a), a diferencia de los sujetos antisociales, puede buscar placer y satisfacción personal humillando a otras personas y dejando a un lado sus derechos y sentimientos; por lo general es hostil y sumamente combativo y parece que las consecuencias destructivas de su conducta conflictiva, ofensiva y brutal le resultan indiferentes o satisfactorias; aunque puede encubrir sus tendencias más maliciosas y de búsqueda del poder con acciones o profesiones públicamente aceptadas, sus actos dominantes, hostiles y a menudo persecutorios lo delatan. ",
                '7' => "compulsivo. El evaluado(a) ha sido intimidado y coaccionado para que acepte las exigencias y decisiones que los demás le imponen, de modo que su prudencia, control y perfeccionismo derivan de un conflicto entre la hostilidad hacia los demás y el miedo a la desaprobación social; resuelve esta ambivalencia suprimiendo su resentimiento y exigiéndose mucho a sí mismo y exigiéndolo a los demás, en tanto que su disciplinada autocontención le permite controlar los sentimientos oposicionistas intensos, aunque ocultos, de lo cual resulta una pasividad manifiesta y una aparente sumisión pública. ",
                '8A' => "negativista. El evaluado(a) se debate entre aceptar las gratificaciones que los demás le ofrecen o perseguir sus propios deseos, vacilando entre la deferencia y el desafío y, a veces, entre la obediencia y la oposición agresiva, de modo que se enfrenta a interminables disputas y decepciones; esta batalla representa una incapacidad para resolver conflictos similar a la de los sujetos compulsivos, si bien sus conflictos persisten y permanecen cerca de la conciencia, en el contexto de una conducta caracterizada por un patrón errático de ira explosiva o resistencia completamente mezclado con periodos de culpa y vergüenza. ",
                '8B' => "masoquista. El evaluado(a) se relaciona con los demás de una forma servil y autosacrificada, les permite que abusen o se aprovechen de él e, incluso, en ocasiones, los alienta a hacerlo; cuando se muestran sus peores rasgos, puede llegar a sostener que merece ser avergonzado y humillado, y para agravar su dolor y angustia, que puede vivirlos como reconfortantes, rememora activa y reiteradamente sus desgracias del pasado, en tanto que ante situaciones afortunadas espera que el resultado sea problemático. "
            ];
            $text .= $desc_map[$aq205] ?? "";
        }
        
        // AR193 (Secondary clinical personality scale narrative)
        if ($aq208 >= 60) {
            $sec_range = "";
            if ($aq208 >= 85) {
                $sec_range = "rasgos propios de un trastorno clínicamente significativo de la personalidad de tipo ";
            } elseif ($aq208 >= 75) {
                $sec_range = "rasgos propios de un tipo de personalidad ";
            } else {
                $sec_range = "rasgos propios de un estilo de personalidad ";
            }
            
            $sec_name_map = [
                '1' => 'esquizoide, ', '2A' => 'evitativo, ', '2B' => 'melancólico, ', '3' => 'dependiente, ',
                '4A' => 'histriónico, ', '4B' => 'tempestuoso, ', '5' => 'narcisista, ', '6A' => 'antisocial, ',
                '6B' => 'sádico, ', '7' => 'compulsivo, ', '8A' => 'negativista, ', '8B' => 'masoquista, '
            ];
            
            $text .= "A este cuadro central se añaden, asimismo, " . $sec_range . ($sec_name_map[$aq207] ?? "") . "que se manifiestan en el evaluado(a) como ";
            
            $sec_desc_map = [
                '1' => "una falta de deseo y una incapacidad para sentir placer o dolor intenso, una indiferencia ante las relaciones sociales y una desvinculación afectiva propia de un observador pasivo. ",
                '2A' => "una vigilancia constante ante las experiencias dolorosas, un miedo y desconfianza hacia los demás y la negación de los deseos de relación para mantener la distancia interpersonal necesaria. ",
                '2B' => "la vivencia del dolor como un estado permanente en el que el placer ya no se considera posible y un estilo de desesperanza ante las pérdidas importantes. ",
                '3' => "una falta de iniciativa y autonomía, la búsqueda de figuras protectoras que orienten su conducta y la sumisión voluntaria a los deseos de los demás a fin de conservar su afecto. ",
                '4A' => "la búsqueda de la atención y los favores de los demás mediante una manipulación superficial y entusiasta de los hechos, una apariencia de confianza y seguridad bajo la cual subyace la necesidad de aceptación y aprobación constantes. ",
                '4B' => "una persistente euforia, entrometimiento y volubilidad, un entusiasmo apasionado que se aburre con facilidad y una conducta impredecible interrumpida por arrebatos de ira momentánea. ",
                '5' => "un egocentrismo egotista, un aire arrogante de seguridad en sí mismo y la explotación de los demás en beneficio propio, sostenidos por sentimientos de superioridad no siempre basados en logros reales. ",
                '6A' => "la desconfianza hacia los demás, el deseo de autonomía y la justificación de conductas engañosas en beneficio propio sobre la base de que los demás son desleales. ",
                '6B' => "la búsqueda de placer y satisfacción personal humillando a los demás, una hostilidad sumamente combativa y la indiferencia ante las consecuencias destructivas de su conducta. ",
                '7' => "una prudencia, control y perfeccionismo derivados del conflicto entre la hostilidad hacia los demás y el miedo a la desaprobación social, resuelto mediante la supresión del resentimiento y la disciplinada autocontención. ",
                '8A' => "la vacilación entre la deferencia y el desafío, las interminables disputas y decepciones y un patrón errático de ira explosiva o resistencia mezclado con periodos de culpa y vergüenza. ",
                '8B' => "una relación servil y autosacrificada con los demás, la sostenida convicción de merecer ser avergonzado y humillado y la rememoración activa y reiterada de las desgracias del pasado. "
            ];
            $text .= $sec_desc_map[$aq207] ?? "";
        }
        
        // AR195 (Tertiary clinical personality scale narrative)
        if ($aq212 < 60 && $aq210 >= 60) {
            $ter_range = "";
            if ($aq210 >= 85) {
                $ter_range = "manifestaciones propias de un trastorno clínicamente significativo de la personalidad de tipo ";
            } elseif ($aq210 >= 75) {
                $ter_range = "manifestaciones propias de un tipo de personalidad ";
            } else {
                $ter_range = "manifestaciones propias de un estilo de personalidad ";
            }
            
            $ter_name_map = [
                '1' => 'esquizoide, ', '2A' => 'evitativo, ', '2B' => 'melancólico, ', '3' => 'dependiente, ',
                '4A' => 'histriónico, ', '4B' => 'tempestuoso, ', '5' => 'narcisista, ', '6A' => 'antisocial, ',
                '6B' => 'sádico, ', '7' => 'compulsivo, ', '8A' => 'negativista, ', '8B' => 'masoquista, '
            ];
            
            $text .= "A los rasgos anteriores se asocian, asimismo, " . $ter_range . ($ter_name_map[$aq209] ?? "") . "que se concretan en el evaluado(a) como ";
            
            $ter_desc_map = [
                '1' => "una indiferencia ante las relaciones sociales y una desvinculación afectiva que aminoran la reactividad emocional general. ",
                '2A' => "la vigilancia constante ante las experiencias dolorosas y la negación de los deseos de relación para mantener la distancia interpersonal. ",
                '2B' => "la vivencia del dolor como un estado permanente y una perspectiva sin esperanzas frente a las pérdidas y los proyectos. ",
                '3' => "la falta de iniciativa y la búsqueda de figuras protectoras que orienten su conducta. ",
                '4A' => "la búsqueda de atención mediante una manipulación superficial y entusiasta de los hechos. ",
                '4B' => "la persistente euforia, el entrometimiento y la volubilidad que pueden derivar en arrebatos impulsivos. ",
                '5' => "el egocentrismo egotista y la explotación de los demás en beneficio propio. ",
                '6A' => "la desconfianza hacia los demás y la justificación de conductas engañosas en beneficio propio. ",
                '6B' => "la hostilidad combativa y la indiferencia ante las consecuencias destructivas de su conducta. ",
                '7' => "la prudencia, el control y el perfeccionismo derivados de la supresión del resentimiento. ",
                '8A' => "la vacilación entre la deferencia y el desafío y un patrón errático de ira explosiva o resistencia. ",
                '8B' => "la relación servil y autosacrificada con los demás y la rememoración reiterada de las desgracias del pasado. "
            ];
            $text .= $ter_desc_map[$aq209] ?? "";
        }
        
        return trim($text);
    }
    
    private function getFacetsReport($final_tbs, $percentiles, $facets_tb) {
        // Find top clinical personality scales
        $p_scales = [
            '1' => $final_tbs['1'] + $percentiles['1']/1000 + $final_tbs['1']/1000000,
            '2A' => $final_tbs['2A'] + $percentiles['2A']/1000 + $final_tbs['2A']/1000000,
            '2B' => $final_tbs['2B'] + $percentiles['2B']/1000 + $final_tbs['2B']/1000000,
            '3' => $final_tbs['3'] + $percentiles['3']/1000 + $final_tbs['3']/1000000,
            '4A' => $final_tbs['4A'] + $percentiles['4A']/1000 + $final_tbs['4A']/1000000,
            '4B' => $final_tbs['4B'] + $percentiles['4B']/1000 + $final_tbs['4B']/1000000,
            '5' => $final_tbs['5'] + $percentiles['5']/1000 + $final_tbs['5']/1000000,
            '6A' => $final_tbs['6A'] + $percentiles['6A']/1000 + $final_tbs['6A']/1000000,
            '6B' => $final_tbs['6B'] + $percentiles['6B']/1000 + $final_tbs['6B']/1000000,
            '7' => $final_tbs['7'] + $percentiles['7']/1000 + $final_tbs['7']/1000000,
            '8A' => $final_tbs['8A'] + $percentiles['8A']/1000 + $final_tbs['8A']/1000000,
            '8B' => $final_tbs['8B'] + $percentiles['8B']/1000 + $final_tbs['8B']/1000000
        ];
        arsort($p_scales);
        $top3_scales = array_slice(array_keys($p_scales), 0, 3);
        
        // Define facets mapping per scale
        $scale_facets = [
            '1' => ['1.1', '1.2', '1.3'],
            '2A' => ['2A.1', '2A.2', '2A.3'],
            '2B' => ['2B.1', '2B.2', '2B.3'],
            '3' => ['3.1', '3.2', '3.3'],
            '4A' => ['4A.1', '4A.2', '4A.3'],
            '4B' => ['4B.1', '4B.2', '4B.3'],
            '5' => ['5.1', '5.2', '5.3'],
            '6A' => ['6A.1', '6A.2', '6A.3'],
            '6B' => ['6B.1', '6B.2', '6B.3'],
            '7' => ['7.1', '7.2', '7.3'],
            '8A' => ['8A.1', '8A.2', '8A.3'],
            '8B' => ['8B.1', '8B.2', '8B.3']
        ];
        
        $candidate_facets = [];
        // Loop over the 3 highest personality scales
        for ($idx = 0; $idx < 3; $idx++) {
            $scale = $top3_scales[$idx];
            $scale_tb = $final_tbs[$scale];
            // Parent scale must have TB >= 60 to consider its facets
            if ($scale_tb >= 60) {
                $facs = $scale_facets[$scale] ?? [];
                // Ties resolved by small addition based on order: 1st scale gets +0.009 to +0.007, 2nd gets +0.006 to +0.004, etc.
                $base_tie_breaker = 0.009 - ($idx * 0.003);
                for ($j = 0; $j < 3; $j++) {
                    $facet = $facs[$j];
                    $pc = $percentiles[$facet] ?? 0;
                    $tb = $facets_tb[$facet] ?? 0;
                    if ($pc >= 75) {
                        $tie_breaker = $base_tie_breaker - ($j * 0.001);
                        $candidate_facets[$facet] = $tb + $tie_breaker;
                    }
                }
            }
        }
        
        $num_candidates = count($candidate_facets);
        if ($num_candidates < 1) {
            return "En el conjunto de las facetas de Grossman no se identifican puntuaciones que alcancen el umbral de significación clínica considerado; por consiguiente, el nivel más molecular del análisis de los dominios funcionales y estructurales no aporta, en este caso, información adicional relevante a la ya derivada de la interpretación de los patrones de personalidad.";
        }
        
        arsort($candidate_facets);
        $sorted_facets = array_keys($candidate_facets);
        $top4_facets = array_slice($sorted_facets, 0, 4);
        
        $intro = "Asimismo, mediante el análisis de las facetas de Grossman elevadas en las escalas de los patrones clínicos de la personalidad y de la patología grave de la personalidad, resulta posible identificar los dominios funcionales y estructurales más problemáticos o clínicamente significativos del evaluado(a), tales como la autoimagen, la expresión emocional o el comportamiento interpersonal. Un análisis detenido de dichas puntuaciones indica que las siguientes características figuran entre los rasgos más prominentes de su personalidad. ";
        
        $body = "";
        $prefix = ["Lo más destacable es ", "Asimismo sobresale ", "Es también digna de atención ", "Merece asimismo señalarse "];
        for ($i = 0; $i < count($top4_facets); $i++) {
            $f_code = $top4_facets[$i];
            $desc = $this->facets_info[$f_code] ?? "";
            if ($desc) {
                $body .= $prefix[$i] . $desc . ". ";
            }
        }
        
        $ending = "Los esfuerzos terapéuticos iniciales tenderán a producir resultados óptimos si se orientan a la modificación de estos rasgos de la personalidad.";
        
        return $intro . trim($body) . " " . $ending;
    }
    
    private function getSyndromesReport($final_tbs, $percentiles) {
        $syndromes = [
            'A' => $final_tbs['A'] + $percentiles['A']/1000 + $final_tbs['A']/1000000,
            'H' => $final_tbs['H'] + $percentiles['H']/1000 + $final_tbs['H']/1000000,
            'N' => $final_tbs['N'] + $percentiles['N']/1000 + $final_tbs['N']/1000000,
            'D' => $final_tbs['D'] + $percentiles['D']/1000 + $final_tbs['D']/1000000,
            'B' => $final_tbs['B'] + $percentiles['B']/1000 + $final_tbs['B']/1000000,
            'T' => $final_tbs['T'] + $percentiles['T']/1000 + $final_tbs['T']/1000000,
            'R' => $final_tbs['R'] + $percentiles['R']/1000 + $final_tbs['R']/1000000,
            'SS' => $final_tbs['SS'] + $percentiles['SS']/1000 + $final_tbs['SS']/1000000,
            'CC' => $final_tbs['CC'] + $percentiles['CC']/1000 + $final_tbs['CC']/1000000,
            'PP' => $final_tbs['PP'] + $percentiles['PP']/1000 + $final_tbs['PP']/1000000
        ];
        arsort($syndromes);
        $sorted_codes = array_keys($syndromes);
        
        $top3_codes = array_slice($sorted_codes, 0, 3);
        
        // Promotion logic: if any of the top 3 is severe (SS, CC, PP), promote the highest severe to 1st place
        $severe_syndromes = ['SS', 'CC', 'PP'];
        $promoted_code = $top3_codes[0];
        
        $severe_found = [];
        foreach ($top3_codes as $code) {
            if (in_array($code, $severe_syndromes)) {
                $severe_found[] = $code;
            }
        }
        
        if (count($severe_found) > 0) {
            // Find the one among severe_found with highest score (which is already ordered)
            $promoted_code = $severe_found[0];
        }
        
        $syndrome1_code = $promoted_code;
        $syndrome1_tb = $final_tbs[$syndrome1_code];
        
        // Find 2nd and 3rd remaining
        $remaining = [];
        foreach ($top3_codes as $code) {
            if ($code !== $promoted_code) {
                $remaining[] = $code;
            }
        }
        
        $syndrome2_code = $remaining[0] ?? "";
        $syndrome2_tb = ($syndrome2_code !== "") ? $final_tbs[$syndrome2_code] : 0;
        
        $syndrome3_code = $remaining[1] ?? "";
        $syndrome3_tb = ($syndrome3_code !== "") ? $final_tbs[$syndrome3_code] : 0;
        
        $text = "";
        
        // AR231 (Intro)
        if ($syndrome1_tb < 60) {
            return "En el perfil obtenido no se evidencian elevaciones en las escalas de síndromes; las tasas base se sitúan por debajo del rango interpretativo, por lo que no se identifican estados sintomáticos que requieran ser leídos como ampliaciones manifiestas del patrón premórbido.";
        } elseif ($syndrome1_tb < 75) {
            return "En el perfil obtenido las elevaciones en las escalas de síndromes se sitúan en el rango sugerente, es decir, entre tasas base 60 y 74; estas puntuaciones sugieren los síntomas patológicos de la escala correspondiente pero no son suficientemente indicativas de ellos, por lo que no se considera que el síndrome esté presente y no se desarrolla, por consiguiente, su descripción detallada.";
        } else {
            $text .= "En el perfil obtenido se identifican elevaciones en las escalas de síndromes clínicos cuya descripción se desarrolla a continuación, priorizando las elevaciones en las escalas de síndromes graves dado que, por su mayor vulnerabilidad clínica, pueden matizar el sentido de los restantes cuadros sintomáticos. ";
        }
        
        // AR232 (1st Syndrome)
        if ($syndrome1_tb >= 75) {
            $sig = ($syndrome1_tb >= 85) ? "significativa " : "";
            $end = ($syndrome1_tb >= 85) ? ", cuadro que refleja una afectación significativa del funcionamiento general del evaluado(a). " : ", cuadro cuya manifestación podría considerarse transitoria y no persistente, sin afectación significativa del funcionamiento general. ";
            $s_info = $this->syndromes_info[$syndrome1_code];
            $text .= "Se identifica una elevación " . $sig . "en la escala " . $s_info['name'] . ", que indica " . $s_info['desc'] . $end;
        }
        
        // AR233 (2nd Syndrome)
        if ($syndrome2_code !== "" && $syndrome2_tb >= 75) {
            $sig = ($syndrome2_tb >= 85) ? "significativa " : "";
            $end = ($syndrome2_tb >= 85) ? ", cuadro que refleja una afectación significativa del funcionamiento general del evaluado(a). " : ", cuadro cuya manifestación podría considerarse transitoria y no persistente, sin afectación significativa del funcionamiento general. ";
            $s_info = $this->syndromes_info[$syndrome2_code];
            $text .= "Se identifica, asimismo, una elevación " . $sig . "en la escala " . $s_info['name'] . ", que indica " . $s_info['desc'] . $end;
        }
        
        // AR234 (3rd Syndrome)
        if ($syndrome3_code !== "" && $syndrome3_tb >= 75) {
            $sig = ($syndrome3_tb >= 85) ? "significativa " : "";
            $end = ($syndrome3_tb >= 85) ? ", cuadro que refleja una afectación significativa del funcionamiento general del evaluado(a). " : ", cuadro cuya manifestación podría considerarse transitoria y no persistente, sin afectación significativa del funcionamiento general. ";
            $s_info = $this->syndromes_info[$syndrome3_code];
            $text .= "Se constata, además, una elevación " . $sig . "en la escala " . $s_info['name'] . ", que indica " . $s_info['desc'] . $end;
        }
        
        // AR235 (Double Depression)
        $has_cc = ($final_tbs['CC'] >= 75);
        $has_d = ($final_tbs['D'] >= 75);
        if ($has_cc && $has_d) {
            $text .= "La coelevación simultánea de las escalas Depresión mayor y Depresión persistente configura el cuadro clínicamente reconocido como doble depresión, situación cualitativa y cuantitativamente distinta a la presencia aislada de cualquiera de los dos síndromes y que conlleva vulnerabilidades específicas, en particular la tendencia a evitar o retrasar el tratamiento, en la medida en que el evaluado(a) puede llegar a aceptar el empeoramiento sintomático como inevitable. ";
        }
        
        // AR236 (Ending)
        $text .= "Estos síndromes reflejan y acentúan, por consiguiente, varios de los aspectos más persistentes y arraigados del patrón personológico básico del evaluado(a), de modo que su evolución dependerá tanto del manejo terapéutico inmediato de los síntomas como del abordaje de la configuración personológica subyacente.";
        
        return trim($text);
    }
}
