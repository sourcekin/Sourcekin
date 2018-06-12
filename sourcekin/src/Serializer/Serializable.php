<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 12.06.18.
 */

namespace Sourcekin\Serializer;


interface Serializable {
    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data);

    /**
     * @return array
     */
    public function serialize(): array;
}