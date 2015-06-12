<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AnnuaireAdmin extends Admin
{
	/**
	 * Default Datagrid values
	 *
	 * @var array
	 */
	protected $datagridValues = array(
		'_page' => 1,
		'_sort_order' => 'DESC',
		'_sort_by' => 'createdDateTime'
	);

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('createdDateTime', null, ['label'    =>  'Date de création'])
			->add('safeId', null, ['label'  =>  'Nom du Coffre'])
			->add('iua', null, ['label' =>  'Identifiant Unique de l\'Archive'])
			->add('docName', null, ['label'   =>  'Nom du document'])
			->add('targetDir', null, ['label' =>  'Dossier de stockage'])
			->add('md5DocName', null, ['label'  =>  'md5 du fichier'])
			->add('serviceType', null, ['label'  =>  'type de service utilisé (coffre standart ou tiers archivage)'])

			->add('_action', 'actions', array(
				'actions' => array(
					'pdfView' => array(
						'template'  => 'ConsoneoEcoffreFortBundle:Sonata:list__action_pdf_view.html.twig',
					),
				)
			))
		;
	}

	protected function configureDatagridFilters(DatagridMapper $datagrid)
	{
		$datagrid
			->add('createdDateTime', 'doctrine_orm_datetime_range', [
				'input_type'    =>  'timestamp',
				'label'         =>  'Date de création',
			])
			->add('safeId', null, ['label'  =>  'Nom du Coffre'])
			->add('iua', null, ['label' =>  'Identifiant Unique de l\'Archive'])
			->add('docName', null, ['label'   =>  'Nom du document'])
			->add('targetDir', null, ['label' =>  'Dossier de stockage'])
			->add('md5DocName', null, ['label'  =>  'md5 du fichier'])
			->add('serviceType', null, ['label'  =>  'type de service utilisé (coffre standart ou tiers archivage)'])
		;
	}

	protected function configureRoutes(RouteCollection $collection)
	{
		$collection
			->add('pdfView',  $this->getRouterIdParameter().'/pdfView')
			->remove('show')
			->remove('create')
			->remove('edit')
			->remove('delete')
			->remove('batch')
		;
	}
}
