<?php declare(strict_types = 1);

namespace Tests;

use Nette\DI\Container;
use PHPUnit\Framework\TestCase;


final class BootstrapTest extends TestCase
{

	private const ENV_DEBUG_MODE = 'DEBUG_MODE';


	public static function createContainer(string $debugMode = NULL): Container
	{
		if ($debugMode === NULL) {
			putenv(self::ENV_DEBUG_MODE);
		} else {
			putenv(sprintf('%s=%s', self::ENV_DEBUG_MODE, $debugMode));
		}

		try {
			return require __DIR__ . '/../app/bootstrap.php';
		} finally {
			putenv(self::ENV_DEBUG_MODE);
		}
	}


	public function test(): void
	{
		$container = self::createContainer();
		$parameters = $container->getParameters();
		$this->assertEquals('/tmp', $parameters['tempDir'] ?? NULL);
	}


	public function testIsDebugMode(): void
	{
		$container = self::createContainer('on');
		$parameters = $container->getParameters();
		$this->assertEquals(TRUE, $parameters['debugMode'] ?? NULL);
		$container = self::createContainer(php_uname('n'));
		$parameters = $container->getParameters();
		$this->assertEquals(TRUE, $parameters['debugMode'] ?? NULL);
	}


	public function testIsNotDebugMode(): void
	{
		$container = self::createContainer();
		$parameters = $container->getParameters();
		$this->assertEquals(FALSE, $parameters['debugMode'] ?? NULL);
	}
}
