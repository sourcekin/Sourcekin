<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Exception;

use Throwable;

class UnsupportedClass extends \InvalidArgumentException
{
    public function __construct(string $className = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf('The given class "%s" is not supported.', $className), $code,$previous);
    }

}