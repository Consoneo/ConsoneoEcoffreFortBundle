<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Command;

use Consoneo\Bundle\EcoffreFortBundle\TiersArchivage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('ecoffrefort:list')
			->setDescription('lister les fichiers contenu dans un tiers archivage')
			->addArgument('serviceId', InputArgument::REQUIRED, 'nom du service de tiers archivage')
			->addArgument('fileName', InputArgument::OPTIONAL, 'Chaîne de caractère contenus dans le champ FILE_NAME de l’ART lors du versement')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if (!$this->getContainer()->has($input->getArgument('serviceId'))) {
			$output->writeln('<error>service inexistant</error>');
		} elseif ($this->getContainer()->get($input->getArgument('serviceId')) instanceof TiersArchivage) {
			$service = $this->getContainer()->get($input->getArgument('serviceId'));
			$output->writeln(sprintf('<info>Listage des fichiers répondant au masque : %s pour le service de tiers Archivage suivant : %s</info>',
				$input->getArgument('fileName'), $input->getArgument('serviceId')));

			$files = $service->listFiles(TiersArchivage::RTNTYPE_XML, $input->getArgument('fileName'));
			if ($files == '-7') {
				$output->writeln('<info>Aucun fichiers</info>');
			} else {
				$files = simplexml_load_string($files);
				$table = $this->getHelperSet()->get('table');
				$table
					->setHeaders(['IUA', 'NAME', 'HASH', 'HASH TYPE', 'SIZE', 'DATE', 'EXPIRE']);

				foreach ($files as $file) {
					$table->addRow(
						[$file->FILE_IUA, $file->FILE_NAME, $file->FILE_HASH, $file->FILE_HASH_TYPE, $file->FILE_SIZE,
							$file->FILE_DATE, $file->FILE_EXPIRE]);
				}
				$table->render($output);
			}
		}
	}
}