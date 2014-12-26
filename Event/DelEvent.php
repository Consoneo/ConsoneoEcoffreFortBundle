<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Event;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;

class DelEvent extends QueryEvent implements QueryEventInterface
{
	const NAME = 'consoneo.ecoffrefort.del';

	/**
	 * @return String
	 */
	public function getQueryType()
	{
		return LogQuery::QUERY_DEL;
	}
}
