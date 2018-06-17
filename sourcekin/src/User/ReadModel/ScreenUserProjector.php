<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace Sourcekin\User\ReadModel;

use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;
use Sourcekin\User\Event\UserSignedUp;

class ScreenUserProjector extends Projector
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
        $model->applySignedUp($signedUp);

        $this->repository->save($model);
    }

    protected function getReadModel($id)
    {
        if( ! $model = $this->repository->find($id)) {
            $model = new ScreenUser($id);
        }
        return $model;
    }
}