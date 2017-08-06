<?php declare(strict_types = 1);

namespace Tests\DisqusModule;

use App\DisqusModule\Configuration;
use PHPUnit\Framework\TestCase;


final class ConfigurationTest extends TestCase
{

	private const SITE = 'site';


	public function test(): void
	{
		$configuration = new Configuration(self::SITE);
		$this->assertEquals(self::SITE, $configuration->getSite());
	}

}
