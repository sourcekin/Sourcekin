<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 30.06.18.
 */

namespace SourcekinBundle\Command;


use SourcekinBundle\Configuration\Directories;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class ConfigureSupervisorCommand extends Command {

    protected $confDir;
    protected $projections = [];
    protected $projectDir;
    protected $logDir;
    protected $binDir;

    protected $projectionsTemplate = [
        '[program:sourcekin-{{name}}-projection]',
        'diretory={{project_dir}}',
        'command=/usr/bin/php {{bin_dir}}/console sourcekin:projection:run {{name}}',
        'startretries={{retries}}',
        'startsecs=0',
        'stderr_logfile={{log_dir}}/{{name}}-projections.err',
    ];
    /**
     * @var Directories
     */
    protected $directories;
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * ConfigureSupervisorCommand constructor.
     *
     * @param array $projections
     * @param       $confDir
     * @param       $projectDir
     * @param       $logDir
     * @param       $binDir
     */
    public function __construct(Directories $directories, Filesystem $filesystem, array $projections, $confDir) {
        $this->confDir     = $confDir;
        $this->projections = $projections;
        $this->directories = $directories;
        $this->filesystem  = $filesystem;
        parent::__construct();
    }


    protected function configure() {
        $this
            ->setName('sourcekin:supervisor:configure')
            ->addOption('name', NULL, InputOption::VALUE_OPTIONAL, '', 'my-supervisor')
            ->addOption('retries', NULL, InputOption::VALUE_OPTIONAL, '', 5)
            ->addOption('symlink-target', null, InputOption::VALUE_OPTIONAL, '', '/etc/supervisor/conf.d')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $io          = new SymfonyStyle($input, $output);
        $fileName    = sprintf('%s/%s.conf', $this->confDir, $input->getOption('name'));
        $definitions = [];
        foreach ($this->projections as $projection) {
            $placeholders = $this->placeholders($input, $projection);

            $definitions = array_merge(
                $definitions,
                array_map(
                    function ($line) use ($placeholders) { return strtr($line, $placeholders); },
                    $this->projectionsTemplate
                )
            );
        }

        file_put_contents($fileName, implode(PHP_EOL, $definitions));
        $io->success(sprintf('generated <info>%s</info>', $fileName));

        $linkTarget = sprintf('%s/%s', $input->getOption('symlink-target'), basename($fileName));
        $io->writeln(sprintf('symlinking <info>%s</info> to <info>%s</info>', $fileName, $linkTarget));
        $this->filesystem->symlink($fileName, $linkTarget);

        $io->success('done');

    }

    /**
     * @param InputInterface $input
     * @param                $projection
     *
     * @return array
     */
    protected function placeholders(InputInterface $input, $projection): array {
        $placeholders = [
            '{{name}}'        => $projection,
            '{{project_dir}}' => $this->directories->home(),
            '{{bin_dir}}'     => $this->directories->bin(),
            '{{log_dir}}'     => $this->directories->log(),
            '{{retries}}'     => (int)$input->getOption('retries'),
        ];

        return $placeholders;
    }


}