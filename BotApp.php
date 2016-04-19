<?php

namespace pimax\bitrix24;

/**
 * Class BotApp
 *
 * @package pimax\bitrix24
 */
class BotApp
{
    /**
     * Log file name
     *
     * @var string
     */
    protected $log_file = "imbot.log";

    /**
     * Current language
     *
     * @var string
     */
    protected $language = "en";

    /**
     * Default language
     *
     * @var string
     */
    protected $default_language = "en";

    /**
     * I18n messages
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Auth info
     *
     * @var array
     */
    protected $auth = [];

    /**
     * Portal params
     *
     * @var array
     */
    protected $params = [];

    /**
     * BotApp constructor.
     *
     * @param $auth Auth token
     */
    public function __construct($auth)
    {
        $this->auth = $auth;
        $this->params = $this->loadParams();

        $this->language = $this->params[$_REQUEST['auth']['application_token']]['LANGUAGE_ID'];
        $this->messages = $this->loadMessages();
    }

    /**
     * Bot install action
     *
     * @param Bot $bot
     */
    public function install(Bot $bot)
    {
        $result = $this->call('imbot.register', $bot->getData(), $this->auth);

        $appsConfig = [];
        $appsConfig[$_REQUEST['auth']['application_token']] = array(
            'BOT_ID'      => $result['result'],
            'LANGUAGE_ID' => $_REQUEST['data']['LANGUAGE_ID'],
        );

        $this->saveParams($appsConfig);
    }

    /**
     * Bot uninstall action
     *
     * @return bool
     */
    public function uninstall()
    {
        $configFileName = '/config_' . trim(str_replace('.', '_', $_REQUEST['auth']['domain'])) . '.php';

        if (file_exists($configFileName)) {
            unlink($configFileName);
        }

        return true;
    }

    /**
     * Send message action
     *
     * @param Message $message
     * @return mixed
     */
    public function send(Message $message)
    {
        return $this->call('imbot.message.add', $message->getData(), $this->auth);
    }

    /**
     * Save portal params
     *
     * @param $params
     * @return bool
     */
    public function saveParams($params)
    {
        $config = "<?php\n";
        $config .= "\return " . var_export($params, true) . ";\n";
        $configFileName = '/config_' . trim(str_replace('.', '_', $_REQUEST['auth']['domain'])) . '.php';
        file_put_contents(__DIR__ . $configFileName, $config);

        return true;
    }

    /**
     * Get i18n message for string
     *
     * @param $text string to translate
     * @return string
     */
    public function t($text)
    {
        if ($this->language != $this->default_language && !empty($this->messages[$text])) {
            return $this->messages[$text];
        }

        return $text;
    }

    /**
     * Log data to file
     *
     * @param mixed $data Data
     * @param string $title Title
     * @return bool
     */
    public function log($data, $title = '')
    {
        $log = "\n------------------------\n";
        $log .= date("Y.m.d G:i:s") . "\n";
        $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
        $log .= print_r($data, 1);
        $log .= "\n------------------------\n";
        file_put_contents(__DIR__ . '/'.$this->log_file, $log, FILE_APPEND);

        return true;
    }

    /**
     * API request
     *
     * @param string $method Method
     * @param array $params POST data
     * @return mixed
     */
    protected function call($method, array $params = array())
    {
        $queryUrl  = 'https://' . $this->auth['domain'] . '/rest/' . $method;
        $queryData = http_build_query(array_merge($params, array('auth' => $this->auth['access_token'])));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL            => $queryUrl,
            CURLOPT_POSTFIELDS     => $queryData,
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result, 1);

        return $result;
    }

    /**
     * Load portal params
     *
     * @return array
     */
    protected function loadParams()
    {
        $configFileName = '/config_' . trim(str_replace('.', '_', $_REQUEST['auth']['domain'])) . '.php';
        if (file_exists(__DIR__ . $configFileName)) {
            return include_once __DIR__ . $configFileName;
        }

        return false;
    }

    /**
     * Load i18n messages
     * 
     * @return array|mixed
     */
    protected function loadMessages()
    {
        if ($this->language != $this->default_language && file_exists(__DIR__.'/messages/'.$this->language.'.php')) {
            return include __DIR__.'/messages/'.$this->messages.'.php';
        }

        return [];
    }
}