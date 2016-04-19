<?php

namespace pimax\bitrix24;

/**
 * Class Bot
 *
 * @package pimax\bitrix24
 */
class Bot
{
    /**
     * Bot type is "Bot"
     */
    const TYPE_BOT = "B";

    /**
     * Bot type is "Human"
     */
    const TYPE_HUMAN = "H";

    /**
     * Gender Male
     */
    const GENGER_MALE = "M";

    /**
     * Gender Female
     */
    const GENDER_FEMALE = "F";

    /**
     * Color RED
     */
    const COLOR_RED = "RED";

    /**
     * Color GREEN
     */
    const COLOR_GREEN = "GREEN";

    /**
     * Color LIGHT_BLUE
     */
    const COLOR_LIGHT_BLUE = "LIGHT_BLUE";

    /**
     * Color DARK_BLUE
     */
    const COLOR_DARK_BLUE = "DARK_BLUE";

    /**
     * Color PURPLE
     */
    const COLOR_PURPLE = "PURPLE";

    /**
     * Color AQUA
     */
    const COLOR_AQUA = "AQUA";

    /**
     * Color PINK
     */
    const COLOR_PINK = "PINK";

    /**
     * Color LIME
     */
    const COLOR_LIME = "LIME";

    /**
     * Color BROWN
     */
    const COLOR_BROWN = "BROWN";

    /**
     * Color AZURE
     */
    const COLOR_AZURE = "AZURE";

    /**
     * Color KHAKI
     */
    const COLOR_KHAKI = "KHAKI";

    /**
     * Color SAND
     */
    const COLOR_SAND = "SAND";

    /**
     * Color MARENGO
     */
    const COLOR_MARENGO = "MARENGO";

    /**
     * Color GRAY
     */
    const COLOR_GRAY = "GRAY";

    /**
     * Color GRAPHITE
     */
    const COLOR_GRAPHITE = "GRAPHITE";

    /**
     * Bot alias
     *
     * @var string
     */
    protected $code = "";

    /**
     * Bot Type
     *
     * @var string
     */
    protected $type = "";

    /**
     * Webhook message receive
     *
     * @var string
     */
    protected $event_message_add = "";

    /**
     * Webhook bot install
     *
     * @var string
     */
    protected $event_welcome_message = "";

    /**
     * Webhook bot delete
     *
     * @var string
     */
    protected $event_bot_delete = "";

    /**
     * Bot info
     * 
     * @var array
     */
    protected $params = [];

    /**
     * Bot constructor.
     *
     * @param string $code Bot alias
     * @param string $type Type
     * @param string $event_message_add Webhook message receive
     * @param string $event_welcome_message Webhook welcome message
     * @param string $event_bot_delete Webhook bot delete
     * @param array $params Bot info
     */
    public function __construct($code, $type, $event_message_add, $event_welcome_message, $event_bot_delete, $params = [])
    {
        $this->code = $code;
        $this->type = $type;
        $this->event_message_add = $event_message_add;
        $this->event_welcome_message = $event_welcome_message;
        $this->event_bot_delete = $event_bot_delete;
        $this->params = $params;
    }

    /**
     * Get Bot Data
     *
     * @return array
     */
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