<?php

namespace Jb\Bundle\PhumborBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Jb\Bundle\PhumborBundle\DependencyInjection\JbPhumborExtension;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Test Extension
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
abstract class JbPhumborExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Defined in children class
     * One per type of loader : yaml, xml, php
     * Load the configuration file in the container
     *
     * @return void
     */
    abstract protected function loadFromFile(ContainerBuilder $container, $file);

    public function testLoading()
    {
        $container = $this->createContainerFromFile('transformers');

        $this->assertEquals($container->getParameter('phumbor.server.url'), 'http://localhost:8888');
        $this->assertEquals($container->getParameter('phumbor.secret'), '123456789');
        $this->assertEquals(
            $container->getParameter('phumbor.transformations'),
            array('fit_in_test' => array('fit_in' => array('width'=>100, 'height'=>80)))
        );
    }

    public function testMergingConfigurationFiles()
    {
        $container = $this->createContainerFromFile(['filter-merge-1', 'filter-merge-2']);

        $this->assertEquals(
            array(
                'test_overridden' => array('resize' => array('width'=>200, 'height'=>200)),
                'test_not_overridden' => array('resize' => array('width'=>100, 'height'=>100))
            ),
            $container->getParameter('phumbor.transformations')
        );
    }

    /**
     * Create container with the current bundle enabled
     *
     * @param array $data
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected function createContainer(array $data = array())
    {
        return new ContainerBuilder(new ParameterBag(array_merge(array(
            'kernel.bundles'     => array('JbPhumborBundle' => 'Jb\\Bundle\\PhumborBundle\\JbPhumborBundle'),
            'kernel.cache_dir'   => __DIR__,
            'kernel.debug'       => false,
            'kernel.environment' => 'test',
            'kernel.name'        => 'kernel',
            'kernel.root_dir'    => __DIR__,
        ), $data)));
    }

    /**
     * Register a configuration file
     * @see \Jb\Bundle\PhumborBundle\Tests\DependencyInjection\YamlJbPhumborExtensionTest
     *
     * @param array<string>|string $file
     * @param array $data
     *
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected function createContainerFromFile($files, $data = array())
    {
        $container = $this->createContainer($data);
        $container->registerExtension(new JbPhumborExtension());

        foreach ((array) $files as $file) {
            $this->loadFromFile($container, $file);
        }

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->compile();

        return $container;
    }
}
