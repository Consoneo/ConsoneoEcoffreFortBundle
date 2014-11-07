<?php

namespace Consoneo\Bundle\EcoffreFortBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Applies the configuration for the Coffre object
 */
class ConsoneoEcoffreFortExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

	    if (isset($config['coffres'])) {
		    $this->addCoffres($config['coffres'], $container);
	    }
    }

	/**
	 * Adds coffres to the service container
	 *
	 * @param array $config
	 * @param ContainerBuilder $container
	 */
	private function addCoffres(array $config, ContainerBuilder $container)
	{
		$map = array();

		foreach ($config as $name => $coffreConfig) {
			$name = sprintf('consoneo.ecoffrefort.%s', $name);
			$map[$name] = $this->newCoffre($name, $coffreConfig, $container);
		}

		$container->getDefinition('ecoffrefort.coffre_map')
			->replaceArgument(0, $map);
	}

	/**
	 * Creates a new ECoffreFort definition
	 *
	 * @param $name
	 * @param array $config
	 * @param ContainerBuilder $container
	 */
	private function newCoffre($name, array $config, ContainerBuilder $container)
	{
		$coffre = new Definition('Consoneo\Bundle\EcoffreFortBundle\Coffre', [
			$config['email_origin'],
			$config['safe_id'],
			$config['part_id'],
			$config['password'],
		]);

		$coffre->addMethodCall('setDoctrine', [new Reference('doctrine')]);

		// Add the service to the container
		$container->setDefinition($name, $coffre);
	}
}
