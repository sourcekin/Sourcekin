<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 03.07.18
 *
 */

namespace Sourcekin\Components\Rendering\View;

class ViewFactory
{
    public function makeDocumentView()
    {
        return new DocumentView();
    }

    public function makeContentView()
    {
        return new ContentView();
    }
}