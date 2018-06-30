<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 30.06.18.
 */

namespace Sourcekin\Components\DependencyInjection;


use Prooph\EventSourcing\Aggregate\AggregateTranslator;

interface Dependencies {

    /**
     * @return \PDO
     */
    public function pdo();

    /**
     * @return AggregateTranslator
     */
    public function aggregateTranslator();



}