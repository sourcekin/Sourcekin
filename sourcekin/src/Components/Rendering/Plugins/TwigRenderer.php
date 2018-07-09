<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.07.18.
 */

namespace Sourcekin\Components\Rendering\Plugins;


use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\PlugIn\AbstractPlugin;
use Sourcekin\Components\PlugIn\SupportsPlugins;
use Sourcekin\Components\Rendering\Events\RenderingEvents;
use Sourcekin\Components\Rendering\Events\RenderNode;
use Sourcekin\Components\Rendering\View\ViewNode;

class TwigRenderer extends AbstractPlugin {

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    protected $theme = 'default';

    /**
     * TwigRenderer constructor.
     *
     * @param \Twig_Environment $twig
     * @param string            $theme
     */
    public function __construct(\Twig_Environment $twig, string $theme = 'default') {
        $this->twig  = $twig;
        $this->theme = $theme;
    }


    /**
     * @param SupportsPlugins $subject
     */
    public function subscribe(SupportsPlugins $subject) {
        $this->listenerHandlers[] = $subject->attach(RenderingEvents::RENDER, [$this, 'renderView']);
    }

    public function renderView(RenderNode $event) {
        $node    = $event->node();
        $context = $event->context();
        try {
            $content = $this->loadAndRenderTemplate($node, $context);
            $node->setContent($content);
        }
        catch (\Throwable $throwable) {
            $node->setContent($throwable);
        }
    }

    /**
     * @param ViewNode $node
     * @param HashMap  $context
     *
     * @return string
     * @throws \Throwable
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function loadAndRenderTemplate(ViewNode $node, HashMap $context) {
        return $this
            ->twig
            ->loadTemplate($this->getTemplateName($node))
            ->render(
                [
                    'vars'       => $node->toArray(),
                    'context'    => $context->toArray(),
                    '_children_' => $node->children(),
                ]
            )
            ;
    }

    protected function getTemplateName(ViewNode $node) {
        return sprintf('@%s/%s.html.twig', $this->theme, (string)$node->type());
    }
}