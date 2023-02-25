<?php


class Notif
{

    public $pusher;

    public function __construct()
    {
        $options = array(
            'cluster' => 'ap3',
            'useTLS' => true
        );

        $this->pusher = new Pusher\Pusher(
            '983513d8fdea2da8d62d',
            '54446f6cde3cee7a1469',
            '916013',
            $options
        );
    }
}
