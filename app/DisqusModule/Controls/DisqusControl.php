<?php declare(strict_types=1);

namespace App\DisqusModule\Controls;

use App\DisqusModule\Configuration;
use Nette\Application\UI\Control;


final class DisqusControl extends Control
{

	/**
	 * @var Configuration
	 */
	private $configuration;


	public function __construct(
		Configuration $configuration
	) {
		parent::__construct();
		$this->configuration = $configuration;
	}


	public function renderThread(string $identifier): void
	{
		$template = $this->getTemplate();
		$template->identifier = $identifier;
		$template->configuration = $this->configuration;
		$template->setFile(__DIR__ . '/templates/thread.latte');
		$template->render();
	}


	public function renderScript(): void
	{
		$template = $this->getTemplate();
		$template->configuration = $this->configuration;
		$template->setFile(__DIR__ . '/templates/script.latte');
		$template->render();
	}
}
