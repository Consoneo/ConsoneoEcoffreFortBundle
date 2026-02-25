<?php
namespace Consoneo\Bundle\EcoffreFortBundle\Command;

use Consoneo\Bundle\EcoffreFortBundle\TiersArchivageMap;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'ecoffrefort:del', description: 'suprimer des fichiers du tiers archivage')]
class DelCommand extends Command
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
			->setDescription('suprimer des fichiers du tiers archivage')
			->addArgument('serviceId', InputArgument::REQUIRED, 'nom du service de tiers archivage')
			->addArgument('iuas', InputArgument::REQUIRED, 'IUA des fichiers à suprimer séparé par une virgule')
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

		$output->writeln(sprintf('<info>Supression des fichiers avec les IUA suivant : %s pour le service de tiers Archivage suivant : %s</info>',
			$input->getArgument('iuas'), $input->getArgument('serviceId')));

		$iuas = explode(',', $input->getArgument('iuas'));

		foreach ($iuas as $iua) {
			$service->removeFile($iua);
			$output->writeln(sprintf('Fichier : %s suprimer', $iua));
		}

		return Command::SUCCESS;
	}
}
