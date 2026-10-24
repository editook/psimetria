<?php
class ModelSimsConfiguration
{
    private const REVERSE_KEYED_ITEMS = [7, 9, 19, 23, 46, 54, 55, 56, 58, 63, 72, 75];

    private const SCALE_DEFINITIONS = [
        [
            'code' => 'Ps',
            'name' => 'Psicosis',
            'items' => [3, 8, 10, 13, 28, 31, 34, 38, 42, 48, 51, 57, 62, 65, 69],
            'cutoff' => 3,
            'atypical_false' => [],
            'below_message' => 'Las respuestas de esta dimensión se mantienen bajo el punto de corte para síntomas psicóticos atípicos, ilógicos o infrecuentes.',
            'elevated_message' => 'La puntuación supera el punto de corte de esta dimensión y coincide con respuestas afirmativas a síntomas psicóticos extravagantes, ilógicos o inusuales. El resultado requiere una evaluación más amplia.',
        ],
        [
            'code' => 'Dn',
            'name' => 'Deterioro neurológico',
            'items' => [1, 5, 74, 20, 26, 29, 35, 39, 44, 50, 54, 59, 64, 66, 71],
            'cutoff' => 4,
            'atypical_false' => [54],
            'below_message' => 'La puntuación se mantiene bajo el punto de corte para respuestas atípicas relacionadas con deterioro neurológico.',
            'elevated_message' => 'La puntuación supera el punto de corte y coincide con respuestas asociadas a síntomas neurológicos ilógicos o inconsistentes con cuadros genuinos. Se recomienda ampliar la evaluación.',
        ],
        [
            'code' => 'Am',
            'name' => 'Trastornos amnésicos',
            'items' => [18, 61, 53, 49, 45, 40, 36, 33, 30, 27, 25, 22, 15, 12, 9],
            'cutoff' => 4,
            'atypical_false' => [9],
            'below_message' => 'La puntuación se mantiene bajo el punto de corte para respuestas atípicas relacionadas con alteraciones de la memoria.',
            'elevated_message' => 'La puntuación supera el punto de corte y coincide con respuestas asociadas a síntomas amnésicos inconsistentes con patrones habituales de deterioro de memoria. Se recomienda ampliar la evaluación.',
        ],
        [
            'code' => 'Bi',
            'name' => 'Baja inteligencia',
            'items' => [75, 73, 70, 68, 67, 63, 58, 56, 46, 41, 21, 14, 11, 7, 4],
            'cutoff' => 4,
            'atypical_false' => [75, 63, 58, 56, 46, 7],
            'below_message' => 'La puntuación se mantiene bajo el punto de corte para errores atípicos en conocimientos básicos y respuestas asociadas a baja inteligencia.',
            'elevated_message' => 'La puntuación supera el punto de corte y coincide con respuestas incorrectas a ítems de conocimientos básicos que suelen responderse correctamente. Se recomienda ampliar la evaluación.',
        ],
        [
            'code' => 'Af',
            'name' => 'Trastornos afectivos',
            'items' => [72, 60, 55, 52, 47, 43, 37, 32, 24, 23, 19, 17, 16, 6, 2],
            'cutoff' => 8,
            'atypical_false' => [72, 55, 23],
            'below_message' => 'La puntuación se mantiene bajo el punto de corte para síntomas afectivos atípicos o extremadamente infrecuentes.',
            'elevated_message' => 'La puntuación supera el punto de corte y coincide con respuestas asociadas a manifestaciones afectivas inusuales o extremadamente infrecuentes. Se recomienda ampliar la evaluación.',
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
