<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

namespace SourcekinBundle\Command;

use Broadway\CommandHandling\CommandBus;
use Broadway\UuidGenerator\UuidGeneratorInterface;
use Sourcekin\User\Command\Enable;
use Sourcekin\User\Command\SignUp;
use SourcekinBundle\Util\CommandHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SignUpCommand extends Command
{
    /**
     * @var CommandBus
     */
    protected $bus;

    /**
     * @var UuidGeneratorInterface
     */
    protected $generator;

    /**
     * SignUpCommand constructor.
     *
     * @param CommandBus             $bus
     * @param UuidGeneratorInterface $generator
     */
    public function __construct(CommandBus $bus, UuidGeneratorInterface $generator)
    {
        $this->bus       = $bus;
        $this->generator = $generator;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName(CommandHelper::prefix('make:user'))
             ->addArgument('username', InputArgument::REQUIRED)
             ->addArgument('email', InputArgument::REQUIRED)
            ->addOption('password', 'p', InputOption::VALUE_OPTIONAL)
            ->addOption('first-name', 'fn', InputOption::VALUE_OPTIONAL)
            ->addOption('last-name', 'ln', InputOption::VALUE_OPTIONAL)
            ->addOption('enable', null, InputOption::VALUE_OPTIONAL)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io      = new SymfonyStyle($input, $output);
        $id      = $this->generator->generate();
        $command = new SignUp(
            $id,
            $input->getArgument('username'),
            $input->getArgument('email'),
            $input->getOption('password') ?: $io->askHidden('password?'),
            $input->getOption('first-name') ?: $io->ask('first name?'),
            $input->getOption('last-name') ?: $io->ask('last name?')
        );

        $this->bus->dispatch($command);

        if( $input->hasOption('enable')) {
            $this->bus->dispatch(new Enable($id));
        }

    }


}