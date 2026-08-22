<?php
class CalendaryService
{
    private $answerModel;
    private $registerModel;

    public function __construct($answerModel, $registerModel)
    {
        $this->answerModel = $answerModel;
        $this->registerModel = $registerModel;
    }
}