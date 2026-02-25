<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Admin;

use Consoneo\Bundle\EcoffreFortBundle\Entity\LogQuery;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class LogQueryAdmin extends AbstractAdmin
{
	protected function configureDefaultSortValues(array &$sortValues): void
	{
		$sortValues['_page'] = 1;
		$sortValues['_sort_order'] = 'DESC';
		$sortValues['_sort_by'] = 'createdDateTime';
	}

	protected function configureShowFields(ShowMapper $showMapper): void
	{
		$showMapper
			->with('ECoffreFort LogQuery')
			->add('createdDateTime', null, ['label'    =>  'Date de création'])
			->add('safeId', null, ['label'  =>  'Nom du Coffre'])
			->add('queryType', null, ['label'   =>  'Type de requête'])
			->add('iua', null, ['label' =>  'Identifiant Unique de l\'Archive'])
			->add('returnCode', null, ['label'  =>  'Code de retour'])
			->add('getLabelReturnCode', null, ['label'  =>  'Message de retour'])
			->add('serviceType', null, ['label' =>  'type de service utilisé (coffre standart ou tiers archivage)'])
			->end()
		;
	}

	protected function configureListFields(ListMapper $listMapper): void
	{
		$listMapper
			->add('createdDateTime', null, ['label'    =>  'Date de création'])
			->add('safeId', null, ['label'  =>  'Nom du Coffre'])
			->add('queryType', 'string', [
				'label'     =>  'Type de requête',
				'template'  => '@ConsoneoEcoffreFort/Sonata/list.querytype.html.twig',
			])
			->add('iua', null, ['label' =>  'Identifiant Unique de l\'Archive'])
			->add('getLabelReturnCode', null, ['label'  =>  'Message de retour'])
			->add('serviceType', null, ['label' =>  'type de service utilisé (coffre standart ou tiers archivage)'])

			->add('_action', 'actions', array(
				'actions' => array(
					'show' => array(),
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
			->add('serviceType', null, ['label' =>  'type de service utilisé (coffre standart ou tiers archivage)'])
			->add('queryType', null, [
				'label'   =>  'Type de requête',
				'field_options' => [
					'choices' => [
						LogQuery::QUERY_PUT => LogQuery::QUERY_PUT,
						LogQuery::QUERY_GET => LogQuery::QUERY_GET,
						LogQuery::QUERY_DEL => LogQuery::QUERY_DEL,
					],
				],
			])
			->add('iua', null, ['label' =>  'Identifiant Unique de l\'Archive'])
		;
	}

	protected function configureRoutes(RouteCollection $collection): void
	{
		$collection
			->remove('create')
			->remove('edit')
			->remove('delete')
			->remove('batch')
		;
	}

}
