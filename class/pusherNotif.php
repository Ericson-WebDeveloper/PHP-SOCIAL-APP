<?php


class Notif
{

    public $pusher;

    public function __construct()
    {
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $this->pusher = new Pusher\Pusher(
            'c77d753570287883aa81',
            '751be0f2e46071c83b21',
            '1357879',
            $options
        );
    }
}
