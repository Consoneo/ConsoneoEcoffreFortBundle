<?php

namespace Consoneo\Bundle\EcoffreFortBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('consoneo_ecoffre_fort');

	    $rootNode
		    ->append($this->addCoffresSection());

        return $treeBuilder;
    }

	/**
	 * Configure the "consoneo_ecoffre_fort.coffres" section
	 *
	 * @return ArrayNodeDefinition
	 */
	private function addCoffresSection()
	{
		$tree = new TreeBuilder();
		$node = $tree->root('coffres');

		$node
			->requiresAtLeastOneElement()
			->useAttributeAsKey('name')
			->prototype('array')
				->children()
					->scalarNode('email_origin')->isRequired()->end()
					->scalarNode('safe_id')->isRequired()->end()
					->scalarNode('part_id')->isRequired()->end()
					->scalarNode('password')->isRequired()->end()
					->end()
				->end()
			->end()
		;

		return $node;
	}

}
