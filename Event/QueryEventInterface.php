<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Event;

interface QueryEventInterface
{
	/**
	 * @return String
	 */
	public function getQueryType();

	/**
	 * @return String
	 */
	public function getSafeId();

	/**
	 * @return String
	 */
	public function getCodeRetour();

	/**
	 * @return String
	 */
	public function getIua();
}