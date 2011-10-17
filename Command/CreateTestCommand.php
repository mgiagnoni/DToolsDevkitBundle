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

class CreateTestCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('devkit:create-test')
            ->setDescription('Creates a PhpUnit test case class inside a bundle.')
            ->setDefinition(array(
                new InputArgument('bundle', InputArgument::REQUIRED, 'Bundle name'),
                new InputArgument('class', InputArgument::REQUIRED, 'Name of the class to test (relative to bundle namespace)'),
                new InputOption('test-class', null, InputOption::VALUE_OPTIONAL, 'Name of the test case class (relative to bundle sub-namespace "Tests")'),
                new InputOption('method', null, InputOption::VALUE_OPTIONAL, 'Name of the sample test method'),
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, 'Test class template', 'default'),
            ))
            ->setHelp(<<<EOT
The <info>devkit:create-test</info> creates a PhpUnit test case class inside a bundle.

Examples:

<info>./app/console devkit:create-test AcmeMyBundle "Model\Article"</info>

This command creates a test case class <info>Acme\MyBundle\Tests\Model\ArticleTest</info>.

Test case class is named after the class you are writing the test for, use the <info>--test-class</info> option to specify a different name.

The <info>default</info> template generates a standard unit test, if you want a functional test case, use <info>functional</info> template.

EOT
            )
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classNs = $this->validateClassName($input->getArgument('class'));

        $testCaseNs = null;

        if ($input->hasOption('test-class')) {
            $testCaseNs = $this->validateClassName($input->getOption('test-class'));
        }

        if ($input->hasOption('method')) {
            if (preg_match('/[^A-Za-z0-9_]/', $input->getOption('method'))) {
                throw new \InvalidArgumentException('Invalid method name: only letters, numbers and "_" are allowed.');
            }
        }

        list($class, $classNs) = $this->splitClassName($classNs);
        if (null === $testCaseNs) {
            $testCase = $class;
            $testCaseNs = $classNs;
        } else {
            list($testCase, $testCaseNs) = $this->splitClassName($testCaseNs);
        }

        if ('Test' != substr($testCase, -4)) {
            $testCase .= 'Test';
        }

        $testFile = $testCase . '.php';
        $destDir = 'Tests/'. str_replace('\\', '/', $testCaseNs);

        if ($this->resourceExists($this->bundle, $destDir . '/' . $testFile)) {
            throw new \RuntimeException(sprintf('A file "%s" already exists in bundle "%s" folder.', $testFile, $destDir));
        }

        $namespace = $this->bundle->getNamespace() . '\\Tests\\' . $testCaseNs;
        $use = $this->bundle->getNamespace() . '\\' . $classNs . '\\' . $class;

        if (null === $method = $input->getOption('method')) {
            $method = 'test' . $class;
        }

        $this->getContainer()->get('d_tools_devkit.generator')
            ->setSourceDir($this->getTemplatePath('test'))
            ->setDestinationDir($this->bundle->getPath() . '/' . $destDir)
            ->setFileNames(array('_test.tpl' => $testFile))
            ->setParameters(array(
                'namespace' => $namespace,
                'use' => $use,
                'class' => $class,
                'test_class' => $testCase,
                'test_method' =>  $method,
                'bundle' => $this->bundle->getName()
            ))
            ->render();

        $output->writeln(sprintf('A test case file <info>"%s"</info> has been successfully created in <info>"%s"</info> folder of <info>"%s"</info> bundle.', $testFile, $destDir, $this->bundle->getName()));
    }

    protected function validateClassName($class)
    {
        if (preg_match('/[^A-Za-z0-9\\\\]/', $class)) {
            throw new \InvalidArgumentException('Invalid class name: only letters, numbers and "\" are allowed.');
        }

        return $class;
    }

    protected function splitClassName($class)
    {
        $parts = explode('\\', $class);
        $class = array_pop($parts);
        $namespace = implode('\\', $parts);

        return array($class, $namespace);
    }
}
