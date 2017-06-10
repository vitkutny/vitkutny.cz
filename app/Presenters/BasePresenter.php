<?php declare(strict_types=1);

namespace App\Presenters;

use App\ContactModule\Contact;
use App\DisqusModule\Controls\DisqusControl;
use App\DisqusModule\Controls\DisqusControlFactory;
use Nette\Bridges\ApplicationLatte\Template;


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
		/**
		 * @var Template $template
		 */
		$template = $this->getTemplate();
		$template->add('contact', $this->contact);
	}


	protected function createComponentDisqus(): DisqusControl
	{
		return $this->disqusControlFactory->create();
	}
}
