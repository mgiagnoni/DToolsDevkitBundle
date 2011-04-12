<?php
namespace DTools\DevkitBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

class AddLicenseCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('devkit:add-license')
            ->setDescription('Adds a license file to a bundle.')
            ->setDefinition(array(
                new InputArgument('bundle', InputArgument::REQUIRED, 'Bundle name'),
                new InputOption('author', null, InputOption::VALUE_OPTIONAL, 'Author name'),
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, 'License template', 'default'),
            ))
            ->setHelp(<<<EOT
The <info>devkit:add-license</info> adds a <info>LICENSE</info> file inside the <info>Resources/doc/meta</info> folder of a given bundle.

If <info>author</info> option is omitted, value of <info>d_tools_devkit.author.name</info> as set in configuration is used.
The default template adds a <info>MIT license</info>, templates for other licenses can be created in <info>app/Resources/DtoolsDevkitBundle/skeleton/license</info>.
EOT
            )
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bundle = $this->findBundle($input->getArgument('bundle'));
        if (null === $author = $input->getOption('author')) {
            $author = $this->container->getParameter('d_tools_devkit.author.name');
        }

        $licenseFolder = $bundle->getPath() . '/Resources/meta/';
        if (file_exists($licenseFolder . 'LICENSE')) {
            throw new \RuntimeException(sprintf('A LICENSE file already exists in bundle "%s".', $bundle->getName()));
        }

        $this->renderTemplate('license', $input->getOption('template'), $bundle->getPath(), $licenseFolder, array(
            'author' => $author,
            'year' => date('Y'),
            'bundle' => $bundle->getName()
        ));

        rename($licenseFolder . '_license.tpl', $licenseFolder . 'LICENSE');
        $output->writeln(sprintf('A LICENSE file has been added in <info>Resources/meta</info> folder of bundle <info>%s</info>', $bundle->getName()));
    }
}
