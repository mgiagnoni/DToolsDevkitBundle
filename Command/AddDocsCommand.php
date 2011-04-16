<?php
namespace DTools\DevkitBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

class AddDocsCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('devkit:add-docs')
            ->setDescription('Creates sample documentation inside a bundle.')
            ->setDefinition(array(
                new InputArgument('bundle', InputArgument::REQUIRED, 'Bundle name'),
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, 'Documentation template', 'default'),
            ))
            ->setHelp(<<<EOT
The <info>devkit:add-docs</info> command creates sample documentation inside the <info>Resources/doc/</info> folder of a given bundle.
EOT
            )
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bundle = $this->container->get('kernel')->getBundle($input->getArgument('bundle'));
        $docFolder = $bundle->getPath() . '/Resources/doc/';
        if (file_exists($docFolder . 'index.rst')) {
            throw new \RuntimeException(sprintf('A documentation index file already exists in bundle "%s".', $bundle->getName()));
        }

        $this->renderTemplate('doc', $input->getOption('template'), $bundle->getPath(), $docFolder, array(
            'namespace' => $bundle->getNamespace(),
            'bundle' => $bundle->getName()
        ));

        rename($docFolder . '_index.tpl', $docFolder . 'index.rst');

        $output->writeln(sprintf('Sample documentation file has been added in <info>Resources/doc</info> folder of bundle <info>%s</info>', $bundle->getName()));
    }
}
