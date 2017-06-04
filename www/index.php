<?php declare(strict_types=1);

use Nette\Application\Application;
use Nette\DI\Container;


return (function (Container $container): void {
	/**
	 * @var Application $application
	 */
	$application = $container->getByType(Application::class);
	$application->run();
})(require_once __DIR__ . '/../app/bootstrap.php');
