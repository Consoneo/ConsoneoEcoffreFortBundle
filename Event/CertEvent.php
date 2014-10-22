<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Event;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;

class CertEvent extends QueryEvent implements QueryEventInterface
{
	const NAME = 'consoneo.ecoffrefort.cert';

	/**
	 * @return String
	 */
	public function getQueryType()
	{
		return LogQuery::QUERY_CERT;
	}
}