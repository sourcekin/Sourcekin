<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\DependencyInjection;


class Resolver {

    public function resolve($dependencies) {
        $resolved = $unresolved = [];
        foreach (array_keys($dependencies) as $table) {
            list ($resolved, $unresolved) = $this->doResolve($table, $dependencies, $resolved, $unresolved);
        }

        return new ResolvedDependencies($resolved, $unresolved);
    }


    /**
     * Recursive dependency resolution
     *
     * @param string $item       Item to doResolve dependencies for
     * @param array  $items      List of all items with dependencies
     * @param array  $resolved   List of resolved items
     * @param array  $unresolved List of unresolved items
     *
     * @return array
     */
    function doResolve($item, array $items, array $resolved, array $unresolved) {

        $unresolved = $this->addToUnresolved($item, $unresolved);

        if (!$this->isResolvable($item, $items)) {
            return [$resolved, $unresolved];
        }

        foreach ($items[$item] as $dep) {
            if ($this->isResolved($resolved, $dep)) {
                continue;
            }

            $this->throwCircularReferenceUnless($this->isUnresolved($unresolved, $dep), $item, $dep);

            list($resolved, $unresolved) = $this->doResolve(
                $dep,
                $items,
                $resolved,
                $this->addToUnresolved($dep, $unresolved)
            );
        }

        return [
            $this->addtoResolved($resolved, $item),
            $this->removeFromUnresolved($item, $unresolved),
        ];
    }

    protected function addtoResolved($haystack, $needle) {
        if (!in_array($needle, $haystack)) {
            array_push($haystack, $needle);
        }

        return $haystack;

    }

    protected function throwCircularReferenceUnless($condition, $item, $dep) {
        if ($condition) {
            throw CircularReference::forDependencies($item, $dep);
        }
    }

    /**
     * @param       $item
     * @param array $unresolved
     *
     * @return array
     */
    protected function removeFromUnresolved($item, array $unresolved): array {
        while (($index = array_search($item, $unresolved)) !== FALSE) {
            unset($unresolved[$index]);
        }

        return $unresolved;
    }

    /**
     * @param $dep
     *
     * @param $unresolved
     *
     * @return mixed
     */
    protected function addToUnresolved($dep, $unresolved) {
        array_push($unresolved, $dep);

        return $unresolved;
    }

    /**
     * @param array $resolved
     * @param       $dep
     *
     * @return bool
     */
    protected function isResolved(array $resolved, $dep): bool {
        return in_array($dep, $resolved);
    }

    /**
     * @param       $item
     * @param array $items
     *
     * @return bool
     */
    protected function isResolvable($item, array $items): bool {
        return isset($items[$item]);
    }

    /**
     * @param array $unresolved
     * @param       $dep
     *
     * @return bool
     */
    protected function isUnresolved(array $unresolved, $dep): bool {
        return in_array($dep, $unresolved);
}
}