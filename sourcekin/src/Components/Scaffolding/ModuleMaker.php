<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Components\Scaffolding;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpNamespace;
use Sourcekin\Application;

class ModuleMaker
{
    protected static $folders = [
        '/Infrastructure',
        '/Model/Command',
        '/Model/Event',
        '/Model/Query',
        '/Model/Handler',
        '/Projection',
        '/ProcessManager',
    ];

    public function generateScaffold($module, $streamName)
    {
        $module    = ucfirst($module);
        $base      = Application::path(sprintf('/%s', ucfirst($module)));
        $namespace = Application::ns(sprintf('Sourcekin.%s', ucfirst($module)));

        foreach (static::$folders as $folder) {
            mkdir($base.$folder, 0755, true);
        }

        file_put_contents(
            sprintf('%s/%sModule.php', $base, $module),
            '<?php '. PHP_EOL. $this->generateModuleClass($module, $streamName, $namespace)
            );
    }

    protected function generateModuleClass($module, $streamName, $ns)
    {
        $namespace = new PhpNamespace($ns);
        $namespace->addUse('Sourcekin\Module');
        $class = $namespace->addClass($module . 'Module');
        $class->addExtend('Sourcekin\Module');
        $class->addConstant('STREAM_NAME', $streamName);

        $emptyBody = 'return [];';
        foreach (['repositories', 'projections', 'eventRoutes'] as $methodName) {
            $class->addMethod($methodName)
                  ->setStatic()
                  ->addBody($emptyBody)
                  ->setReturnType('array')
                ->addComment(sprintf('Return your %s here.', ucfirst($methodName)))
            ;
        }
        return Helpers::tabsToSpaces((string)$namespace);
    }
}