<?php

namespace pimax\bitrix24;


class Bot
{
    const TYPE_BOT = "B";

    const TYPE_HUMAN = "H";

    const GENGER_MALE = "M";

    const GENDER_FEMALE = "F";

    const COLOR_RED = "RED";

    const COLOR_GREEN = "GREEN";

    const COLOR_LIGHT_BLUE = "LIGHT_BLUE";

    const COLOR_DARK_BLUE = "DARK_BLUE";

    const COLOR_PURPLE = "PURPLE";

    const COLOR_AQUA = "AQUA";

    const COLOR_PINK = "PINK";

    const COLOR_LIME = "LIME";

    const COLOR_BROWN = "BROWN";

    const COLOR_AZURE = "AZURE";

    const COLOR_KHAKI = "KHAKI";

    const COLOR_SAND = "SAND";

    const COLOR_MARENGO = "MARENGO";

    const COLOR_GRAY = "GRAY";

    const COLOR_GRAPHITE = "GRAPHITE";

    protected $code = "";

    protected $type = "";

    protected $event_message_add = "";

    protected $event_bot_delete = "";

    protected $params = "";

    public function __construct($code, $type, $event_message_add, $event_welcome_message, $event_bot_delete, $params = [])
    {
        $this->code = $code;
        $this->type = $type;
        $this->event_message_add = $event_message_add;
        $this->event_welcome_message = $event_welcome_message;
        $this->event_bot_delete = $event_bot_delete;
        $this->params = $params;
    }

    public function getData()
    {
        return [
            'CODE'                  => $this->code,
            'TYPE'                  => $this->type,
            'EVENT_MESSAGE_ADD'     => $this->event_message_add,
            'EVENT_WELCOME_MESSAGE' => $this->event_welcome_message,
            'EVENT_BOT_DELETE'      => $this->event_bot_delete,
            'PROPERTIES'            => $this->params
        ];
    }
}