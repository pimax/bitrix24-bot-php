<?php

namespace pimax\bitrix24;

/**
 * Class Link
 *
 * @package pimax\bitrix24
 */
class Link
{
    /**
     * Dialog id
     *
     * @var int
     */
    protected $dialog_id = 0;

    /**
     * Link url
     * @var string
     */
    protected $link = "";

    /**
     * Link title
     *
     * @var string
     */
    protected $title = "";

    public function __construct($url, $title, $dialog_id = 0)
    {
        $this->dialog_id = $dialog_id;
        $this->title = $title;
        $this->link = $url;
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

        $return['LINK'] = [
            'LINK' => $this->link,
            'NAME' => $this->title
        ];

        return $return;
    }
}