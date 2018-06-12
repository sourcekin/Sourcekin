<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 12.06.18.
 */

namespace Sourcekin\Domain;


use Sourcekin\Serializer\Serializable;

class Metadata implements Serializable {
    private $values = [];

    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    /**
     * Helper method to construct an instance containing the key and value.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return Metadata
     */
    public static function kv($key, $value): self
    {
        return new self([$key => $value]);
    }

    /**
     * Merges the values of this and the other instance.
     *
     * @param Metadata $otherMetadata
     *
     * @return Metadata a new instance
     */
    public function merge(self $otherMetadata): self
    {
        return new self(array_merge($this->values, $otherMetadata->values));
    }

    /**
     * Returns an array with all metadata.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->values;
    }

    /**
     * Get a specific metadata value based on key.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->values[$key] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): array
    {
        return $this->values;
    }

    /**
     * @param array $data
     *
     * @return Metadata
     */
    public static function deserialize(array $data): self
    {
        return new self($data);
    }
}