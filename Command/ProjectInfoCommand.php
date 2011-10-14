<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

class ProjectInfoCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('devkit:project-info')
            ->SetDescription('Shows some informations about current project (work in progress).')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $kernel = $this->getContainer()->get('kernel');

        $lines = array(
            array('Symfony version:', $this->getApplication()->getVersion()),
            array('Application directory:', $kernel->getRootDir()),
        );
        $this->writeSection('Project informations', $lines, 25, $output);

        // Doctrine Dbal
        $connections = $this->getDbalConnections();
        $lines = array();
        if (count($connections)) {
            foreach ($connections as $name) {
                $lines[] = array('Name:', $name);
                $connection = $this->getContainer()->get(sprintf('doctrine.dbal.%s_connection', $name));

                $params = $connection->getParams();
                $lines[] = array('Driver:', $params['driver']);
                $info = array('Test:');
                try {
                    $connection->connect();
                    $info[] = 'OK';
                } catch (\Exception $e) {
                    $info[] = 'Error: ' . $e->getMessage();
                }
                $lines[] = $info;
                $lines[] = array('-');
            }

            $this->writeSection('DBAL connections', $lines, 10, $output);
        }
        //TODO: Doctrine ORM, Doctrine ODM, Propel
    }

    protected function writeSection($title, $entries, $width, $output)
    {
        $output->writeln(sprintf('<comment>%s</comment>', $title));
        $output->writeln(sprintf('<comment>%s</comment>', str_repeat('-', strlen($title))));

        $format = '%-' . $width . 's <info>%s</info>';
        foreach ($entries as $entry) {
            if ('-' == $entry[0]) {
                //Separator
                $output->writeln(sprintf('<comment>%s</comment>', str_repeat('-', $width)));
                continue;
            }
            $output->writeln(sprintf($format, $entry[0], $entry[1]));
        }
        $output->writeln('');
    }

    protected function getDbalConnections()
    {
        $connections = array();
        foreach ($this->getContainer()->getServiceIds() as $service) {
            $matches = array();
            if (preg_match('/doctrine\.dbal\.(.*?)_connection$/', $service, $matches)) {
                $connections[] = $matches[1];
            }
        }

        return $connections;
    }
}
