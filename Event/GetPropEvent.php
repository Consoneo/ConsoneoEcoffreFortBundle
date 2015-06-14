<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Event;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;

class GetPropEvent extends QueryEvent implements QueryEventInterface
{
	const NAME = 'consoneo.ecoffrefort.getprop';

	/**
	 * @return String
	 */
	public function getQueryType()
	{
		return LogQuery::QUERY_GETPROP;
	}
}
