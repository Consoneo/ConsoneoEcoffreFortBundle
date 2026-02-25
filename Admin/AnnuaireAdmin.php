<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AnnuaireAdmin extends AbstractAdmin
{
	protected function configureDefaultSortValues(array &$sortValues): void
	{
		$sortValues['_page'] = 1;
		$sortValues['_sort_order'] = 'DESC';
		$sortValues['_sort_by'] = 'createdDateTime';
	}

	protected function configureListFields(ListMapper $listMapper): void
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
						'template'  => '@ConsoneoEcoffreFort/Sonata/list__action_pdf_view.html.twig',
					),
				)
			))
		;
	}

	protected function configureDatagridFilters(DatagridMapper $datagrid): void
	{
		$datagrid
			->add('createdDateTime', null, [
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

	protected function configureRoutes(RouteCollection $collection): void
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
