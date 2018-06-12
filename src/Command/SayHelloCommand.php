<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace App\Command;


use Sourcekin\Command\SayHello;
use Sourcekin\Event\SaidHello;
use Sourcekin\EventHandling\CommandBus;
use Sourcekin\EventHandling\MessageReceivingInterface;
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
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * SayHelloCommand constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus) {
        $this->commandBus = $commandBus;
        parent::__construct();
    }

    protected function configure() {
        $this->setName('say:hello');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->io = new SymfonyStyle($input, $output);
        $this->commandBus->dispatch(new SayHello($this->io->ask('name?')));
    }

    public function onMessageReceived($message) {
        if( $message instanceof SaidHello ) {
            $this->io->success(sprintf('Said hello to %s.', $message->name()));
        }
    }
}