<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 09.07.18
 *
 */

namespace SourcekinBundle\Controller;

use React\Promise\Promise;
use Sourcekin\Components\Promise\Await;
use Sourcekin\Components\ServiceBus\QueryBus;
use Sourcekin\Content\Model\Query\GetDocumentById;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Stopwatch\Stopwatch;

class FrontendController
{

    /**
     * @var QueryBus
     */
    protected $queryBus;

    /**
     * @var Stopwatch
     */
    protected $stopwatch;

    /**
     * FrontendController constructor.
     *
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus) { $this->queryBus = $queryBus; }

    /**
     * @return Stopwatch
     */
    public function getStopwatch(): Stopwatch
    {
        return $this->stopwatch;
    }

    /**
     * @param Stopwatch $stopwatch
     *
     * @return $this
     */
    public function setStopwatch($stopwatch)
    {
        $this->stopwatch = $stopwatch;

        return $this;
    }



    public function documentAction($id, Request $request)
    {
        /** @var Promise $promise */

        $promise  = $this->queryBus->dispatch(new GetDocumentById($id));
        $response = Response::create((string)(new Await($promise)));
        return $response;
    }
}