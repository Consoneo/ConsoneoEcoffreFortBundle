<?php

namespace Consoneo\Bundle\EcoffreFortBundle;

/**
 * Holds references to all declared tiers archivage
 * and allows to access them through their name
 */
class TiersArchivageMap implements \IteratorAggregate
{
	/**
	 * Map of tiers archivage indexed by their name
	 *
	 * @var array
	 */
	protected $map;

	/**
	 * Instantiates a new coffre map
	 *
	 * @param array $map
	 */
	public function __construct(array $map)
	{
		$this->map = $map;
	}

	/**
	 * Retrieves a coffre by its name.
	 *
	 * @param string $name name of a coffre
	 *
	 * @return Coffre
	 *
	 * @throw \InvalidArgumentException if the coffre does not exist
	 */
	public function get($name)
	{
		$name = str_replace('-', '_',$name);

		if (!isset($this->map[$name])) {
			throw new \InvalidArgumentException(sprintf('No tiers archivage register for name "%s"', $name));
		}

		return $this->map[$name];
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->map);
	}
}
