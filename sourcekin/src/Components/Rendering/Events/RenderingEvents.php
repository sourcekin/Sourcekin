<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 03.07.18
 *
 */

namespace Sourcekin\Components\Rendering\Events;

class RenderingEvents
{
    const VIEW         = 'content.view';
    const CONTROL      = 'content.control';
    const BUILD_VIEW   = 'content.build_view';
    const FINISH_VIEW  = 'content.finish_view';
    const PRE_RENDER   = 'content.pre_render';
    const RENDER       = 'content.render';
    const START_RENDER = 'content.start_render';
    const STOP_RENDER  = 'content.stop_render';
    const POST_RENDER  = 'content.post_render';

}