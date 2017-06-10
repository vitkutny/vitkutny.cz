<?php declare(strict_types=1);

namespace App\DisqusModule;

final class Configuration
{

	/**
	 * @var string
	 */
	private $site;


	public function __construct(string $site)
	{
		$this->site = $site;
	}


	public function getSite(): string
	{
		return $this->site;
	}

}
