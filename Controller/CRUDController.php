<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Controller;

use Consoneo\Bundle\EcoffreFortBundle\Entity\Annuaire;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CRUDController extends Controller
{
	public function pdfViewAction()
	{
		$id = $this->get('request')->get($this->admin->getIdParameter());

		/** @var $object Annuaire */
		$object = $this->admin->getObject($id);

		if (!$object) {
			throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
		}

		$content = $this->container->get('ecoffrefort.coffre_map')->get(sprintf('consoneo.ecoffrefort.%s', strtolower($object->getSafeId())))
			->getFile($object->getIua());

		$this->container->get('doctrine')->getManager()->flush();

		return new Response($content, 200, ['Content-type' =>  'application/pdf']);
	}
}