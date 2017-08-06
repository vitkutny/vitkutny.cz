<?php declare(strict_types = 1);

namespace Tests;

use Nette\DI\Container;
use PHPUnit\Framework\TestCase;


final class BootstrapTest extends TestCase
{

	private const ENV_DEBUG_MODE = 'DEBUG_MODE';


	public static function createContainer(): Container
	{
		return require __DIR__ . '/../app/bootstrap.php';
	}


	public function test(): void
	{
		$container = $this->createContainer();
		$parameters = $container->getParameters();
		$this->assertEquals('/tmp', $parameters['tempDir'] ?? NULL);
	}


	public function testIsDebugMode(): void
	{
		putenv(sprintf('%s=%s', self::ENV_DEBUG_MODE, php_uname('n')));
		try {
			$container = $this->createContainer();
		} finally {
			putenv(self::ENV_DEBUG_MODE);
		}
		$parameters = $container->getParameters();
		$this->assertEquals(TRUE, $parameters['debugMode'] ?? NULL);
	}


	public function testIsNotDebugMode(): void
	{
		$container = $this->createContainer();
		$parameters = $container->getParameters();
		$this->assertEquals(FALSE, $parameters['debugMode'] ?? NULL);
	}
}
