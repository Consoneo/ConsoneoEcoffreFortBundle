<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Command;

use Consoneo\Bundle\EcoffreFortBundle\TiersArchivage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DelCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('ecoffrefort:removeFiles')
			->setDescription('suprimer des fichiers du tiers archivage')
			->addArgument('serviceId', InputArgument::REQUIRED, 'nom du service de tiers archivage')
			->addArgument('iuas', InputArgument::REQUIRED, 'IUA des fichiers à suprimer séparé par une virgule')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if (!$this->getContainer()->has($input->getArgument('serviceId'))) {
			$output->writeln('<error>service inexistant</error>');
		} elseif ($this->getContainer()->get($input->getArgument('serviceId')) instanceof TiersArchivage) {
			$service = $this->getContainer()->get($input->getArgument('serviceId'));
			$output->writeln(sprintf('<info>Supression des fichiers avec les IUA suivant : %s pour le service de tiers Archivage suivant : %s</info>',
				$input->getArgument('iuas'), $input->getArgument('serviceId')));

			$iuas = explode(',', $input->getArgument('iuas'));

			foreach ($iuas as $iua) {
				$service->removeFile($iua);
				$output->writeln(sprintf('Fichier : %s suprimer', $iua));
			}
		}
	}
}