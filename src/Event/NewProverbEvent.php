<?php
namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;
use \App\Entity\Proverb;


class NewProverbEvent extends Event
{
    public const NAME = "app.proverb.new";
    private $proverb;

    public function __construct(Proverb $proverb)
    {
        $this->proverb = $proverb;
    }

    public function getProverb(): Proverb
    {
        return $this->proverb;
    }
}