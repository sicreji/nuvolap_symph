<?php

namespace App\Custom;

class Proverb
{
    // propriétés
    private $body;
    private $lang;

    // méthodes
    // constructeur
    public function __construct(string $body, string $lang)
    {
        // hydratation
        $this->body = $body;
        $this->lang = $lang;
    }

    // accesseurs (getters)
    public function getBody(): string
    {
        return $this->body;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    // mutateurs (setters)
    public function setBody(string $body): string
    {
        $this->body = $body;
        return $this->body;
    }

    public function setLang(string $lang): string
    {
        $this->lang = $lang;
        return $this->lang;
    }

    // autres méthodes (helpers)
    public function getShortBody(int $len): string
    {
        return substr($this->body, 0, $len) . '...';
    }
}