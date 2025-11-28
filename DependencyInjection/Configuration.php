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
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('consoneo_ecoffre_fort');
        $rootNode = $treeBuilder->getRootNode();

	    $rootNode
		    ->append($this->addCoffresSection())
		    ->append($this->addTiersArchivageSection())
	    ;

        return $treeBuilder;
    }

	/**
	 * Configure the "consoneo_ecoffre_fort.coffres" section
	 *
	 * @return ArrayNodeDefinition
	 */
	private function addCoffresSection(): ArrayNodeDefinition
	{
		$tree = new TreeBuilder('coffres');
		$node = $tree->getRootNode();

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

	/**
	 * Configure the "consoneo_ecoffre_fort.tiers_archivages" section
	 *
	 * @return ArrayNodeDefinition
	 */
	private function addTiersArchivageSection(): ArrayNodeDefinition
	{
		$tree = new TreeBuilder('tiers_archivages');
		$node = $tree->getRootNode();
		$node
			->requiresAtLeastOneElement()
			->useAttributeAsKey('name')
			->prototype('array')
				->children()
					->scalarNode('safe_room')->isRequired()->end()
					->scalarNode('safe_id')->isRequired()->end()
					->scalarNode('user_login')->isRequired()->end()
					->scalarNode('user_password')->isRequired()->end()
					->end()
				->end()
			->end()
		;

		return $node;
	}
}
