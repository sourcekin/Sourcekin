<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

namespace Sourcekin\User\ReadModel;

use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;
use Sourcekin\User\Event\UserSignedUp;
use Sourcekin\User\Event\UserWasEnabled;

class LoginUserProjector extends Projector
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * LoginUserProjector constructor.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository) {
        $this->repository = $repository;
    }

    public function applyUserSignedUp(UserSignedUp $signedUp)
    {
        $model = $this->getReadModel($signedUp->getId());
        $model->assignCredentials($signedUp->getUsername(), $signedUp->getPassword());

        $this->repository->save($model);
    }

    public function applyUserWasEnabled(UserWasEnabled $event)
    {
        $model = $this->getReadModel($event->getId());
        $model->enable();
        $this->repository->save($model);
    }

    /**
     * @param $id
     *
     * @return \Broadway\ReadModel\Identifiable|null|LoginUser
     */
    protected function getReadModel($id)
    {
        if( null === $model = $this->repository->find($id)) {
            $model = new LoginUser($id);
        }
        return $model;
    }


}