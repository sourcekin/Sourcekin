<?php 
namespace Sourcekin\Content;

use Sourcekin\Module;

class ContentModule extends Module
{
    const STREAM_NAME = 'content_stream';

    /**
     * Return your Repositories here.
     */
    public static function repositories(): array
    {
        return [];
    }


    /**
     * Return your Projections here.
     */
    public static function projections(): array
    {
        return [];
    }


    /**
     * Return your EventRoutes here.
     */
    public static function eventRoutes(): array
    {
        return [];
    }
}
