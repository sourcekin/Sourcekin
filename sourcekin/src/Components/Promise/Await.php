<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 09.07.18
 *
 */

namespace Sourcekin\Components\Promise;

use React\Promise\Promise;

class Await
{
    /**
     * @var Promise
     */
    protected $promise;

    /**
     * @var bool
     */
    protected $resolved = false;

    /**
     * @var null
     */
    protected $content = null;

    /**
     * Await constructor.
     *
     * @param Promise $promise
     */
    public function __construct(Promise $promise)
    {
        $this->promise = $promise;
    }


    public function __invoke()
    {
        $this->promise
            ->then(
                function ($result) {
                    $this->content = $result;
                }
            )->otherwise(
                function ($reason) {
                    $this->content = $reason;
                }
            )
            ->always(
                function () {
                    $this->resolved = true;
                }
            )
        ;

        while (!$this->resolved) {
            usleep(3);
        }

        return $this->content;
    }

    public function __toString()
    {
        return (string)$this->__invoke();
    }

}