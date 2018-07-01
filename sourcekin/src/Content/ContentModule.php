<?php
namespace Sourcekin\Content;

use Sourcekin\Content\Model\Command\AddContent;
use Sourcekin\Content\Model\Command\AddContentHandler;
use Sourcekin\Content\Model\Command\AddField;
use Sourcekin\Content\Model\Command\AddFieldHandler;
use Sourcekin\Content\Model\Command\InitializeDocument;
use Sourcekin\Content\Model\Command\InitializeDocumentHandler;
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

    static public function commandRoutes()
    {
        return [
            InitializeDocument::class => InitializeDocumentHandler::class,
            AddContent::class         => AddContentHandler::class,
            AddField::class           => AddFieldHandler::class,
        ];
    }

    static public function queryRoutes()
    {
        return [];
    }
}
