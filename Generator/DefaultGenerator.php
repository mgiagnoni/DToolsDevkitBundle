<?php

/**
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license included
 * with this source code (Resources/meta/LICENSE).
 */

namespace DTools\DevkitBundle\Generator;

use Symfony\Component\HttpKernel\Util\Filesystem;
use Symfony\Bundle\FrameworkBundle\Generator\Generator;

/**
 * Mirrors a set of template files into a destination directory and renders them
 * replacing variable placeholders ( {{ variable_name }} ) with values.
 */
class DefaultGenerator
{
    protected $destination;
    protected $source;
    protected $parameters = array();
    protected $fileNames = array();
    protected $filesystem;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->setFilesystem($filesystem);
    }

    /**
     * Injects Filesystem
     *
     * @param Filesystem $filesystem
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Returns injected filesystem.
     *
     * @return Symfony\Component\HttpKernel\Util\Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * Sets destination directory (where template will be rendered).
     *
     * @param string $dir
     * @return Generator instance
     */
    public function setDestinationDir($dir)
    {
        $this->destination = $this->normalizeDir($dir);

        return $this;
    }

    /**
     * Returns destination directory.
     *
     * @return string
     */
    public function getDestinationDir()
    {
        return $this->destination;
    }

    /**
     * Sets source directory (where template files reside).
     *
     * @param string $dir
     * @return Generator instance
     */
    public function setSourceDir($dir)
    {
        $this->source = $this->normalizeDir($dir);

        return $this;
    }

    /**
     * Returns source directory.
     *
     * @return string
     */
    public function getSourceDir()
    {
        return $this->source;
    }

    /**
     * Sets parameters for variable sostitution in template files.
     *
     * @param array $parameters
     * @return Generator instance
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Returns template parameters.
     * 
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Sets array to map template filenames with real names.
     *
     * Example: array('_license.tpl' => 'LICENSE')
     *
     * @param array $names
     * @return Generator instance
     */
    public function setFileNames($names)
    {
        $this->fileNames = $names;

        return $this;
    }

    /**
     * Returns template filenames map.
     *
     * @return array
     */
    public function getFileNames()
    {
        return $this->fileNames;
    }

    /**
     * Renders template.
     */
    public function render()
    {
        $fs = $this->getFilesystem();
        $src = $this->getSourceDir();
        $dest = $this->getDestinationDir();

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($src, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        $fs->mirror($src, $dest, $iterator);

        $iterator->rewind();
        foreach ($iterator as $file) {
            if ('.tpl' == substr($file->getPathname(), -4)) {
                $target = $dest.'/'.str_replace($src . DIRECTORY_SEPARATOR, '', $file->getPathname());
                Generator::renderFile($target, $this->getParameters());

                if ($fname = $this->getRenamedFile(basename($target))) {
                    $renamed = dirname($target) . DIRECTORY_SEPARATOR . $fname;
                } else {
                    // Remove .tpl
                    $renamed = substr($target, 0, -4);
                }
                $fs->rename($target, $renamed);
            }
        }
    }

    protected function normalizeDir($dir)
    {
        $normalized = $dir;
        if ('/' === substr($dir, -1) || '\\' === substr($dir, -1)) {
            $normalized = substr($dir, 0, -1);
        }

        return $normalized;
    }

    protected function getRenamedFile($filename)
    {
        if (isset($this->fileNames[$filename]))
        {
            return $this->fileNames[$filename];
        }
    }
}
