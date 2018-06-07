<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 06.06.18
 *
 */

namespace App\Command;


use Sourcekin\Domain\Command\HelloCommand;
use Sourcekin\Domain\Command\SayHello;
use Sourcekin\Domain\Message\BusInterface;
use Sourcekin\Domain\Message\MessageBusInterface;
use Sourcekin\Infrastructure\Messenger\MessageReceivingInterface;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SayHelloCommand extends Command implements MessageReceivingInterface
{

    /**
     * @var BusInterface
     */
    protected $bus;

    /** @var ConsoleStyle */
    protected $io;

    /**
     * SayHelloCommand constructor.
     *
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus) {
        parent::__construct();
        $this->bus = $bus;
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
        $this->io->success('Received: ' . get_class($message));
    }


}