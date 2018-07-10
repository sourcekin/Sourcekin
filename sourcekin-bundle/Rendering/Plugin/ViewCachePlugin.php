<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 10.07.18
 *
 */

namespace SourcekinBundle\Rendering\Plugin;

use Sourcekin\Components\PlugIn\AbstractPlugin;
use Sourcekin\Components\PlugIn\SupportsPlugins;
use Sourcekin\Components\Rendering\Events\FinishView;
use Sourcekin\Components\Rendering\Events\GetContentView;
use Sourcekin\Components\Rendering\Events\RenderingEvents;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class ViewCachePlugin extends AbstractPlugin
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * ViewCachePlugin constructor.
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter) { $this->adapter = $adapter; }


    /**
     * @param SupportsPlugins $subject
     */
    public function subscribe(SupportsPlugins $subject)
    {
        $this->listenerHandlers[] = $subject->attach(RenderingEvents::VIEW, [$this, 'onView']);
        $this->listenerHandlers[] = $subject->attach(RenderingEvents::FINISH_VIEW, [$this, 'onFinishView']);

    }

    public function onView(GetContentView $event)
    {
        $item = $this->adapter->getItem((string)$event->getContent()->id());
        if($item->isHit()) $event->setView($item->get());

    }

    public function onFinishView(FinishView $event)
    {
        $view = $event->getView();
        $item = $this->adapter->getItem((string)$view->id());

        if( ! $item->isHit()) {
            $item->set($view)->expiresAfter(60);
            $this->adapter->save($item);
        }
    }
}