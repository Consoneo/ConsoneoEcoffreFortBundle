<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Event;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;

class SafeGetPropEvent extends QueryEvent implements QueryEventInterface
{
	const NAME = 'consoneo.ecoffrefort.safegetprop';

	/**
	 * @return String
	 */
	public function getQueryType()
	{
		return LogQuery::QUERY_SAFEGETPROP;
	}
}
