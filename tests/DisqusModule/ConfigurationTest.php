<?php declare(strict_types = 1);

namespace Tests\DisqusModule;

use App\DisqusModule\Configuration;
use PHPUnit\Framework\TestCase;


final class ConfigurationTest extends TestCase
{

	public function test(): void
	{
		$configuration = new Configuration('site');
		$this->assertEquals('site', $configuration->getSite());
	}

}
