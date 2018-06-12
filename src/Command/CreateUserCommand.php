<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 12.06.18
 *
 */

namespace App\Command;

use Sourcekin\Command\RegisterUser;
use Sourcekin\Event\UserRegistered;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateUserCommand extends MessageReceivingCommand
{
    /**
     * @var ConsoleStyle
     */
    protected $io;

    protected function configure()
    {
        $this->setName('user:create')
        ->addArgument('username')
        ->addArgument('password')
        ->addArgument('email');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = $io = new SymfonyStyle($input, $output);
        $command = new RegisterUser($input->getArgument('username'), $input->getArgument('password'), $input->getArgument('email'));
        $this->commandBus->dispatch($command);

    }


    public function onMessageReceived($message)
    {
        if($message instanceof UserRegistered) {
            $this->io->success(sprintf('User "%s" registered.', $message->username()));
        }
    }
}