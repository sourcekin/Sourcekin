<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace App\Command;


use Sourcekin\Domain\Command\SayHello;
use Sourcekin\Domain\Message\MessageBusInterface;
use Sourcekin\Domain\Message\MessageReceivingInterface;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SayHelloCommand extends Command implements MessageReceivingInterface  {

    /**
     * @var ConsoleStyle
     */
    protected $io;
    /**
     * @var MessageBusInterface
     */
    protected $commandBus;

    /**
     * SayHelloCommand constructor.
     *
     * @param MessageBusInterface $commandBus
     */
    public function __construct(MessageBusInterface $commandBus) {
        $this->commandBus = $commandBus;
        parent::__construct();
    }

    protected function configure() {
        $this->setName('say:hello');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->io = new SymfonyStyle($input, $output);
        $this->commandBus->dispatch(new SayHello());
    }

    public function onMessageReceived($message) {
        $this->io->writeln(get_class($message));
    }
}