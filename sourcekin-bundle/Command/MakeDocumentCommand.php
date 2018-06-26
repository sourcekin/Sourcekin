<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 26.06.18
 *
 */

namespace SourcekinBundle\Command;

use Sourcekin\Content\Model\Document;
use Sourcekin\Content\Model\DocumentRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeDocumentCommand extends Command
{

    /**
     * @var DocumentRepository
     */
    protected $repository;

    /**
     * MakeDocumentCommand constructor.
     *
     * @param DocumentRepository $repository
     */
    public function __construct(DocumentRepository $repository) {
        $this->repository = $repository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('sourcekin:make-document')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $document = Document::initialize(uniqid('name '), uniqid('title '), 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eros lorem, rutrum a pulvinar ut, dictum et mauris. Praesent quam diam, malesuada at gravida sed, scelerisque in tortor. Vestibulum vehicula, dui non dictum tempor, erat nisi placerat nisl, at sollicitudin nunc nibh eu diam. Phasellus neque massa, scelerisque in cursus quis, semper a justo. Maecenas pulvinar adipiscing tellus ac ornare. Integer sed lacus sapien. Ut ac porta risus. ');
        $index    = 0;
        $document->addContent($identifer1 = uniqid('content-'), 'textbox', $index, $document->id());
        $identifier2 = uniqid('content-');
        $document->addContent($identifier2, 'textbox', $index, $identifer1);

        $document->addField($identifer1, 'my-text-field', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur luctus lacus eros. Mauris tortor lacus, condimentum nec eleifend in, aliquet ut metus. Sed varius tellus vitae nisi congue eu fringilla tellus aliquet. Nulla suscipit porttitor velit, id lobortis orci congue at. Nunc a dolor nulla. Integer quis dignissim ante.  ', 'text');
        $document->addField($identifier2, 'my-image', 'http://example.com/some-image.jpg', 'image');
        $document->addField($identifer1, 'my-image', 'http://example.com/some-other-image.jpg', 'image');

        $this->repository->save($document);

    }


}