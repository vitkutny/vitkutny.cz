<?php declare(strict_types=1);

namespace App\Presenters;

use App\Contact\Contact;
use App\DisqusModule\Controls\DisqusControl;
use App\DisqusModule\Controls\DisqusControlFactory;


trait BasePresenter
{

	/**
	 * @var Contact
	 */
	private $contact;
	/**
	 * @var DisqusControlFactory
	 */
	private $disqusControlFactory;


	public function injectContact(Contact $contact): void
	{
		$this->contact = $contact;
	}


	public function injectDisqus(DisqusControlFactory $disqusControlFactory): void
	{
		$this->disqusControlFactory = $disqusControlFactory;
	}


	protected function beforeRender(): void
	{
		$template = $this->getTemplate();
		$template->contact = $this->contact;
	}


	protected function createComponentDisqus(): DisqusControl
	{
		return $this->disqusControlFactory->create();
	}
}
