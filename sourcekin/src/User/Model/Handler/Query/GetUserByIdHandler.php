<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 30.06.18
 *
 */

namespace Sourcekin\User\Model\Handler\Query;

use React\Promise\Deferred;
use Sourcekin\User\Model\Query\GetUserById;
use Sourcekin\User\Projection\UserFinder;

class GetUserByIdHandler
{
    /**
     * @var UserFinder
     */
    protected $finder;

    /**
     * GetUserByIdHandler constructor.
     *
     * @param UserFinder $finder
     */
    public function __construct(UserFinder $finder) { $this->finder = $finder; }

    public function __invoke(GetUserById $query, Deferred $deferred = null)
    {
        $user = $this->finder->findById($query->userId());
        if (!$deferred) {
            return $user;
        }

        $deferred->resolve($user);
    }


}