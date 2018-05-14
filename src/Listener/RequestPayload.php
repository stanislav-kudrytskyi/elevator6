<?php
/**
 * @copyright Dukascopy
 * @author Stanislav Kudrytskyi <stanislav.kudrytskyi@dukascopy.com>
 * Date: 5/14/2018
 * Time: 3:03 PM
 */

namespace App\Listener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestPayload implements EventSubscriberInterface
{
    protected static $priority = -512;

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', static::$priority,]
        ];
    }

    public function onKernelRequestst(GetResponseEvent $event): void
    {
        $request = $event->getRequest();

        if (0 !== strpos($request->headers->get('Content-Type'), 'application/json')) {
            return;
        }

        $data = json_decode($request->getContent(), true);
        $request->request->replace(\is_array($data) ? $data : []);
    }
}