<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\DependencyInjection;


class ResolvedDependencies {

    protected $resolved   = [];
    protected $unresolved = [];

    /**
     * ResolvedDependencies constructor.
     *
     * @param array $resolved
     * @param array $unresolved
     */
    public function __construct(array $resolved, array $unresolved) {
        $this->resolved   = array_unique($resolved);
        $this->unresolved = array_unique($unresolved);
    }

    /**
     * @return array
     */
    public function getResolved(): array {
        return $this->resolved;
    }

    /**
     * @return array
     */
    public function getUnresolved(): array {
        return $this->unresolved;
    }

    public function isFullyResolved() {
        return empty($this->unresolved);
    }

}