<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Event;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;

class ListEvent extends QueryEvent implements QueryEventInterface
{
	const NAME = 'consoneo.ecoffrefort.list';

	/**
	 * @return String
	 */
	public function getQueryType()
	{
		return LogQuery::QUERY_LIST;
	}
}
