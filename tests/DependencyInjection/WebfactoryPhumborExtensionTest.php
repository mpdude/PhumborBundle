<?php

namespace Webfactory\Bundle\PhumborBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Webfactory\Bundle\PhumborBundle\DependencyInjection\WebfactoryPhumborExtension;

/**
 * Test Extension.
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
abstract class WebfactoryPhumborExtensionTest extends TestCase
{
    /**
     * Defined in children class
     * One per type of loader : yaml, xml, php
     * Load the configuration file in the container.
     *
     * @return void
     */
    abstract protected function loadFromFile(ContainerBuilder $container, $file);

    /**
     * @test
     */
    public function loading()
    {
        $container = $this->createContainerFromFile('transformers');

        $this->assertEquals($container->getParameter('phumbor.server.url'), 'http://localhost:8888');
        $this->assertEquals($container->getParameter('phumbor.secret'), '123456789');
        $this->assertEquals(
            $container->getParameter('phumbor.transformations'),
            ['fit_in_test' => ['fit_in' => ['width' => 100, 'height' => 80]]]
        );
    }

    /**
     * Create container with the current bundle enabled.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected function createContainer(array $data = [])
    {
        return new ContainerBuilder(new ParameterBag(array_merge([
            'kernel.bundles' => ['WebfactoryPhumborBundle' => 'Jb\\Bundle\\PhumborBundle\\WebfactoryPhumborBundle'],
            'kernel.cache_dir' => __DIR__,
            'kernel.debug' => false,
            'kernel.environment' => 'test',
            'kernel.name' => 'kernel',
            'kernel.root_dir' => __DIR__,
        ], $data)));
    }

    /**
     * Register a configuration file.
     *
     * @param string $file
     * @param array  $data
     *
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     *
     * @see \Webfactory\Bundle\PhumborBundle\Tests\DependencyInjection\YamlWebfactoryPhumborExtensionTest
     */
    protected function createContainerFromFile($file, $data = [])
    {
        $container = $this->createContainer($data);
        $container->registerExtension(new WebfactoryPhumborExtension());
        $this->loadFromFile($container, $file);

        $container->getCompilerPassConfig()->setOptimizationPasses([]);
        $container->getCompilerPassConfig()->setRemovingPasses([]);
        $container->compile();

        return $container;
    }
}
