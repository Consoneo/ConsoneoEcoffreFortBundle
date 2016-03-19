<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Command;

use Consoneo\Bundle\EcoffreFortBundle\TiersArchivage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PutCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('ecoffrefort:put')
			->setDescription('ajout un fichier dans un Tiers Archivage')
			->addArgument('serviceId', InputArgument::REQUIRED, 'nom du service de tiers archivage')
			->addArgument('path', InputArgument::REQUIRED, 'chemin du fichier')
			->addArgument('fileName',  InputArgument::REQUIRED, 'nom fichier')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if (!$this->getContainer()->has($input->getArgument('serviceId'))) {
			$output->writeln('<error>service inexistant</error>');
			return;
		}

		if (!realpath($input->getArgument('path'))) {
			$output->writeln('<error>Fichier introuvable</error>');
			return;
		}

		if ($this->getContainer()->get($input->getArgument('serviceId')) instanceof TiersArchivage) {
			/** @var  $service TiersArchivage */
			$service = $this->getContainer()->get($input->getArgument('serviceId'));

			$output->writeln('<info>Ajout du fichier dans l\'Archive de Tiers Archivage</info>');

			$response = $service->putFile($input->getArgument('fileName'), realpath($input->getArgument('path')));

			$output->writeln($response);
		}
	}
}
