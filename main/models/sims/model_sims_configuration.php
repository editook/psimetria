<?php
class ModelSimsConfiguration
{
    private const REVERSE_KEYED_ITEMS = [7, 9, 19, 23, 46, 54, 55, 56, 58, 63, 72, 75];

    private const SCALE_DEFINITIONS = [
        [
            'code' => 'Dn',
            'name' => 'DETERIORO NEUROLÓGICO',
            'excel_label' => 'de deterioro neurológico',
            'items' => [1, 5, 74, 20, 26, 29, 35, 39, 44, 50, 54, 59, 64, 66, 71],
            'cutoff' => 4,
            'atypical_false' => [54],
            'below_message' => 'indica que no presenta indicios de simulación de sintomatología neurológica. Las respuestas proporcionadas no reflejan un patrón de síntomas ilógicos, inconsistentes o extremadamente infrecuentes en cuadros neurológicos genuinos. La puntuación obtenida se encuentra dentro del rango en el que los ítems respondidos no evidencian la presencia de manifestaciones atípicas que caracterizan la simulación en esta dimensión.',
            'elevated_message' => 'indica que presenta una puntuación indicativa de simulación de deterioro neurológico. Ha respondido afirmativamente a un número elevado de ítems que describen síntomas ilógicos, inconsistentes con los cuadros neurológicos genuinos o inusuales en pacientes con afectación neurológica real. La puntuación obtenida supera el punto de corte establecido para la detección de simulación en esta escala, lo que implica la presencia de respuestas que reflejan un patrón característico de sobreinformación o distorsión en la presentación de síntomas neurológicos.',
        ],
        [
            'code' => 'Am',
            'name' => 'AMNÉSIA',
            'excel_label' => 'de trastornos amnésicos',
            'items' => [18, 61, 53, 49, 45, 40, 36, 33, 30, 27, 25, 22, 15, 12, 9],
            'cutoff' => 4,
            'atypical_false' => [9],
            'below_message' => 'indica que no presenta indicios de simulación de alteraciones en la memoria. Las respuestas proporcionadas no reflejan un patrón de síntomas inconsistentes con los cuadros amnésicos genuinos ni la presencia de manifestaciones atípicas en la naturaleza, curso o aparición de los déficits de memoria. La puntuación obtenida se encuentra dentro del rango en el que los ítems respondidos no evidencian distorsión en la presentación de síntomas amnésicos.',
            'elevated_message' => 'indica que presenta una puntuación indicativa de simulación de trastornos amnésicos. Ha respondido afirmativamente a un número elevado de ítems que describen síntomas inconsistentes con los patrones de deterioro de la memoria observados en casos de disfunción o daño cerebral real. La puntuación obtenida supera el punto de corte establecido para la detección de simulación en esta escala, lo que implica la presencia de respuestas que reflejan un patrón característico de sobreinformación o distorsión en la presentación de déficits de memoria.',
        ],
        [
            'code' => 'Af',
            'name' => 'TRASTORNOS AFECTIVOS',
            'excel_label' => 'de trastornos afectivos',
            'items' => [72, 60, 55, 52, 47, 43, 37, 32, 24, 23, 19, 17, 16, 6, 2],
            'cutoff' => 8,
            'atypical_false' => [72, 55, 23],
            'below_message' => 'indica que no presenta indicios de simulación de síntomas afectivos. Las respuestas proporcionadas no reflejan un patrón de síntomas atípicos de depresión o ansiedad que resulten infrecuentes incluso en pacientes con trastornos afectivos genuinos. La puntuación obtenida se encuentra dentro del rango en el que los ítems respondidos no evidencian distorsión en la presentación de sintomatología afectiva.',
            'elevated_message' => 'indica que presenta una puntuación indicativa de simulación de síntomas afectivos. Ha respondido afirmativamente a un número elevado de ítems que describen manifestaciones emocionales inusuales o extremadamente infrecuentes en pacientes con ansiedad o depresión genuina. La puntuación obtenida supera el punto de corte establecido para la detección de simulación en esta escala, lo que implica la presencia de respuestas que reflejan un patrón característico de sobreinformación o distorsión en la presentación de sintomatología afectiva.',
        ],
        [
            'code' => 'Ps',
            'name' => 'PSICOSIS',
            'excel_label' => 'psicoticos',
            'items' => [3, 8, 10, 13, 28, 31, 34, 38, 42, 48, 51, 57, 62, 65, 69],
            'cutoff' => 3,
            'atypical_false' => [],
            'below_message' => 'indica que no presenta indicios de simulación de sintomatología psicótica. Las respuestas proporcionadas no reflejan un patrón de síntomas extravagantes, ilógicos o infrecuentes en cuadros psicóticos genuinos. La puntuación obtenida se encuentra dentro del rango en el que los ítems respondidos no evidencian la presencia de manifestaciones atípicas que caracterizan la simulación en esta dimensión.',
            'elevated_message' => 'indica que presenta una puntuación indicativa de simulación de psicosis. Ha respondido afirmativamente a un número elevado de ítems que describen síntomas extravagantes, ilógicos e inusuales en cuadros psicóticos genuinos. La puntuación obtenida supera el punto de corte establecido para la detección de simulación en esta escala, lo que implica la presencia de respuestas que reflejan un patrón característico de sobreinformación o distorsión en la presentación de síntomas psicóticos.',
        ],


        [
            'code' => 'Bi',
            'name' => 'BAJA INTELIGENCIA',
            'excel_label' => 'de baja inteligencia',
            'items' => [75, 73, 70, 68, 67, 63, 58, 56, 46, 41, 21, 14, 11, 7, 4],
            'cutoff' => 4,
            'atypical_false' => [75, 63, 58, 56, 46, 7],
            'below_message' => 'indica que no presenta indicios de simulación de discapacidad intelectual. Las respuestas proporcionadas no reflejan un patrón de errores sistemáticos en ítems que evalúan conocimientos básicos ni evidencian una distorsión en la presentación de déficits cognitivos generales. La puntuación obtenida se encuentra dentro del rango en el que los ítems respondidos no corresponden con patrones de simulación en esta dimensión.',
            'elevated_message' => 'indica que presenta una puntuación indicativa de simulación de discapacidad intelectual. Ha respondido incorrectamente a un número elevado de ítems que evalúan conocimientos básicos, los cuales incluso individuos con déficits intelectuales genuinos suelen responder correctamente. La puntuación obtenida supera el punto de corte establecido para la detección de simulación en esta escala, lo que implica la presencia de respuestas que reflejan un patrón característico de sobreinformación o distorsión en la presentación de una discapacidad cognitiva.',
        ],

    ];

