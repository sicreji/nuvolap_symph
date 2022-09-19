<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;

class ProverbSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            NewProverbEvent::NAME => 'onNewProverbEvent',
        ];
    }

    public function onNewProverbEvent(NewProverbEvent $event)
    {
        $fs = new Filesystem();
        $today = date("Y-m-d H:i:s");
        $content = $today . "\t" . $event->getProverb()->getId() . "\n";
        $fs->appendToFile('/tmp/proverbs.log', $content, );
    }
}