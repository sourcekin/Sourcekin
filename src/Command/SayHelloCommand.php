<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace App\Command;

use Sourcekin\Domain\Command\SayHello;
use Sourcekin\Domain\Message\DomainBusInterface;
use Sourcekin\Domain\Message\MessageReceivingInterface;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SayHelloCommand extends Command implements MessageReceivingInterface
{

    /**
     * @var DomainBusInterface
     */
    protected $bus;

    /**
     * @var ConsoleStyle
     */
    protected $io;

    /**
     * SayHelloCommand constructor.
     *
     * @param DomainBusInterface $bus
     */
    public function __construct(DomainBusInterface $bus) {
        $this->bus = $bus;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('say:hello');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->bus->dispatch(new SayHello());
    }

    public function onMessageReceived($message)
    {
        $this->io->success(get_class($message));
    }
}