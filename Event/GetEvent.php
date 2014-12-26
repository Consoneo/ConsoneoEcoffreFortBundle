<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Event;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;

class GetEvent extends QueryEvent implements QueryEventInterface
{
	const NAME = 'consoneo.ecoffrefort.get';

	/**
	 * @return String
	 */
	public function getQueryType()
	{
		return LogQuery::QUERY_GET;
	}
}
