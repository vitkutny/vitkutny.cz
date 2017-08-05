<?php declare(strict_types = 1);

namespace App\DisqusModule\Presenters;

use App\DisqusModule\Controls\DisqusControl;
use App\DisqusModule\Controls\DisqusControlFactory;


trait BasePresenter
{

	/**
	 * @var DisqusControlFactory
	 */
	private $disqusControlFactory;


	public function injectDisqus(DisqusControlFactory $disqusControlFactory): void
	{
		$this->disqusControlFactory = $disqusControlFactory;
	}


	protected function createComponentDisqus(): DisqusControl
	{
		return $this->disqusControlFactory->create();
	}
}