    /**
     * Calcula puntuaciones y respuestas llamativas siguiendo las hojas
     * Ingreso_Datos y Perfil del libro SIMS 3_2.xlsm.
     */
    public function calculate(array $answers): array
    {
        $responses = [];
        $questions = [];

        foreach ($answers as $answer) {
            if (!isset($answer['item_order'])) {
                continue;
            }

            $item = (int) $answer['item_order'];
            $rawResponse = $answer['response'] ?? null;
            $responses[$item] = in_array((string) $rawResponse, ['0', '1'], true)
                ? (int) $rawResponse
                : null;
            $questions[$item] = $answer['question'] ?? '';
        }

        $scales = [];
        $flagged = [];
        $total = 0;
        $answeredCount = 0;

        foreach (range(1, 75) as $item) {
            if (isset($responses[$item]) && $responses[$item] !== null) {
                $answeredCount++;
            }
        }

        foreach (self::SCALE_DEFINITIONS as $definition) {
            $score = 0;
            $falseFlaggedItems = $definition['atypical_false'];

            foreach ($definition['items'] as $item) {
                $response = $responses[$item] ?? null;
                if ($response !== null) {
                    $score += in_array($item, self::REVERSE_KEYED_ITEMS, true)
                        ? 1 - $response
                        : $response;
                }

                $expectedAtypicalResponse = in_array($item, $falseFlaggedItems, true) ? 0 : 1;
                if ($response === null || $response === $expectedAtypicalResponse) {
                    $flagged[] = [
                        'scale_code' => $definition['code'],
                        'scale_name' => $definition['name'],
                        'item' => $item,
                        'question' => $questions[$item] ?? '',
                        'response' => $response === null ? null : ($response === 1 ? 'Verdadero' : 'Falso'),
                        'omitted' => $response === null,
                    ];
                }
            }

            $scale = $definition;
            $scale['score'] = $score;
            $scale['elevated'] = $score >= $definition['cutoff'];
            $scale['interpretation'] = $scale['elevated']
                ? $definition['elevated_message']
                : $definition['below_message'];
            unset($scale['items'], $scale['atypical_false']);
            $scales[] = $scale;
            $total += $score;
        }

        $elevatedScales = array_values(array_filter($scales, function ($scale) {
            return $scale['elevated'];
        }));

        usort($elevatedScales, function ($left, $right) {
            return $right['score'] <=> $left['score'];
        });

        return [
            'scales' => $scales,
            'elevated_scales' => $elevatedScales,
            'flags' => $flagged,
            'total' => $total,
            'total_cutoff' => 16,
            'total_elevated' => $total >= 17,
            'answered_count' => $answeredCount,
            'item_count' => 75,
        ];
    }
}
