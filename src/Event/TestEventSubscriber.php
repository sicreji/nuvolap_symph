<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TestEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            TestEvent::NAME => 'onTestEvent',
        ];
    }

    public function onTestEvent(TestEvent $event)
    {
        //dd($event);
    }
}