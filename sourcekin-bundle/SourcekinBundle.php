<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace SourcekinBundle;

use SourcekinBundle\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SourcekinBundle extends Bundle {
    public function build(ContainerBuilder $container) {
        parent::build($container);
    }

    public function getContainerExtension() {
        return new Extension();
    }


}