<?php
namespace DTools\DevkitBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

class CreateFixtureCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('devkit:create-fixture')
            ->setDescription('Creates a fixture loading class inside a bundle.')
            ->setDefinition(array(
                new InputArgument('bundle', InputArgument::REQUIRED, 'Bundle name'),
                new InputArgument('entity', InputArgument::REQUIRED, 'Entity short name'),
                new InputOption('class', null, InputOption::VALUE_OPTIONAL, 'Loader class name'),
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, 'Template name', 'default'),
            ))
            ->setHelp(<<<EOT
The <info>devkit:create-fixture</info> command creates the skeleton of a fixture loader class for a given entity inside a bundle (currently only Doctrine ORM supported).
EOT
            )
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $entity = $input->getArgument('entity');
        if (preg_match('/[^A-Za-z0-9_]/', $entity)) {
            throw new \InvalidArgumentException('Invalid entity name: only letters, numbers and "_" are allowed.');
        }

        if (null === $class = $input->getOption('class')) {
            $class = sprintf('Load%sData', $entity);
        } else if (preg_match('/[^A-Za-z0-9_]/', $class)) {
            throw new \InvalidArgumentException('Invalid class name: only letters, numbers and "_" are allowed.');
        }

        if ($this->resourceExists($this->bundle, '/DataFixtures/ORM/' . $class . '.php')) {
            throw new \RuntimeException(sprintf('A fixture loading class "%s" already exists in "DataFixtures/ORM" folder of bundle "%s".', $class, $this->bundle->getName()));
        }

        $this->getContainer()->get('d_tools_devkit.generator')
            ->setSourceDir($this->getTemplatePath('fixture'))
            ->setFileNames(array('_fixture.tpl' => $class . '.php'))
            ->setParameters(array(
                'namespace' => $this->bundle->getNamespace(),
                'class' => $class,
                'entity' => $entity,
                'bundle' => $this->bundle->getName()
            ))
            ->render();

        $output->writeln(sprintf('A fixture loading class <info>%s</info> has been successfully created in bundle <info>%s</info>.', $class, $this->bundle->getName()));
    }
}
