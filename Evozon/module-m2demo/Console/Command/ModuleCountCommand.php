<?php

namespace Evozon\M2Demo\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\Module\ModuleListInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleCountCommand extends Command
{
    private const COMMAND_NAME = 'module:count';

    /**
     * @var ModuleListInterface
     */
    private ModuleListInterface $moduleList;

    public function __construct(ModuleListInterface $moduleList)
    {
        $this->moduleList = $moduleList;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Returns the number of modules');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Count of modules:</info>');
        $this->showCountModules($output);
        $output->writeln('');
    }

    private function showCountModules(OutputInterface $output)
    {
        $count = $this->countModules();
        if (!$count) {
            $output->writeln('None');
            return Cli::RETURN_FAILURE;
        }

        $output->writeln($count);
        return Cli::RETURN_SUCCESS;
    }

    private function countModules(): int
    {
        return count($this->moduleList->getAll());
    }

}
