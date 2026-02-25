<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Command;

use Consoneo\Bundle\EcoffreFortBundle\TiersArchivageMap;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'ecoffrefort:put', description: 'ajout un fichier dans un Tiers Archivage')]
class PutCommand extends Command
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
			->setDescription('ajout un fichier dans un Tiers Archivage')
			->addArgument('serviceId', InputArgument::REQUIRED, 'nom du service de tiers archivage')
			->addArgument('path', InputArgument::REQUIRED, 'chemin du fichier')
			->addArgument('fileName',  InputArgument::REQUIRED, 'nom fichier')
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

		if (!realpath($input->getArgument('path'))) {
			$output->writeln('<error>Fichier introuvable</error>');
			return Command::FAILURE;
		}

		$output->writeln('<info>Ajout du fichier dans l\'Archive de Tiers Archivage</info>');

		$response = $service->putFile($input->getArgument('fileName'), realpath($input->getArgument('path')));

		$output->writeln($response);

		return Command::SUCCESS;
	}
}
