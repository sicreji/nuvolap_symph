<?php

namespace App\Service;

class PasswordService
{
    private $len;
    private $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    public function __construct($len = 10)
    {
        $this->len = $len;
    }

    public function generate(): string
    {
        $a = str_split($this->chars);
        $p = '';

        for ($i=0; $i<$this->len; $i++) {
            $rand_index = rand(0, sizeof($a)-1);
            $p .= $a[$rand_index];
        }

        return $p;
    }
}