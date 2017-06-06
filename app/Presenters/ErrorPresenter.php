<?php declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;


final class ErrorPresenter extends Presenter
{

	public function renderDefault(\Throwable $exception)
	{
		$file = sprintf('%s/templates/Error/%d.latte', __DIR__, $exception->getCode());
		if (is_file($file)) {
			$this->getTemplate()->setFile($file);
		}
	}

}
