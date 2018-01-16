<?php

namespace SimpleLog\Message;

class DefaultJsonMessage extends DefaultMessage
{
    /**
     * @var array
     */
    protected $message = [
        'date' => '',
        'time' => '',
        'data' => '',
    ];

    /**
     * @var array
     */
    protected $context = [];

    /**
     * @param string|array|object $message
     * @param array $context
     * @return $this
     */
    public function createMessage($message, array $context)
    {
        $this->context = $context;

        list($date, $time) = explode(';', strftime('%d-%m-%Y;%H:%M:%S', time()));

        $this->message['date'] = $date;
        $this->message['time'] = $time;

        if (method_exists($message, '__toString')) {
            $message = (string)$message;
        }

        $this->message['data'] = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        $this->message = json_encode($this->message);
        $this->buildContext($this->context);

        return $this->message;
    }
}
