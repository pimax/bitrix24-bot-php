<?php

namespace pimax\bitrix24;


class Message
{
    protected $dialog_id = 0;

    protected $message = "";

    protected $attach = [];

    public function __construct($message, $dialog_id = 0, $attach = [])
    {
        $this->dialog_id = $dialog_id;
        $this->message = $message;
        $this->attach = $attach;
    }

    public function getData()
    {
        $return = [];

        if ($this->dialog_id) {
            $return['DIALOG_ID'] = $this->dialog_id;
        }

        $return['MESSAGE'] = $this->message;

        if ($this->attach){
            $return['ATTACH'] = $this->attach;
        }

        return $return;
    }
}