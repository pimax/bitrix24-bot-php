<?php

namespace pimax\bitrix24;

/**
 * Class Message
 *
 * @package pimax\bitrix24
 */
class Message
{
    /**
     * Dialog id
     *
     * @var int
     */
    protected $dialog_id = 0;

    /**
     * Message text
     * @var string
     */
    protected $message = "";

    /**
     * Message attachments
     *
     * @var array
     */
    protected $attach = [];

    /**
     * Message constructor.
     *
     * @param string $message Message text
     * @param int $dialog_id Dialog id
     * @param array $attach Attachments
     */
    public function __construct($message, $dialog_id = 0, $attach = [])
    {
        $this->dialog_id = $dialog_id;
        $this->message = $message;
        $this->attach = $attach;
    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        $return = [];

        if ($this->dialog_id) {
            $return['DIALOG_ID'] = $this->dialog_id;
        }

        $return['MESSAGE'] = $this->message;

        if ($this->attach){
            $return['ATTACH'] = [];

            foreach ($this->attach as $attach) {
                $return['ATTACH'][] = $attach->getData();
            }
        }

        return $return;
    }
}