<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace SourcekinBundle\ReadModel\User;

use Sourcekin\User\ReadModel\LoginUserProjector;

class SecurityUserProjector extends LoginUserProjector
{
    protected function getReadModel($id)
    {
        if( null === $model = $this->repository->find($id)) {
            $model = new SecurityUser($id);
        }
        return $model;
    }


}