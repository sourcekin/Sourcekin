<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 08.07.18.
 */

namespace SourcekinBundle\Rendering;


use Sourcekin\Components\Rendering\Control\ContentControl;
use Symfony\Component\DependencyInjection\ServiceLocator;

class ControlCollection extends ServiceLocator implements \Sourcekin\Components\Rendering\ControlCollection  {

    /**
     * @param $name
     *
     * @return bool
     */
    public function contains($name): bool {
        return $this->has($name);
    }

    /**
     * @param $name
     *
     * @return ContentControl
     */
    public function acquire($name): ContentControl {
        return $this->get($name);
    }
}