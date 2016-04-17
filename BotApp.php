<?php

namespace pimax\bitrix24;

class BotApp
{
    protected $log_file = "imbot.log";

    protected $language = "en";

    protected $default_language = "en";

    protected $messages = [];

    protected $auth = null;
    
    protected $params = [];

    public function __construct($auth)
    {
        $this->auth = $auth;
        $this->params = $this->loadParams();

        $this->language = $this->params[$_REQUEST['auth']['application_token']]['LANGUAGE_ID'];
        $this->messages = $this->loadMessages();
    }

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

    public function uninstall()
    {
        $configFileName = '/config_' . trim(str_replace('.', '_', $_REQUEST['auth']['domain'])) . '.php';

        if (file_exists($configFileName)) {
            unlink($configFileName);
        }

        return true;
    }

    public function send(Message $message)
    {
        return $this->call('imbot.message.add', $message->getData(), $this->auth);
    }

    public function saveParams($params)
    {
        $config = "<?php\n";
        $config .= "\return " . var_export($params, true) . ";\n";
        $configFileName = '/config_' . trim(str_replace('.', '_', $_REQUEST['auth']['domain'])) . '.php';
        file_put_contents(__DIR__ . $configFileName, $config);

        return true;
    }

    public function t($text)
    {
        if ($this->language != $this->default_language && !empty($this->messages[$text])) {
            return $this->messages[$text];
        }

        return $text;
    }

    public function debug($data, $title = '')
    {
        $log = "\n------------------------\n";
        $log .= date("Y.m.d G:i:s") . "\n";
        $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
        $log .= print_r($data, 1);
        $log .= "\n------------------------\n";
        file_put_contents(__DIR__ . '/'.$this->log_file, $log, FILE_APPEND);

        return true;
    }

    protected function call($method, array $params = array(), array $auth = array())
    {
        $queryUrl  = 'https://' . $auth['domain'] . '/rest/' . $method;
        $queryData = http_build_query(array_merge($params, array('auth' => $auth['access_token'])));

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

    protected function loadParams()
    {
        $configFileName = '/config_' . trim(str_replace('.', '_', $_REQUEST['auth']['domain'])) . '.php';
        if (file_exists(__DIR__ . $configFileName)) {
            return include_once __DIR__ . $configFileName;
        }

        return false;
    }

    protected function loadMessages()
    {
        if ($this->language != $this->default_language && file_exists(__DIR__.'/messages/'.$this->language.'.php')) {
            return include __DIR__.'/messages/'.$this->messages.'.php';
        }

        return [];
    }
}