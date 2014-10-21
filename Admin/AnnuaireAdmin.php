<?php

namespace Consoneo\Bundle\EcoffreFortBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class AnnuaireAdmin extends Admin
{

	protected function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
			->with('ECoffreFort Annuaire')
				->add('createdDateTime', null, ['label'    =>  'Date de création'])
				->add('safeId', null, ['label'  =>  'Nom du Coffre'])
				->add('iua', null, ['label' =>  'Identifiant Unique de l\'Archive'])
				->add('docName', null, ['label'   =>  'Nom du document'])
				->add('targetDir', null, ['label' =>  'Dossier de stockage'])
				->add('md5DocName', null, ['label'  =>  'md5 du fichier'])
			->end()
		;
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('createdDateTime', null, ['label'    =>  'Date de création'])
			->add('safeId', null, ['label'  =>  'Nom du Coffre'])
			->add('iua', null, ['label' =>  'Identifiant Unique de l\'Archive'])
			->add('docName', null, ['label'   =>  'Nom du document'])
			->add('targetDir', null, ['label' =>  'Dossier de stockage'])
			->add('md5DocName', null, ['label'  =>  'md5 du fichier'])

			->add('_action', 'actions', array(
				'actions' => array(
					'show' => array(),
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
        ;
	}

	protected function configureRoutes(RouteCollection $collection)
	{
		$collection
			->remove('create')
			->remove('edit')
			->remove('delete')
			->remove('batch')
		;
	}
}
