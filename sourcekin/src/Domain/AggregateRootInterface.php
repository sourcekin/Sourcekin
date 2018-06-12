<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 12.06.18.
 */

namespace Sourcekin\Domain;


interface AggregateRootInterface {
    /**
     * @return EventStream
     */
    public function getUncommittedEvents(): EventStream;

    /**
     * @return string
     */
    public function getAggregateRootId(): string;
}