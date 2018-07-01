<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 18.06.18
 *
 */

namespace SourcekinBundle\Command;

use Prooph\Common\Messaging\MessageFactory;
use Sourcekin\Components\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;
use Sourcekin\User\Model\Command\ChangeEmail;
use Sourcekin\User\Model\Command\RegisterUser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeUserCommand extends Command
{
    /**
     * @var CommandBus
     */
    protected $bus;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * MakeUserCommand constructor.
     *
     * @param CommandBus $bus
     */
    public function __construct(CommandBus $bus) {
        $this->bus = $bus;
        parent::__construct();
    }


    protected function configure()
    {
        $this->setName('sourcekin:make:user');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->bus->dispatch(
            new RegisterUser([
                    'username' => 'karlheinz',
                    'email'    => 'karlheinz@sourcekin.de',
                    'password' => '12345',
                ]
            )
        );

    }


}