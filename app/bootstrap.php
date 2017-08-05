<?php declare(strict_types=1);

use Nette\Configurator;
use Nette\DI\Container;


return (function (): Container {
	$configurator = new Configurator;
	$configurator->setDebugMode(getenv('DEBUG_MODE'));
	$configurator->enableTracy(__DIR__ . '/../log');
	$configurator->setTimeZone('Europe/Prague');
	$configurator->setTempDirectory(__DIR__ . '/../temp');
	$configurator->addConfig(__DIR__ . '/config/config.neon');
	$configurator->addConfig(__DIR__ . '/config/config.local.neon');
	if ($configurator->isDebugMode()) {
		$configurator->addConfig(__DIR__ . '/config/config.debug.neon');
	}

	return $configurator->createContainer();
})(require_once __DIR__ . '/../vendor/autoload.php');
