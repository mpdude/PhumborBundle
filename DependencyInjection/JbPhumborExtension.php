<?php

namespace Jb\Bundle\PhumborBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 * PhumborBundle extension
 *
 * @author Jonathan Bouzekri <jonathan.bouzekri@gmail.com>
 */
class JbPhumborExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
/*        foreach ($configs as &$config) {
            if (!isset($config['transformations'])) {
                continue;
            }

            foreach ($config['transformations'] as $name => &$transformation) {
                if (!isset($transformation['name'])) {
                    $transformation['name'] = $name;
                }
            }
        }*/

        $config = $this->processConfiguration(new Configuration(), $configs);
        $this->loadConfiguration($container, $config);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * Load configuration
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param array $config
     */
    protected function loadConfiguration(ContainerBuilder $container, array $config)
    {
        $container->setParameter('phumbor.server.url', $config['server']['url']);
        $container->setParameter('phumbor.secret', $config['server']['secret']);
        $container->setParameter('phumbor.transformations', $config['transformations']);
    }
}
