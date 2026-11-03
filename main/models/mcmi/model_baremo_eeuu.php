<?php
class ModelBaremoEeuu
{
    public function getValue1($index) {
        $valores = [0, 9, 17, 25, 34, 43, 52, 60, 62, 64, 66, 69, 71, 73, 75, 76, 78, 79, 81, 82, 84, 85, 100, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil1($index) {
        $valores = [3, 7, 7, 8, 8, 8, 9, 9, 9, 10, 12, 12, 12, 12, 13, 13, 13, 16, 19, 20, 20, 20, 21, 21, 21, 23, 25, 26, 26, 26, 26, 26, 26, 26, 29, 31, 31, 32, 32, 32, 32, 32, 32, 35, 38, 38, 38, 38, 39, 39, 39, 39, 41, 44, 44, 44, 44, 44, 45, 45, 47, 50, 53, 55, 58, 61, 64, 67, 68, 70, 73, 76, 78, 80, 82, 84, 87, 89, 91, 93, 94, 85, 97, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue2A($index) {
        $valores = [0, 9, 17, 25, 34, 43, 52, 60, 65, 70, 75, 76, 77, 78, 79, 81, 82, 83, 84, 85, 91, 97, 10, 109, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil2A($index) {
        $valores = [3, 7, 7, 7, 8, 8, 8, 8, 9, 11, 14, 14, 15, 15, 16, 16, 17, 19, 21, 21, 22, 22, 23, 23, 24, 27, 28, 29, 29, 30, 30, 30, 30, 31, 33, 34, 35, 35, 35, 35, 35, 36, 37, 39, 40, 40, 40, 40, 40, 41, 41, 43, 44, 45, 45, 45, 46, 46, 47, 48, 49, 50, 51, 51, 52, 53, 54, 54, 55, 56, 58, 59, 60, 61, 63, 67, 71, 75, 78, 81, 84, 86, 88, 89, 90, 91, 91, 92, 92, 93, 93, 94, 94, 94, 95, 95, 95, 96, 96, 96, 96, 97, 97, 97, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue2B($index) {
        $valores = [0, 8, 15, 22, 29, 37, 45, 53, 60, 65, 70, 75, 76, 77, 78, 79, 79, 80, 80, 81, 82, 83, 84, 85, 91, 97, 103, 109, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil2B($index) {
        $valores = [3, 6, 7, 8, 8, 8, 8, 9, 10, 13, 13, 13, 14, 15, 16, 18, 20, 21, 21, 21, 22, 22, 24, 26, 26, 27, 27, 27, 28, 30, 31, 32, 32, 32, 32, 33, 33, 35, 36, 37, 37, 37, 38, 38, 39, 40, 41, 41, 41, 42, 42, 43, 44, 45, 46, 46, 47, 47, 47, 48, 49, 50, 50, 51, 52, 53, 53, 54, 54, 55, 57, 59, 60, 63, 67, 71, 76, 80, 84, 86, 88, 89, 90, 90, 91, 91, 92, 92, 93, 93, 93, 94, 94, 94, 95, 95, 95, 96, 96, 96, 97, 97, 97, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue3($index) {
        $valores = [0, 10, 20, 30, 40, 50, 60, 64, 68, 72, 75, 76, 78, 79, 81, 82, 84, 85, 90, 95, 100, 105, 110, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil3($index) {
        $valores = [1, 6, 7, 7, 8, 8, 8, 8, 8, 8, 11, 13, 14, 14, 14, 15, 15, 15, 15, 15, 19, 23, 24, 24, 24, 24, 24, 24, 24, 24, 27, 31, 31, 32, 32, 32, 32, 32, 32, 32, 36, 40, 40, 40, 40, 40, 40, 40, 40, 40, 43, 46, 46, 46, 46, 46, 46, 47, 47, 47, 50, 52, 53, 53, 56, 59, 60, 60, 63, 65, 66, 66, 69, 71, 72, 74, 77, 79, 82, 85, 87, 88, 90, 92, 92, 93, 94, 94, 94, 94, 95, 95, 95, 96, 96, 96, 97, 97, 97, 97, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue4A($index) {
        $valores = [0, 6, 11, 16, 21, 26, 31, 37, 43, 49, 54, 60, 62, 65, 67, 69, 72, 75, 77, 80, 83, 85, 90, 95, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil4A($index) {
        $valores = [1, 2, 2, 2, 2, 2, 3, 4, 4, 4, 4, 6, 8, 8, 8, 8, 10, 12, 12, 12, 12, 14, 16, 16, 16, 17, 18, 20, 21, 21, 21, 23, 25, 25, 25, 26, 26, 28, 31, 31, 31, 31, 31, 33, 34, 35, 35, 35, 35, 37, 39, 39, 39, 40, 42, 44, 44, 45, 45, 45, 48, 50, 53, 55, 55, 58, 60, 63, 65, 69, 72, 73, 76, 79, 79, 81, 83, 85, 87, 88, 90, 92, 92, 94, 95, 96, 97, 97, 97, 97, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue4B($index) {
        $valores = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60, 61, 63, 65, 67, 68, 69, 71, 73, 74, 75, 78, 82, 85, 93, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil4B($index) {
        $valores = [2, 4, 4, 4, 4, 4, 6, 8, 8, 8, 8, 9, 11, 12, 13, 13, 13, 13, 15, 17, 18, 18, 18, 18, 20, 22, 22, 22, 22, 23, 25, 26, 26, 27, 27, 27, 28, 30, 30, 30, 31, 31, 33, 35, 36, 36, 36, 36, 38, 40, 40, 40, 41, 41, 42, 44, 44, 44, 45, 45, 47, 50, 52, 55, 57, 59, 61, 63, 66, 70, 72, 74, 77, 79, 83, 87, 88, 88, 90, 91, 91, 92, 93, 95, 95, 96, 97, 98, 98, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue5($index) {
        $valores = [0, 12, 24, 36, 48, 60, 62, 65, 67, 69, 72, 75, 77, 79, 81, 83, 85, 88, 92, 95, 99, 102, 106, 109, 111, 113, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil5($index) {
        $valores = [3, 7, 8, 8, 9, 9, 9, 9, 9, 9, 9, 9, 12, 14, 14, 14, 14, 14, 14, 15, 15, 15, 15, 15, 19, 24, 24, 25, 25, 25, 26, 26, 26, 26, 26, 26, 30, 33, 33, 34, 34, 34, 34, 34, 34, 34, 34, 34, 38, 43, 43, 43, 44, 44, 44, 44, 44, 44, 44, 45, 48, 52, 55, 59, 59, 63, 66, 69, 72, 74, 77, 78, 80, 82, 82, 84, 86, 88, 90, 91, 92, 94, 94, 95, 96, 96, 97, 97, 97, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue6A($index) {
        $valores = [0, 20, 40, 60, 62, 64, 66, 69, 71, 73, 75, 77, 79, 81, 83, 85, 90, 95, 100, 105, 110, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil6A($index) {
        $valores = [6, 12, 12, 13, 13, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 14, 19, 24, 25, 25, 26, 26, 26, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 28, 32, 36, 37, 37, 37, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 39, 43, 47, 51, 55, 58, 62, 65, 68, 69, 72, 75, 78, 81, 84, 86, 87, 89, 90, 92, 93, 94, 94, 95, 96, 96, 97, 97, 97, 97, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue6B($index) {
        $valores = [0, 15, 30, 45, 60, 61, 63, 65, 67, 69, 71, 73, 74, 75, 77, 79, 81, 83, 85, 92, 99, 106, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil6B($index) {
        $valores = [5, 11, 13, 14, 15, 16, 16, 16, 16, 16, 17, 17, 17, 17, 17, 19, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 22, 28, 33, 33, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 38, 41, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 43, 47, 54, 57, 61, 64, 67, 70, 72, 75, 77, 79, 81, 83, 86, 89, 91, 92, 93, 95, 96, 97, 97, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue7($index) {
        $valores = [0, 4, 8, 13, 17, 21, 26, 30, 34, 39, 43, 47, 52, 56, 60, 62, 65, 67, 69, 72, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil7($index) {
        $valores = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 4, 4, 5, 6, 6, 7, 9, 9, 9, 10, 12, 12, 12, 12, 14, 16, 17, 17, 19, 21, 21, 21, 24, 26, 27, 27, 28, 30, 32, 32, 33, 36, 39, 40, 41, 44, 46, 51, 55, 56, 58, 61, 65, 70, 72, 74, 74, 79, 83, 84, 85, 87, 87, 87, 87, 91, 94, 94, 95, 95, 95, 96, 96, 96, 96, 96, 96, 96, 96, 96, 96, 96, 96, 96, 96, 98];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue8A($index) {
        $valores = [0, 10, 20, 30, 40, 50, 60, 62, 65, 67, 69, 72, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 92, 99, 106, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil8A($index) {
        $valores = [3, 8, 9, 10, 11, 11, 12, 12, 12, 12, 15, 17, 17, 18, 18, 18, 18, 18, 18, 18, 21, 24, 25, 25, 25, 26, 26, 26, 26, 26, 28, 31, 31, 31, 31, 31, 31, 31, 31, 31, 34, 37, 37, 37, 37, 37, 37, 37, 37, 37, 40, 43, 43, 43, 43, 43, 43, 43, 43, 43, 45, 47, 50, 53, 53, 55, 58, 60, 62, 65, 67, 67, 69, 71, 72, 74, 78, 82, 85, 89, 90, 94, 95, 97, 97, 98, 98, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValue8B($index) {
        $valores = [0, 12, 24, 36, 48, 60, 62, 65, 67, 69, 72, 75, 76, 77, 78, 79, 80, 80, 81, 82, 83, 84, 85, 95, 105, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentil8B($index) {
        $valores = [4, 9, 10, 10, 11, 11, 11, 11, 11, 11, 12, 13, 16, 19, 19, 20, 20, 20, 20, 21, 21, 21, 22, 22, 25, 27, 27, 28, 28, 28, 29, 29, 29, 30, 31, 31, 31, 31, 31, 31, 31, 31, 31, 34, 37, 37, 37, 37, 37, 37, 37, 37, 37, 40, 43, 43, 43, 43, 43, 43, 43, 43, 43, 45, 47, 50, 53, 53, 55, 58, 60, 62, 65, 67, 67, 69, 71, 72, 74, 78, 82, 85, 89, 90, 94, 95, 97, 97, 98, 98, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueS($index) {
        $valores = [0, 12, 24, 36, 48, 60, 61, 63, 65, 66, 67, 68, 69, 71, 73, 74, 75, 76, 77, 78, 79, 81, 82, 83, 84, 85, 92, 99, 106, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilS($index) {
        $valores = [4, 10, 11, 13, 13, 13, 13, 13, 13, 13, 14, 14, 17, 20, 21, 21, 21, 21, 21, 21, 21, 21, 21, 22, 25, 28, 28, 28, 28, 29, 29, 29, 29, 29, 29, 30, 33, 35, 35, 35, 36, 36, 36, 36, 36, 36, 37, 38, 40, 41, 41, 41, 41, 41, 41, 41, 42, 42, 43, 45, 49, 53, 55, 58, 62, 65, 70, 73, 76, 78, 80, 83, 85, 88, 90, 91, 93, 95, 96, 97, 98, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueC($index) {
        $valores = [0, 10, 20, 30, 40, 50, 60, 63, 66, 69, 72, 75, 76, 77, 78, 79, 81, 82, 83, 84, 85, 89, 94, 98, 102, 106, 111, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilC($index) {
        $valores = [6, 13, 15, 16, 17, 17, 17, 17, 18, 18, 21, 24, 24, 25, 25, 25, 25, 25, 25, 26, 28, 31, 31, 31, 31, 31, 32, 32, 32, 33, 35, 36, 36, 36, 36, 36, 37, 37, 38, 39, 41, 42, 42, 42, 42, 42, 43, 43, 44, 44, 46, 47, 47, 47, 47, 47, 48, 48, 49, 50, 52, 54, 55, 57, 58, 60, 61, 63, 65, 66, 68, 70, 72, 75, 79, 82, 85, 88, 90, 92, 93, 94, 94, 95, 95, 96, 96, 97, 97, 97, 97, 97, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueP($index) {
        $valores = [0, 15, 30, 45, 60, 62, 64, 66, 69, 71, 73, 75, 76, 78, 79, 80, 81, 82, 84, 85, 91, 97, 103, 109, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilP($index) {
        $valores = [7, 16, 19, 20, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 24, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 27, 33, 38, 38, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 41, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 47, 51, 54, 58, 61, 64, 67, 69, 70, 71, 73, 75, 77, 79, 81, 83, 86, 87, 89, 91, 93, 95, 96, 97, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueA($index) {
        $valores = [0, 15, 30, 45, 60, 75, 77, 80, 83, 85, 88, 91, 94, 97, 100, 103, 106, 109, 112, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilA($index) {
        $valores = [5, 10, 12, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 13, 16, 20, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 25, 29, 29, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 33, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 40, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 48, 52, 55, 57, 58, 60, 64, 64, 67, 70, 73, 74, 75, 77, 79, 80, 81, 83, 84, 86, 87, 88, 90, 91, 91, 92, 94, 94, 95, 96, 97, 97, 98, 98, 98, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueH($index) {
        $valores = [0, 10, 20, 30, 40, 50, 60, 64, 68, 72, 75, 78, 82, 85, 100, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilH($index) {
        $valores = [7, 15, 16, 17, 17, 17, 17, 17, 17, 17, 19, 22, 23, 24, 24, 24, 24, 24, 24, 24, 27, 30, 30, 31, 31, 31, 31, 31, 31, 31, 34, 37, 37, 37, 37, 37, 38, 38, 38, 38, 40, 42, 42, 42, 42, 42, 42, 42, 42, 42, 44, 46, 47, 47, 47, 47, 47, 47, 47, 47, 50, 53, 53, 53, 56, 59, 59, 59, 62, 65, 66, 66, 69, 72, 73, 76, 78, 79, 83, 85, 86, 87, 89, 92, 93, 95, 96, 96, 96, 96, 96, 96, 96, 96, 96, 96, 96, 96, 96, 97, 98, 98, 98, 98, 98, 98, 98, 98, 98, 98, 98, 98, 98, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueN($index) {
        $valores = [0, 12, 24, 36, 48, 60, 63, 66, 69, 72, 75, 78, 82, 85, 90, 95, 100, 105, 110, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilN($index) {
        $valores = [1, 3, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5, 8, 11, 11, 12, 12, 12, 12, 12, 12, 12, 12, 12, 15, 19, 20, 20, 20, 21, 21, 21, 21, 21, 21, 21, 25, 29, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 34, 37, 37, 38, 38, 38, 38, 38, 38, 38, 38, 38, 43, 48, 49, 53, 56, 56, 59, 63, 63, 66, 70, 70, 73, 76, 77, 79, 81, 81, 84, 85, 86, 86, 88, 89, 90, 91, 92, 92, 92, 93, 94, 95, 95, 95, 96, 96, 97, 97, 97, 97, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueD($index) {
        $valores = [0, 7, 14, 20, 26, 33, 40, 47, 54, 60, 61, 63, 65, 67, 69, 71, 73, 74, 75, 77, 80, 83, 85, 91, 97, 103, 109, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilD($index) {
        $valores = [4, 8, 9, 10, 10, 10, 10, 12, 15, 16, 17, 17, 17, 17, 20, 22, 23, 23, 23, 23, 25, 27, 27, 27, 27, 27, 29, 31, 31, 31, 31, 31, 31, 32, 34, 34, 34, 34, 34, 34, 36, 38, 38, 38, 38, 38, 38, 41, 43, 43, 43, 43, 43, 43, 45, 46, 46, 46, 46, 46, 48, 52, 54, 55, 57, 58, 59, 61, 62, 64, 65, 66, 68, 70, 73, 75, 77, 78, 79, 79, 81, 82, 83, 84, 85, 87, 88, 88, 88, 88, 89, 90, 91, 91, 91, 91, 92, 93, 94, 94, 94, 94, 95, 96, 96, 96, 96, 97, 97, 98, 98, 98, 98, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueB($index) {
        $valores = [0, 60, 68, 75, 78, 82, 85, 89, 94, 98, 102, 106, 111, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilB($index) {
        $valores = [14, 29, 32, 33, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 35, 35, 36, 48, 60, 61, 61, 61, 61, 62, 63, 70, 76, 76, 76, 76, 77, 78, 81, 84, 85, 87, 89, 89, 90, 91, 92, 92, 93, 93, 94, 94, 95, 95, 95, 95, 95, 96, 96, 96, 97, 97, 97, 97, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueT($index) {
        $valores = [0, 60, 62, 65, 67, 69, 72, 75, 77, 80, 83, 85, 89, 94, 98, 102, 106, 111, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilT($index) {
        $valores = [10, 22, 23, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 24, 26, 36, 48, 56, 63, 64, 68, 72, 74, 77, 78, 80, 80, 81, 82, 82, 83, 84, 85, 86, 86, 87, 88, 88, 89, 90, 90, 91, 91, 91, 91, 92, 92, 92, 92, 93, 94, 94, 94, 95, 95, 95, 95, 96, 97, 97, 97, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueR($index) {
        $valores = [0, 20, 40, 60, 62, 64, 66, 69, 71, 73, 75, 78, 82, 85, 90, 95, 100, 105, 110, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilR($index) {
        $valores = [8, 16, 19, 20, 20, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 21, 26, 32, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 33, 38, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 44, 48, 52, 56, 59, 61, 64, 66, 68, 69, 70, 72, 74, 76, 78, 80, 81, 82, 82, 83, 84, 84, 84, 84, 86, 87, 87, 89, 90, 90, 90, 90, 91, 92, 92, 92, 92, 93, 94, 94, 95, 95, 96, 97, 97, 97, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueSS($index) {
        $valores = [0, 9, 17, 25, 34, 43, 52, 60, 61, 63, 64, 65, 66, 67, 68, 69, 71, 73, 74, 75, 77, 80, 83, 85, 92, 99, 106, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilSS($index) {
        $valores = [3, 7, 9, 10, 10, 11, 11, 11, 11, 13, 16, 17, 17, 17, 18, 18, 18, 20, 23, 23, 23, 23, 23, 23, 23, 26, 29, 29, 29, 29, 29, 29, 29, 29, 31, 34, 34, 34, 34, 34, 34, 34, 34, 38, 41, 42, 42, 42, 42, 42, 42, 42, 44, 47, 47, 47, 47, 47, 47, 47, 50, 56, 59, 62, 68, 72, 77, 81, 84, 87, 88, 90, 91, 92, 94, 95, 96, 96, 97, 97, 97, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueCC($index) {
        $valores = [0, 12, 24, 36, 48, 60, 64, 68, 72, 75, 77, 79, 80, 81, 83, 85, 88, 92, 95, 99, 102, 106, 109, 112, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilCC($index) {
        $valores = [7, 15, 17, 18, 18, 18, 18, 18, 18, 18, 18, 18, 21, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25, 25, 28, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 35, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 38, 41, 43, 43, 43, 43, 43, 44, 44, 44, 44, 44, 44, 46, 48, 48, 49, 51, 53, 53, 53, 55, 56, 56, 56, 58, 60, 60, 61, 63, 65, 66, 68, 71, 73, 75, 76, 77, 78, 79, 80, 81, 82, 82, 83, 84, 85, 86, 87, 88, 89, 89, 91, 92, 92, 93, 94, 94, 95, 96, 97, 98, 98, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValuePP($index) {
        $valores = [0, 62, 62, 64, 66, 68, 70, 72, 74, 75, 76, 78, 79, 81, 82, 84, 85, 95, 105, 115];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilPP($index) {
        $valores = [13, 28, 31, 33, 33, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 45, 56, 63, 70, 74, 79, 81, 84, 85, 87, 89, 90, 91, 92, 94, 95, 96, 96, 97, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueX($index) {
        $valores = [0, 0, 0, 0, 0, 0, 0, 0, 2, 5, 7, 10, 12, 15, 17, 19, 21, 23, 25, 28, 30, 33, 35, 37, 39, 41, 43, 45, 46, 47, 48, 49, 50, 52, 54, 56, 58, 60, 61, 62, 63, 64, 65, 66, 67, 68, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 79, 80, 80, 81, 81, 82, 83, 84, 85, 86, 86, 87, 87, 87, 87, 88, 88, 88, 89, 89, 89, 90, 90, 90, 91, 91, 91, 92, 92, 93, 93, 94, 94, 95, 95, 96, 96, 96, 97, 97, 98, 98, 99, 99, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilX($index) {
        $valores = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 33, 0, 0, 47, 0, 69, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueY($index) {
        $valores = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 63, 66, 69, 72, 75, 78, 81, 85, 89, 93, 97, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilY($index) {
        $valores = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 43, 0, 0, 60, 0, 81, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getValueZ($index) {
        $valores = [0, 35, 38, 41, 44, 47, 50, 53, 56, 60, 62, 64, 66, 68, 70, 72, 74, 75, 77, 79, 80, 81, 83, 85, 88, 91, 93, 95, 97, 100, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilZ($index) {
        $valores = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 30, 0, 0, 60, 0, 68, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet1_1($index) {
        $valores = [8, 23, 38, 53, 66, 77, 86, 93, 97, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet1_1($index) {
        $valores = [0, 30, 60, 64, 68, 72, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet1_2($index) {
        $valores = [7, 20, 33, 46, 57, 67, 76, 85, 92, 98];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet1_2($index) {
        $valores = [0, 20, 40, 60, 64, 68, 72, 75, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet1_3($index) {
        $valores = [10, 29, 44, 56, 66, 66, 74, 82, 89, 95, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet1_3($index) {
        $valores = [0, 30, 60, 64, 68, 68, 72, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet2A_1($index) {
        $valores = [4, 14, 27, 41, 53, 64, 74, 85, 96];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet2A_1($index) {
        $valores = [0, 20, 40, 60, 68, 75, 78, 82, 85];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet2A_2($index) {
        $valores = [8, 24, 38, 50, 61, 70, 78, 87, 94, 98];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet2A_2($index) {
        $valores = [0, 30, 60, 65, 70, 75, 78, 82, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet2A_3($index) {
        $valores = [12, 33, 47, 59, 69, 76, 83, 89, 95, 98];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet2A_3($index) {
        $valores = [0, 30, 60, 68, 75, 77, 80, 83, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet2B_1($index) {
        $valores = [6, 17, 28, 39, 50, 60, 70, 80, 89, 97];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet2B_1($index) {
        $valores = [0, 20, 40, 60, 65, 70, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet2B_2($index) {
        $valores = [16, 41, 55, 65, 73, 79, 85, 90, 95, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet2B_2($index) {
        $valores = [0, 60, 65, 70, 75, 78, 82, 85, 92, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet2B_3($index) {
        $valores = [9, 30, 48, 57, 65, 71, 76, 83, 90, 97];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet2B_3($index) {
        $valores = [0, 30, 60, 65, 70, 75, 78, 82, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet3_1($index) {
        $valores = [8, 21, 34, 47, 59, 69, 79, 87, 94, 98];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet3_1($index) {
        $valores = [0, 20, 40, 60, 65, 70, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet3_2($index) {
        $valores = [11, 33, 55, 70, 81, 90, 96, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet3_2($index) {
        $valores = [0, 60, 65, 70, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet3_3($index) {
        $valores = [7, 22, 38, 54, 66, 76, 84, 91, 96, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet3_3($index) {
        $valores = [0, 30, 60, 65, 70, 75, 78, 82, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet4A_1($index) {
        $valores = [12, 35, 55, 70, 83, 92, 97, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet4A_1($index) {
        $valores = [0, 60, 65, 70, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet4A_2($index) {
        $valores = [2, 7, 14, 22, 32, 41, 52, 64, 76, 88, 97];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet4A_2($index) {
        $valores = [0, 12, 24, 36, 48, 60, 65, 70, 75, 80, 85];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet4A_3($index) {
        $valores = [2, 8, 17, 26, 35, 44, 53, 61, 69, 77, 86, 93];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet4A_3($index) {
        $valores = [0, 12, 24, 36, 48, 60, 64, 68, 72, 75, 78, 82];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet4B_1($index) {
        $valores = [7, 22, 35, 48, 59, 69, 80, 89, 97];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet4B_1($index) {
        $valores = [0, 20, 40, 60, 65, 70, 75, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet4B_2($index) {
        $valores = [3, 11, 22, 34, 45, 57, 71, 84, 95];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet4B_2($index) {
        $valores = [0, 15, 30, 45, 60, 65, 70, 75, 85];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet4B_3($index) {
        $valores = [3, 10, 20, 30, 41, 53, 68, 84, 96, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet4B_3($index) {
        $valores = [0, 15, 30, 45, 60, 65, 70, 75, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet5_1($index) {
        $valores = [10, 31, 50, 64, 76, 84, 91, 96, 98];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet5_1($index) {
        $valores = [0, 30, 60, 65, 70, 75, 80, 85, 92];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet5_2($index) {
        $valores = [3, 10, 20, 30, 40, 50, 61, 71, 82, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet5_2($index) {
        $valores = [0, 12, 24, 36, 48, 60, 65, 70, 75, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet5_3($index) {
        $valores = [18, 50, 71, 83, 92, 96, 98, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet5_3($index) {
        $valores = [0, 60, 68, 75, 80, 85, 90, 95, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet6A_1($index) {
        $valores = [7, 26, 48, 65, 77, 87, 94, 98, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet6A_1($index) {
        $valores = [0, 30, 60, 65, 70, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet6A_2($index) {
        $valores = [8, 27, 48, 66, 79, 87, 93, 97, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet6A_2($index) {
        $valores = [0, 30, 60, 65, 70, 75, 80, 85, 90];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet6A_3($index) {
        $valores = [13, 40, 61, 75, 83, 88, 92, 95, 97, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet6A_3($index) {
        $valores = [0, 60, 64, 68, 72, 75, 78, 82, 85, 95, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet6B_1($index) {
        $valores = [10, 29, 46, 61, 74, 84, 90, 94, 97, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet6B_1($index) {
        $valores = [0, 30, 60, 64, 68, 72, 75, 78, 82, 92, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet6B_2($index) {
        $valores = [13, 35, 55, 72, 85, 93, 98, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet6B_2($index) {
        $valores = [0, 60, 64, 68, 72, 75, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet6B_3($index) {
        $valores = [19, 49, 66, 76, 84, 90, 95, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet6B_3($index) {
        $valores = [0, 60, 64, 68, 72, 75, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet7_1($index) {
        $valores = [1, 6, 15, 28, 42, 57, 72, 86, 96];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet7_1($index) {
        $valores = [0, 15, 30, 45, 60, 65, 70, 75, 85];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet7_2($index) {
        $valores = [2, 7, 14, 23, 34, 44, 55, 66, 76, 84, 91, 97, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet7_2($index) {
        $valores = [0, 12, 24, 36, 48, 60, 64, 68, 72, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet7_3($index) {
        $valores = [1, 1, 3, 7, 14, 23, 36, 52, 72, 92];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet7_3($index) {
        $valores = [0, 10, 20, 30, 40, 50, 60, 68, 75, 85];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet8A_1($index) {
        $valores = [12, 34, 51, 64, 75, 83, 89, 94, 97, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet8A_1($index) {
        $valores = [0, 60, 65, 70, 75, 77, 80, 83, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet8A_2($index) {
        $valores = [7, 21, 34, 44, 54, 64, 73, 79, 85, 92, 95, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet8A_2($index) {
        $valores = [0, 20, 40, 60, 64, 68, 72, 75, 78, 82, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet8A_3($index) {
        $valores = [13, 36, 51, 62, 71, 78, 84, 88, 93, 97, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet8A_3($index) {
        $valores = [0, 60, 64, 68, 72, 75, 77, 80, 83, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet8B_1($index) {
        $valores = [9, 26, 40, 50, 60, 67, 73, 79, 84, 88, 93, 96, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet8B_1($index) {
        $valores = [0, 30, 60, 62, 65, 67, 69, 72, 75, 78, 82, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet8B_2($index) {
        $valores = [13, 35, 49, 61, 70, 79, 87, 93, 97, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet8B_2($index) {
        $valores = [0, 30, 60, 64, 68, 72, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacet8B_3($index) {
        $valores = [3, 12, 22, 32, 44, 55, 67, 79, 89, 97];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacet8B_3($index) {
        $valores = [0, 24, 36, 48, 60, 65, 70, 75, 80, 85];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacetS_1($index) {
        $valores = [9, 24, 37, 49, 60, 71, 80, 87, 93, 98];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacetS_1($index) {
        $valores = [0, 20, 40, 60, 63, 66, 69, 72, 75, 85];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacetS_2($index) {
        $valores = [10, 29, 43, 53, 62, 70, 76, 82, 87, 92, 97, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacetS_2($index) {
        $valores = [0, 30, 60, 62, 64, 66, 69, 71, 73, 75, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacetS_3($index) {
        $valores = [17, 43, 60, 71, 79, 86, 90, 94, 96, 98, 99, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacetS_3($index) {
        $valores = [0, 60, 63, 66, 69, 72, 75, 78, 82, 85, 92, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacetC_1($index) {
        $valores = [14, 34, 47, 56, 63, 71, 78, 87, 95];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacetC_1($index) {
        $valores = [0, 30, 60, 64, 68, 72, 75, 80, 85];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacetC_2($index) {
        $valores = [13, 34, 48, 58, 66, 73, 79, 84, 90, 94, 98, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacetC_2($index) {
        $valores = [0, 30, 60, 63, 66, 69, 72, 75, 78, 82, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacetC_3($index) {
        $valores = [13, 33, 47, 59, 69, 76, 82, 89, 94, 98, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacetC_3($index) {
        $valores = [0, 30, 60, 64, 68, 72, 75, 78, 82, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacetP_1($index) {
        $valores = [9, 28, 44, 57, 68, 78, 86, 93, 97, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacetP_1($index) {
        $valores = [0, 30, 60, 64, 68, 72, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacetP_2($index) {
        $valores = [14, 39, 58, 73, 85, 92, 97, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacetP_2($index) {
        $valores = [0, 60, 65, 70, 75, 80, 85, 100];
        return $valores[(int)$index] ?? 0;
    }

    public function getPercentilFacetP_3($index) {
        $valores = [17, 43, 60, 72, 81, 87, 92, 95, 97, 98, 99];
        return $valores[(int)$index] ?? 0;
    }

    public function getTbFacetP_3($index) {
        $valores = [0, 60, 65, 70, 75, 77, 80, 83, 85, 92, 100];
        return $valores[(int)$index] ?? 0;
    }

}