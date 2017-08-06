<?php declare(strict_types = 1);

namespace Tests;

use Nette\DI\Container;
use PHPUnit\Framework\TestCase;


final class BootstrapTest extends TestCase
{

	public static function createContainer(): Container
	{
		return require __DIR__ . '/../app/bootstrap.php';
	}


	public function test(): void
	{
		$container = $this->createContainer();
		$parameters = $container->getParameters();
		if (isset($parameters['debugMode'])) {
			$this->assertEquals(FALSE, $parameters['debugMode']);
		}
		if (isset($parameters['tempDir'])) {
			$this->assertEquals('/tmp', $parameters['tempDir']);
		}
	}
}
