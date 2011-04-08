<?php
namespace {{ namespace }}\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Command\Command;

class {{ class }}Command extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('{{ command }}')
            ->setDescription('command description')
            ->setDefinition(array(
                new InputArgument('arg1', InputArgument::REQUIRED, 'arg1 description'),
                new InputArgument('arg2', InputArgument::OPTIONAL, 'arg2 description'),
                new InputOption('opt1', null, InputOption::VALUE_OPTIONAL, 'option1 description', 'default value'),
            ))
            ->setHelp(<<<EOT
<info>{{ command }}</info> *command help here*
EOT
            )
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $arg1 = $input->getArgument('arg1');
        // $opt1 = $input->getOption('opt1');

        $output->writeln('Command <info>{{ command }}</info> executed!');
    }
}
