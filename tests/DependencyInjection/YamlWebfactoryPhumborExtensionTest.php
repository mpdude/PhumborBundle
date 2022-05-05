<?php

namespace Webfactory\Bundle\PhumborBundle\Tests\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Test Extension with yaml loading.
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class YamlWebfactoryPhumborExtensionTest extends WebfactoryPhumborExtensionTest
{
    protected function loadFromFile(ContainerBuilder $container, $file)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/Fixtures/yml'));
        $loader->load($file.'.yml');
    }
}
