<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\Rendering;


use Sourcekin\Components\DependencyInjection\Resolver;

class ProcessList {

    protected $resolver;
    protected $dependencies = [];
    /**
     * @var Processable[]
     */
    protected $callables = [];

    /**
     * ProcessList constructor.
     *
     * @param $resolver
     */
    public function __construct(Resolver $resolver = NULL) {
        $this->resolver = $resolver ?? new Resolver();
    }


    public function add(Processable $processable) {
        $this->dependencies[$processable->name()] = $processable->dependencies();
        isset($this->callables[$processable->name()]) or $this->callables[$processable->name()] = [];
        $this->callables[$processable->name()][] = $processable;
    }

    public function execute() {
        $resolved = $this->resolver->resolve($this->dependencies);
        foreach ($resolved->getResolved() as $name) {
            foreach ($this->callables[$name] as $callable) {
                $callable();
            }
        }
    }

}