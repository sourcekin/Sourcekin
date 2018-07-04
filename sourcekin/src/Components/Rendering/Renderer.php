<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 03.07.18
 *
 */

namespace Sourcekin\Components\Rendering;

use Sourcekin\Components\Events\EventDispatcher;
use Sourcekin\Components\Rendering\Views\DocumentView;
use Sourcekin\Components\Rendering\Views\ViewFactory;

class Renderer
{
    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * @var ViewFactory
     */
    protected $viewFactory;


    public function render($contents)
    {
        $document = $this->viewFactory->makeDocumentView();

        // resolve content handlers

        // call each content handler with individual content and context (Document-View?)

        //
    }


}