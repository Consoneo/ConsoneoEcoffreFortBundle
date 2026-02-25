<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Command;

use Consoneo\Bundle\EcoffreFortBundle\TiersArchivage;
use Consoneo\Bundle\EcoffreFortBundle\TiersArchivageMap;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'ecoffrefort:list', description: 'lister les fichiers contenu dans un tiers archivage')]
class ListCommand extends Command
{

	private TiersArchivageMap $tiersArchivageMap;

	public function __construct(TiersArchivageMap $tiersArchivageMap)
	{
		parent::__construct();
		$this->tiersArchivageMap = $tiersArchivageMap;
	}

	protected function configure(): void
	{
		$this
			->setDescription('lister les fichiers contenu dans un tiers archivage')
			->addArgument('serviceId', InputArgument::REQUIRED, 'nom du service de tiers archivage')
			->addArgument('fileName', InputArgument::OPTIONAL, 'Chaîne de caractère contenus dans le champ FILE_NAME')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		try {
			$service = $this->tiersArchivageMap->get($input->getArgument('serviceId'));
		} catch (\InvalidArgumentException $e) {
			$output->writeln('<error>service inexistant</error>');
			return Command::FAILURE;
		}

		$output->writeln(sprintf('<info>Listage des fichiers répondant au masque : %s pour le service de tiers Archivage suivant : %s</info>',
			$input->getArgument('fileName'), $input->getArgument('serviceId')));

		$files = $service->listFiles(TiersArchivage::RTNTYPE_XML, $input->getArgument('fileName'));
		if ($files == '-7') {
			$output->writeln('<info>Aucun fichiers</info>');
		} else {
			$files = simplexml_load_string($files);
			$table = new Table($output);
			$table
				->setHeaders(['IUA', 'NAME', 'HASH', 'HASH TYPE', 'SIZE', 'DATE', 'EXPIRE']);

			foreach ($files as $file) {
				$table->addRow(
					[$file->FILE_IUA, $file->FILE_NAME, $file->FILE_HASH, $file->FILE_HASH_TYPE, $file->FILE_SIZE,
						$file->FILE_DATE, $file->FILE_EXPIRE]);
			}
			$table->render();
		}

		return Command::SUCCESS;
	}
}
