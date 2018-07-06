<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\Rendering;


interface Processable {

    public function name();
    public function dependencies();
    public function __invoke();
}