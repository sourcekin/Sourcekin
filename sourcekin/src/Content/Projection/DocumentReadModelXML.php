<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 26.06.18
 *
 */

namespace Sourcekin\Content\Projection;

use Prooph\EventStore\Projection\AbstractReadModel;

class DocumentReadModelXML extends AbstractReadModel
{

    protected $storageUrl;

    /**
     * DocumentReadModelXML constructor.
     *
     * @param $storageUrl
     */
    public function __construct($storageUrl) {
        $this->storageUrl = $storageUrl;
    }


    public function init(): void
    {
        mkdir($this->storageUrl, 0777, true);
    }

    public function isInitialized(): bool
    {
        return file_exists($this->storageUrl) && is_writable($this->storageUrl);
    }

    public function reset(): void
    {
        array_map(function($file){ unlink($file); }, glob($this->storageUrl.'/*') );
    }

    public function delete(): void
    {
        $this->reset();
        rmdir($this->storageUrl);
    }

    protected function xmlDocument()
    {
        $document = new \DOMDocument();
        $document->standalone = true;
        $document->preserveWhiteSpace;
        return $document;
    }

    public function insert($data)
    {
        $document = $this->xmlDocument();
        $document->appendChild($node = $document->createElement('Document'));
        $node->setAttribute('id', $data['id']);
        $node->setIdAttribute('id', true);
        $node->appendChild($document->createElement('Title', $data['title']));
        $node->appendChild($document->createElement('Text', $data['text']));
        $node->appendChild($document->createElement('Elements'));

        $fileName = sprintf('%s/%s.xml', $this->storageUrl, $data['id']);
        $document->save($fileName);
    }

    public function addContent($data)
    {
        $fileName = sprintf('%s/%s.xml', $this->storageUrl, $data['id']);
        $document = $this->xmlDocument();
        $document->load($fileName);

        $content  = $document->createElement('Content');
        $content->setAttribute('id', $data['content_id']);
        $content->setIdAttribute('id', true);
        $content->setAttribute('type', $data['type']);
        $content->setAttribute('index', $data['index']);
        if( $data['parent'] !== $data['id'])
            $content->setAttribute('parent', $data['parent']);

        $content->appendChild($document->createElement('Elements'));
        $content->appendChild($document->createElement('Fields'));
        $document->getElementsByTagName('Elements')->item(0)->appendChild($content);

        $document->save($fileName);


    }

    public function addField($data)
    {
        $fileName = sprintf('%s/%s.xml', $this->storageUrl, $data['id']);
        $document = $this->xmlDocument();
        $document->load($fileName);

        $field = $document->createElement('Field', $data['value']);
        $field->setAttribute('id', $data['content_id'] .'-'. $data['name']);
        $field->setIdAttribute('id', true);
        $field->setAttribute('name', $data['name']);
        $field->setAttribute('type', $data['type']);

        $content = (new \DOMXPath($document))->query(sprintf('//Content[@id="%s"]', $data['content_id']))->item(0);  //$document->getElementById($data['content_id']);
        $content->getElementsByTagName('Fields')->item(0)->appendChild($field);

        $document->save($fileName);
    }
}