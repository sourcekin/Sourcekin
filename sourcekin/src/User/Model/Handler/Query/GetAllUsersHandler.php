<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 30.06.18
 *
 */

namespace Sourcekin\User\Model\Handler\Query;

use React\Promise\Deferred;
use Sourcekin\User\Model\Query\GetAllUsers;
use Sourcekin\User\Projection\UserFinder;

class GetAllUsersHandler
{
    /**
     * @var UserFinder
     */
    protected $finder;

    /**
     * GetAllUsersHandler constructor.
     *
     * @param UserFinder $finder
     */
    public function __construct(UserFinder $finder) { $this->finder = $finder; }


    public function __invoke(GetAllUsers $query, Deferred $deferred = null)
    {
        $users = $this->finder->findAll();
        if( ! $deferred ) return $users;
        $deferred->resolve($users);
    }
}