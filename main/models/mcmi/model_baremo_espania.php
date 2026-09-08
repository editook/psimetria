<?php
class ModelBaremoEspania
{
    public function getValue1($index) {
        $valores = [0, 7, 13, 20, 27, 33, 40, 47, 53, 60, 63, 65, 68, 70, 73, 75, 78, 82, 85, 91, 97, 103, 109, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentil1($index) {
        $valores = [2, 2, 2, 2, 2, 2, 2, 5, 5, 5, 5, 5, 5, 9, 9, 9, 9, 9, 9, 9, 13, 14, 14, 14, 14, 14, 14, 18, 19, 19, 19, 19, 20, 26, 26, 26, 26, 26, 26, 27, 31, 31, 31, 31, 31, 31, 32, 36, 36, 36, 36, 36, 37, 42, 42, 42, 42, 42, 42, 43, 48, 48, 49, 54, 56, 61, 61, 62, 65, 67, 71, 71, 73, 76, 78, 80, 80, 81, 84, 84, 85, 87, 88, 88, 89, 91, 91, 91, 91, 91, 93, 94, 94, 94, 94, 94, 95, 96, 96, 96, 96, 96, 98, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue2A($index) {
        $valores = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60, 75, 77, 78, 80, 82, 83, 85, 89, 94, 98, 102, 106, 111, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentil2A($index) {
        $valores = [2, 2, 2, 2, 2, 2, 5, 5, 6, 6, 6, 6, 10, 10, 10, 10, 10, 10, 16, 16, 16, 16, 16, 16, 20, 20, 20, 20, 21, 21, 25, 25, 25, 25, 25, 26, 31, 31, 31, 31, 32, 32, 37, 37, 37, 37, 37, 38, 41, 42, 42, 42, 42, 43, 46, 46, 46, 46, 46, 47, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 51, 51, 51, 52, 55, 56, 61, 64, 65, 68, 70, 74, 76, 78, 80, 80, 80, 81, 84, 84, 84, 84, 86, 88, 88, 88, 90, 91, 91, 92, 92, 94, 94, 94, 95, 96, 96, 96, 96, 98, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue2B($index) {
        $valores = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 76, 78, 79, 80, 81, 83, 84, 85, 91, 97, 103, 109, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentil2B($index) {
        $valores = [5, 6, 6, 7, 7, 8, 8, 9, 9, 9, 13, 13, 14, 14, 14, 17, 17, 17, 19, 19, 20, 20, 20, 20, 21, 23, 23, 23, 23, 24, 28, 28, 29, 29, 29, 32, 32, 32, 32, 33, 37, 37, 37, 37, 37, 40, 40, 40, 40, 40, 44, 44, 44, 44, 44, 47, 47, 47, 47, 47, 51, 51, 51, 51, 51, 54, 54, 54, 54, 55, 57, 57, 57, 57, 57, 61, 63, 65, 68, 72, 74, 77, 78, 81, 85, 86, 86, 87, 87, 87, 88, 89, 89, 89, 89, 89, 91, 91, 91, 92, 92, 92, 94, 94, 94, 95, 95, 95, 96, 97, 97, 98, 98, 98, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue3($index) {
        $valores = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60, 68, 75, 78, 80, 83, 85, 89, 94, 98, 102, 106, 111, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentil3($index) {
        $valores = [2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 7, 7, 7, 8, 8, 8, 9, 10, 10, 10, 10, 10, 14, 15, 15, 15, 15, 15, 20, 20, 20, 21, 21, 21, 25, 25, 25, 25, 25, 26, 32, 33, 33, 33, 33, 33, 38, 38, 39, 39, 39, 39, 44, 45, 45, 45, 45, 46, 51, 51, 51, 51, 51, 51, 51, 53, 57, 57, 57, 57, 57, 58, 59, 63, 63, 64, 68, 70, 73, 73, 75, 78, 80, 84, 84, 84, 86, 88, 88, 88, 88, 90, 93, 93, 93, 94, 96, 96, 96, 96, 97, 97, 97, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue4A($index) {
        $valores = [0, 7, 13, 20, 27, 33, 40, 47, 53, 60, 63, 65, 68, 70, 73, 75, 78, 80, 83, 85, 88, 91, 94, 97, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentil4A($index) {
        $valores = [4, 4, 4, 4, 4, 4, 7, 9, 9, 10, 10, 10, 11, 14, 14, 14, 14, 14, 14, 15, 18, 18, 18, 18, 18, 18, 19, 24, 24, 25, 25, 25, 26, 30, 30, 30, 30, 30, 30, 31, 36, 36, 36, 36, 36, 36, 37, 40, 41, 41, 41, 41, 42, 45, 45, 46, 46, 46, 46, 47, 50, 50, 52, 56, 58, 62, 62, 63, 67, 68, 72, 72, 73, 78, 79, 83, 83, 84, 87, 88, 91, 91, 91, 93, 94, 95, 95, 95, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue4B($index) {
        $valores = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60, 61, 63, 64, 65, 67, 68, 70, 71, 72, 74, 75, 80, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentil4B($index) {
        $valores = [4, 4, 4, 4, 4, 5, 7, 8, 8, 8, 8, 9, 13, 13, 14, 14, 14, 15, 19, 19, 19, 19, 19, 21, 24, 24, 24, 24, 24, 25, 28, 29, 29, 29, 29, 30, 33, 33, 33, 34, 34, 34, 36, 36, 37, 37, 37, 38, 41, 41, 41, 41, 42, 43, 46, 46, 46, 46, 47, 48, 51, 55, 55, 60, 63, 66, 67, 71, 73, 74, 77, 80, 83, 83, 87, 90, 90, 90, 90, 91, 93, 94, 94, 94, 94, 97, 97, 97, 97, 97, 97, 97, 97, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue5($index) {
        $valores = [0, 12, 24, 36, 48, 60, 62, 64, 66, 69, 71, 73, 75, 78, 80, 83, 85, 88, 91, 94, 97, 100, 103, 106, 109, 112, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentil5($index) {
        $valores = [10, 11, 11, 12, 12, 12, 12, 12, 12, 12, 12, 12, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 16, 25, 25, 26, 26, 27, 27, 27, 27, 27, 27, 27, 28, 33, 34, 34, 34, 34, 34, 34, 34, 34, 34, 34, 35, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 44, 49, 51, 56, 57, 61, 63, 68, 68, 70, 74, 75, 78, 80, 82, 84, 87, 87, 88, 90, 91, 92, 92, 93, 94, 95, 95, 95, 96, 96, 96, 97, 97, 97, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue6A($index) {
        $valores = [0, 20, 40, 60, 62, 64, 66, 69, 71, 73, 75, 78, 82, 85, 89, 93, 96, 100, 104, 108, 111, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentil6A($index) {
        $valores = [11, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 13, 13, 13, 14, 25, 25, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 27, 39, 39, 39, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 42, 50, 52, 60, 62, 67, 69, 74, 74, 76, 81, 81, 84, 85, 87, 89, 90, 90, 91, 92, 92, 92, 93, 94, 94, 95, 96, 96, 96, 97, 97, 97, 97, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue6B($index) {
        $valores = [0, 10, 20, 30, 40, 50, 60, 62, 63, 65, 67, 68, 70, 72, 73, 75, 78, 82, 85, 93, 100, 108, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentil6B($index) {
        $valores = [6, 7, 8, 8, 8, 8, 8, 8, 8, 8, 13, 13, 13, 13, 13, 13, 13, 13, 13, 14, 22, 22, 23, 23, 23, 23, 23, 23, 23, 24, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 37, 38, 38, 38, 38, 38, 38, 38, 38, 39, 44, 44, 44, 44, 44, 44, 44, 44, 44, 46, 52, 53, 60, 64, 66, 70, 71, 77, 81, 82, 85, 87, 90, 92, 93, 93, 94, 95, 96, 96, 96, 97, 98, 98, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue7($index) {
        $valores = [0, 4, 8, 11, 15, 19, 23, 26, 30, 34, 38, 41, 45, 49, 53, 56, 60, 64, 68, 71, 75, 80, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentil7($index) {
        $valores = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 3, 3, 3, 3, 4, 5, 5, 6, 6, 9, 9, 9, 10, 12, 12, 13, 16, 17, 17, 18, 20, 20, 20, 21, 26, 26, 27, 28, 31, 31, 33, 40, 40, 41, 43, 47, 47, 47, 49, 59, 59, 60, 62, 68, 68, 70, 79, 79, 79, 81, 85, 85, 85, 85, 87, 96, 96, 96, 96, 96, 97, 97, 97, 97, 97, 97, 97, 97, 97, 97, 97, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue8A($index) {
        $valores = [0, 7, 13, 20, 27, 33, 40, 47, 53, 60, 62, 64, 66, 69, 71, 73, 75, 78, 80, 83, 85, 90, 95, 100, 105, 110, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentil8A($index) {
        $valores = [3, 4, 5, 6, 6, 6, 6, 9, 9, 10, 10, 10, 10, 13, 14, 14, 14, 14, 14, 14, 19, 19, 19, 19, 19, 19, 19, 24, 24, 24, 24, 24, 24, 29, 29, 29, 29, 29, 29, 29, 33, 33, 33, 33, 33, 33, 33, 38, 38, 38, 38, 38, 39, 43, 43, 43, 43, 43, 43, 43, 48, 48, 52, 53, 57, 58, 63, 63, 64, 68, 69, 72, 73, 75, 77, 79, 80, 82, 83, 85, 86, 87, 88, 89, 91, 92, 93, 93, 93, 95, 96, 96, 96, 96, 97, 97, 98, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValue8B($index) {
        $valores = [0, 8, 15, 23, 30, 38, 45, 53, 60, 62, 63, 65, 67, 68, 70, 72, 73, 75, 78, 80, 83, 85, 93, 100, 108, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentil8B($index) {
        $valores = [5, 5, 5, 6, 6, 6, 6, 6, 10, 10, 10, 11, 11, 11, 11, 15, 16, 16, 16, 16, 16, 16, 16, 22, 22, 22, 22, 23, 23, 23, 28, 28, 29, 29, 29, 29, 29, 29, 33, 33, 33, 33, 33, 33, 33, 39, 39, 39, 39, 39, 39, 39, 40, 45, 45, 45, 45, 45, 45, 46, 51, 51, 56, 60, 61, 65, 66, 70, 73, 75, 77, 78, 81, 83, 84, 85, 86, 87, 88, 90, 91, 91, 93, 93, 94, 94, 94, 94, 95, 95, 95, 95, 96, 96, 96, 97, 97, 97, 97, 98, 98, 98, 98, 98, 98, 99, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueS($index) {
        $valores = [0, 6, 12, 18, 24, 30, 36, 42, 48, 54, 60, 62, 63, 65, 66, 68, 69, 71, 72, 74, 75, 78, 82, 85, 90, 95, 100, 105, 110, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilS($index) {
        $valores = [4, 5, 6, 6, 6, 6, 9, 9, 10, 10, 10, 10, 14, 14, 15, 15, 15, 15, 18, 18, 18, 18, 18, 18, 24, 24, 24, 24, 24, 24, 29, 29, 29, 29, 29, 30, 34, 34, 34, 34, 34, 34, 39, 39, 39, 39, 39, 39, 43, 43, 43, 43, 43, 43, 47, 47, 47, 47, 47, 48, 51, 52, 56, 59, 60, 64, 67, 67, 71, 74, 75, 79, 81, 82, 85, 86, 86, 87, 88, 88, 89, 90, 91, 91, 92, 92, 92, 93, 93, 95, 95, 95, 96, 96, 97, 97, 97, 97, 97, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueC($index) {
        $valores = [0, 8, 15, 23, 30, 38, 45, 53, 60, 62, 64, 66, 68, 69, 71, 73, 75, 78, 82, 85, 89, 93, 96, 100, 104, 108, 111, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilC($index) {
        $valores = [4, 6, 6, 6, 6, 7, 7, 7, 12, 13, 13, 13, 13, 13, 13, 18, 19, 19, 19, 19, 19, 19, 19, 24, 24, 24, 24, 24, 24, 24, 29, 30, 30, 30, 30, 30, 30, 30, 35, 35, 35, 35, 35, 35, 36, 40, 40, 40, 40, 40, 40, 40, 40, 45, 45, 45, 45, 45, 45, 45, 49, 49, 53, 53, 57, 58, 61, 62, 65, 69, 70, 72, 74, 76, 77, 79, 79, 80, 81, 81, 82, 83, 84, 84, 86, 87, 87, 88, 89, 90, 90, 90, 92, 92, 93, 94, 94, 94, 95, 96, 96, 96, 96, 97, 97, 97, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueP($index) {
        $valores = [0, 9, 17, 26, 34, 43, 51, 60, 63, 66, 69, 72, 75, 78, 82, 85, 88, 92, 95, 98, 102, 105, 108, 112, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilP($index) {
        $valores = [7, 9, 10, 10, 10, 10, 10, 10, 10, 15, 15, 15, 15, 15, 15, 15, 15, 24, 24, 24, 24, 24, 24, 24, 24, 24, 29, 29, 29, 29, 29, 29, 29, 29, 36, 36, 36, 36, 36, 36, 36, 36, 36, 42, 42, 42, 42, 42, 42, 42, 42, 47, 47, 47, 47, 47, 47, 47, 47, 48, 52, 52, 53, 57, 57, 58, 62, 63, 64, 68, 68, 70, 73, 73, 75, 78, 78, 80, 82, 82, 82, 84, 86, 86, 88, 89, 89, 91, 92, 92, 93, 94, 94, 95, 95, 97, 97, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueA($index) {
        $valores = [0, 8, 15, 23, 30, 38, 45, 53, 60, 75, 78, 80, 83, 85, 90, 95, 100, 105, 110, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilA($index) {
        $valores = [5, 5, 6, 6, 6, 6, 6, 6, 10, 10, 10, 10, 10, 10, 10, 14, 15, 15, 15, 15, 15, 15, 15, 19, 20, 20, 20, 20, 20, 20, 26, 26, 26, 26, 26, 26, 26, 26, 31, 31, 31, 31, 31, 31, 32, 37, 37, 37, 37, 37, 37, 37, 38, 45, 45, 45, 45, 45, 45, 46, 51, 51, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 57, 57, 59, 64, 67, 71, 71, 74, 78, 80, 82, 82, 82, 82, 84, 86, 86, 86, 87, 88, 91, 91, 91, 91, 94, 94, 94, 95, 95, 97, 97, 97, 97, 98, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueH($index) {
        $valores = [0, 10, 20, 30, 40, 50, 60, 64, 68, 71, 75, 80, 85, 95, 105, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilH($index) {
        $valores = [11, 12, 12, 12, 12, 12, 12, 12, 12, 12, 17, 19, 19, 19, 19, 19, 19, 19, 19, 20, 28, 29, 29, 29, 29, 29, 29, 29, 29, 30, 35, 35, 35, 35, 35, 35, 35, 35, 35, 36, 42, 42, 42, 42, 42, 42, 42, 42, 42, 42, 46, 46, 46, 46, 46, 46, 46, 46, 46, 47, 50, 50, 50, 52, 56, 56, 56, 57, 63, 64, 65, 70, 71, 72, 74, 78, 78, 78, 78, 80, 84, 84, 84, 85, 88, 90, 90, 90, 90, 90, 90, 90, 90, 91, 93, 94, 94, 94, 94, 94, 94, 94, 95, 95, 96, 98, 98, 98, 98, 98, 98, 98, 98, 98, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueN($index) {
        $valores = [0, 10, 20, 30, 40, 50, 60, 63, 66, 69, 72, 75, 80, 85, 90, 95, 100, 105, 110, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilN($index) {
        $valores = [3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 8, 9, 9, 9, 9, 9, 9, 9, 9, 9, 15, 15, 15, 15, 15, 15, 15, 15, 15, 16, 22, 23, 23, 23, 23, 23, 23, 23, 23, 24, 30, 30, 30, 30, 30, 30, 30, 30, 30, 32, 38, 39, 39, 39, 39, 39, 39, 39, 39, 41, 48, 48, 49, 55, 55, 57, 65, 65, 67, 72, 72, 74, 79, 79, 81, 84, 84, 84, 84, 86, 89, 89, 90, 90, 91, 93, 93, 93, 94, 95, 96, 96, 96, 97, 97, 98, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueD($index) {
        $valores = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 63, 66, 69, 72, 75, 78, 80, 83, 85, 90, 95, 100, 105, 110, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilD($index) {
        $valores = [3, 4, 4, 4, 4, 8, 8, 9, 9, 9, 13, 14, 14, 14, 14, 18, 18, 18, 18, 18, 21, 21, 21, 21, 21, 24, 24, 24, 24, 25, 28, 28, 28, 28, 28, 31, 31, 31, 31, 31, 35, 35, 35, 35, 35, 40, 40, 40, 40, 41, 45, 45, 45, 45, 45, 48, 48, 48, 48, 48, 50, 50, 50, 53, 53, 53, 55, 55, 56, 59, 59, 60, 62, 62, 62, 65, 65, 66, 69, 70, 72, 73, 74, 76, 77, 78, 78, 79, 79, 81, 83, 83, 84, 84, 86, 87, 87, 87, 87, 89, 90, 90, 90, 90, 92, 93, 93, 93, 94, 96, 97, 97, 97, 98, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueB($index) {
        $valores = [0, 60, 68, 75, 85, 88, 92, 95, 98, 102, 105, 108, 112, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilB($index) {
        $valores = [34, 36, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 38, 45, 65, 65, 65, 65, 65, 66, 67, 72, 80, 80, 80, 80, 81, 81, 83, 86, 86, 86, 86, 86, 86, 87, 87, 88, 88, 91, 91, 92, 93, 93, 93, 94, 95, 95, 96, 96, 96, 96, 97, 97, 97, 97, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueT($index) {
        $valores = [0, 60, 62, 64, 66, 68, 69, 71, 73, 75, 78, 82, 85, 90, 95, 100, 105, 110, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilT($index) {
        $valores = [24, 25, 25, 25, 25, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 26, 30, 48, 52, 61, 64, 72, 74, 76, 77, 79, 81, 81, 82, 83, 85, 85, 87, 87, 87, 88, 88, 88, 89, 89, 89, 90, 92, 92, 92, 92, 92, 93, 93, 93, 93, 94, 95, 95, 95, 95, 96, 96, 96, 97, 97, 97, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueR($index) {
        $valores = [0, 12, 24, 36, 48, 60, 62, 64, 66, 68, 69, 71, 73, 75, 80, 85, 93, 100, 108, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilR($index) {
        $valores = [8, 9, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 18, 19, 19, 19, 19, 19, 19, 19, 19, 19, 19, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 29, 36, 36, 36, 36, 36, 36, 36, 36, 36, 36, 36, 37, 42, 43, 43, 43, 43, 43, 43, 43, 43, 43, 43, 44, 50, 51, 55, 63, 60, 61, 65, 66, 70, 73, 75, 77, 79, 81, 83, 85, 85, 86, 86, 88, 89, 89, 89, 89, 91, 92, 92, 92, 92, 92, 93, 93, 95, 96, 96, 96, 97, 97, 97, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueSS($index) {
        $valores = [0, 7, 13, 20, 27, 33, 40, 47, 53, 60, 62, 64, 66, 68, 69, 71, 73, 75, 80, 85, 89, 93, 96, 100, 104, 108, 111, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilSS($index) {
        $valores = [3, 4, 5, 5, 5, 5, 5, 8, 8, 9, 9, 9, 9, 13, 14, 14, 14, 14, 14, 14, 20, 20, 20, 20, 20, 20, 20, 23, 24, 24, 24, 24, 24, 27, 28, 28, 28, 28, 28, 28, 33, 33, 33, 33, 33, 33, 34, 39, 39, 39, 39, 39, 40, 45, 45, 45, 45, 45, 45, 45, 49, 50, 56, 57, 61, 62, 66, 67, 72, 75, 76, 78, 81, 83, 85, 86, 86, 86, 86, 88, 89, 89, 89, 89, 90, 91, 91, 91, 93, 93, 94, 94, 95, 96, 96, 97, 97, 97, 97, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueCC($index) {
        $valores = [0, 9, 17, 26, 34, 43, 51, 60, 62, 64, 66, 69, 71, 73, 75, 78, 82, 85, 89, 94, 98, 102, 106, 111, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilCC($index) {
        $valores = [13, 14, 15, 15, 15, 15, 15, 15, 16, 21, 21, 22, 22, 22, 22, 22, 22, 28, 28, 28, 28, 28, 28, 28, 28, 28, 32, 32, 32, 32, 32, 32, 32, 33, 38, 38, 38, 38, 38, 38, 38, 38, 38, 42, 42, 42, 42, 42, 42, 42, 43, 45, 46, 46, 46, 46, 46, 46, 46, 46, 49, 49, 52, 53, 55, 55, 57, 57, 57, 59, 60, 62, 63, 66, 67, 69, 70, 70, 72, 72, 73, 74, 76, 76, 78, 80, 80, 80, 81, 83, 83, 83, 83, 84, 86, 86, 86, 88, 89, 89, 90, 91, 93, 94, 94, 96, 96, 96, 97, 97, 97, 98, 98, 98, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValuePP($index) {
        $valores = [0, 30, 60, 62, 64, 66, 69, 71, 73, 75, 78, 80, 83, 85, 90, 95, 100, 105, 110, 115];
        return $valores[$index] ?? 0;
    }

    public function getPercentilPP($index) {
        $valores = [17, 19, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 21, 38, 38, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 39, 40, 51, 53, 61, 63, 69, 70, 76, 76, 79, 81, 82, 85, 87, 88, 90, 91, 91, 92, 92, 93, 94, 94, 95, 95, 96, 96, 96, 96, 97, 97, 98, 98, 98, 98, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueX($index) {
        $valores = [0, 0, 0, 0, 0, 0, 0, 0, 2, 3, 5, 6, 8, 10, 11, 13, 14, 16, 18, 19, 21, 22, 24, 25, 27, 29, 30, 32, 33, 35, 36, 38, 39, 40, 41, 43, 44, 45, 47, 48, 49, 50, 52, 53, 54, 56, 57, 58, 60, 61, 62, 63, 65, 66, 67, 69, 70, 71, 72, 74, 75, 76, 77, 78, 79, 80, 80, 81, 82, 83, 84, 85, 86, 86, 87, 87, 88, 88, 89, 89, 90, 90, 91, 91, 92, 93, 93, 94, 94, 95, 95, 96, 96, 97, 97, 98, 98, 99, 99, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilX($index) {
        $valores = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 73, 0, 82, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueY($index) {
        $valores = [0, 5, 10, 15, 20, 25, 30, 35, 39, 43, 47, 51, 55, 59, 63, 67, 71, 75, 78, 80, 83, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilY($index) {
        $valores = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 85, 0, 91, 99];
        return $valores[$index] ?? 0;
    }

    public function getValueZ($index) {
        $valores = [0, 12, 23, 35, 37, 40, 42, 44, 47, 49, 51, 54, 56, 59, 61, 63, 66, 68, 70, 73, 75, 77, 78, 80, 82, 83, 85, 89, 93, 96, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilZ($index) {
        $valores = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 75, 0, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet1_1($index) {
        $valores = [9, 22, 38, 55, 68, 80, 89, 95, 98, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet1_1($index) {
        $valores = [0, 20, 40, 60, 68, 75, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet1_2($index) {
        $valores = [3, 10, 20, 35, 48, 59, 71, 82, 93, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet1_2($index) {
        $valores = [0, 15, 30, 45, 60, 65, 70, 75, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet1_3($index) {
        $valores = [13, 27, 40, 51, 60, 69, 79, 87, 95, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet1_3($index) {
        $valores = [0, 20, 40, 60, 65, 70, 75, 80, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet2A_1($index) {
        $valores = [4, 11, 24, 37, 50, 63, 74, 87, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet2A_1($index) {
        $valores = [0, 15, 30, 45, 60, 75, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet2A_2($index) {
        $valores = [8, 20, 33, 45, 57, 69, 81, 92, 97, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet2A_2($index) {
        $valores = [0, 15, 30, 45, 60, 75, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet2A_3($index) {
        $valores = [12, 25, 40, 53, 65, 74, 83, 91, 96, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet2A_3($index) {
        $valores = [0, 20, 40, 60, 75, 80, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet2B_1($index) {
        $valores = [6, 12, 20, 28, 38, 48, 61, 73, 87, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet2B_1($index) {
        $valores = [0, 10, 20, 30, 40, 50, 60, 75, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet2B_2($index) {
        $valores = [24, 41, 54, 65, 75, 83, 88, 93, 97, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet2B_2($index) {
        $valores = [0, 30, 60, 75, 80, 85, 89, 93, 96, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet2B_3($index) {
        $valores = [21, 35, 45, 51, 58, 64, 71, 80, 89, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet2B_3($index) {
        $valores = [0, 20, 40, 60, 75, 78, 80, 83, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet3_1($index) {
        $valores = [6, 14, 23, 34, 49, 64, 77, 88, 97, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet3_1($index) {
        $valores = [0, 12, 24, 36, 48, 60, 75, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet3_2($index) {
        $valores = [7, 21, 41, 61, 79, 90, 97, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet3_2($index) {
        $valores = [0, 20, 40, 60, 75, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet3_3($index) {
        $valores = [10, 22, 35, 46, 58, 70, 80, 88, 97, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet3_3($index) {
        $valores = [0, 15, 30, 45, 60, 75, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet4A_1($index) {
        $valores = [31, 54, 70, 81, 89, 95, 98, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet4A_1($index) {
        $valores = [0, 60, 68, 75, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet4A_2($index) {
        $valores = [7, 15, 25, 35, 47, 58, 68, 80, 91, 98, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet4A_2($index) {
        $valores = [0, 15, 30, 45, 60, 65, 70, 75, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet4A_3($index) {
        $valores = [5, 15, 25, 34, 43, 52, 60, 68, 75, 81, 90, 96, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet4A_3($index) {
        $valores = [0, 12, 24, 36, 48, 60, 64, 68, 71, 75, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet4B_1($index) {
        $valores = [11, 27, 41, 52, 61, 71, 78, 90, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet4B_1($index) {
        $valores = [0, 20, 40, 60, 64, 68, 71, 75, 85];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet4B_2($index) {
        $valores = [7, 22, 36, 46, 59, 73, 86, 95, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet4B_2($index) {
        $valores = [0, 20, 40, 60, 65, 70, 75, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet4B_3($index) {
        $valores = [7, 17, 29, 43, 56, 69, 84, 95, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet4B_3($index) {
        $valores = [0, 15, 30, 45, 60, 68, 75, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet5_1($index) {
        $valores = [26, 47, 64, 76, 84, 90, 95, 98, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet5_1($index) {
        $valores = [0, 60, 65, 70, 75, 80, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet5_2($index) {
        $valores = [6, 18, 31, 40, 52, 61, 71, 78, 88, 96, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet5_2($index) {
        $valores = [0, 15, 30, 45, 60, 64, 68, 71, 75, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet5_3($index) {
        $valores = [26, 50, 69, 80, 90, 96, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet5_3($index) {
        $valores = [0, 60, 65, 70, 75, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet6A_1($index) {
        $valores = [21, 47, 65, 79, 88, 94, 98, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet6A_1($index) {
        $valores = [0, 60, 65, 70, 75, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet6A_2($index) {
        $valores = [16, 37, 60, 76, 86, 93, 97, 99, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet6A_2($index) {
        $valores = [0, 30, 60, 65, 70, 75, 85, 89, 93, 96, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet6A_3($index) {
        $valores = [27, 48, 71, 81, 87, 90, 93, 96, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet6A_3($index) {
        $valores = [0, 60, 64, 68, 71, 75, 80, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet6B_1($index) {
        $valores = [11, 26, 42, 55, 70, 81, 87, 93, 97, 99, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet6B_1($index) {
        $valores = [0, 20, 40, 60, 64, 68, 71, 75, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet6B_2($index) {
        $valores = [22, 43, 63, 77, 88, 95, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet6B_2($index) {
        $valores = [0, 60, 64, 68, 71, 75, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet6B_3($index) {
        $valores = [25, 47, 60, 71, 80, 89, 97, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet6B_3($index) {
        $valores = [0, 60, 64, 68, 71, 75, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet7_1($index) {
        $valores = [1, 6, 16, 26, 45, 61, 75, 88, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet7_1($index) {
        $valores = [0, 12, 24, 36, 48, 60, 75, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet7_2($index) {
        $valores = [2, 7, 14, 22, 29, 39, 49, 59, 69, 80, 89, 95, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet7_2($index) {
        $valores = [0, 9, 17, 26, 34, 43, 51, 60, 75, 80, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet7_3($index) {
        $valores = [1, 1, 3, 6, 11, 19, 36, 56, 81, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet7_3($index) {
        $valores = [0, 9, 17, 26, 34, 43, 51, 60, 75, 85];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet8A_1($index) {
        $valores = [13, 28, 43, 55, 66, 79, 88, 94, 98, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet8A_1($index) {
        $valores = [0, 20, 40, 60, 68, 75, 80, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet8A_2($index) {
        $valores = [6, 15, 24, 36, 47, 58, 68, 78, 86, 93, 98, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet8A_2($index) {
        $valores = [0, 15, 30, 45, 60, 65, 70, 75, 80, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet8A_3($index) {
        $valores = [15, 32, 44, 55, 63, 72, 80, 85, 91, 96, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet8A_3($index) {
        $valores = [0, 20, 40, 60, 65, 70, 75, 80, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet8B_1($index) {
        $valores = [9, 18, 32, 44, 53, 64, 71, 79, 85, 90, 95, 98, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet8B_1($index) {
        $valores = [0, 15, 30, 45, 60, 64, 68, 71, 75, 80, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet8B_2($index) {
        $valores = [13, 25, 37, 49, 60, 71, 82, 91, 97, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet8B_2($index) {
        $valores = [0, 20, 40, 60, 65, 70, 75, 80, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacet8B_3($index) {
        $valores = [7, 17, 23, 33, 44, 54, 64, 75, 89, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacet8B_3($index) {
        $valores = [0, 12, 24, 36, 48, 60, 65, 70, 75, 85];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacetS_1($index) {
        $valores = [7, 16, 26, 35, 46, 56, 66, 79, 90, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacetS_1($index) {
        $valores = [0, 15, 30, 45, 60, 65, 70, 75, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacetS_2($index) {
        $valores = [12, 27, 38, 47, 57, 65, 73, 81, 87, 93, 98, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacetS_2($index) {
        $valores = [0, 20, 40, 60, 63, 66, 69, 72, 75, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacetS_3($index) {
        $valores = [17, 32, 46, 58, 69, 77, 84, 90, 95, 98, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacetS_3($index) {
        $valores = [0, 30, 60, 64, 68, 71, 75, 80, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacetC_1($index) {
        $valores = [20, 35, 45, 52, 61, 69, 78, 89, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacetC_1($index) {
        $valores = [0, 20, 40, 60, 65, 70, 75, 85, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacetC_2($index) {
        $valores = [10, 24, 38, 52, 63, 71, 79, 85, 90, 94, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacetC_2($index) {
        $valores = [0, 20, 40, 60, 65, 70, 75, 85, 89, 93, 96, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacetC_3($index) {
        $valores = [16, 31, 44, 54, 64, 73, 82, 88, 93, 98, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacetC_3($index) {
        $valores = [0, 20, 40, 60, 65, 70, 75, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacetP_1($index) {
        $valores = [12, 28, 41, 57, 70, 81, 89, 96, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacetP_1($index) {
        $valores = [0, 20, 40, 60, 68, 75, 85, 90, 95, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacetP_2($index) {
        $valores = [18, 32, 50, 66, 80, 91, 97, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacetP_2($index) {
        $valores = [0, 30, 60, 68, 75, 85, 93, 100];
        return $valores[$index] ?? 0;
    }

    public function getPercentilFacetP_3($index) {
        $valores = [20, 36, 53, 65, 76, 85, 91, 96, 98, 99, 99];
        return $valores[$index] ?? 0;
    }

    public function getTbFacetP_3($index) {
        $valores = [0, 30, 60, 68, 75, 80, 85, 89, 93, 96, 100];
        return $valores[$index] ?? 0;
    }

}