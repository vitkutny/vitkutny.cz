<?php declare(strict_types=1);

namespace App\ContactModule\Presenters;

use App\ContactModule\Contact;
use Nette\Bridges\ApplicationLatte\Template;


trait BasePresenter
{

	/**
	 * @var Contact
	 */
	private $contact;


	public function injectContact(Contact $contact): void
	{
		$this->contact = $contact;
	}


	protected function beforeRender(): void
	{
		/**
		 * @var Template $template
		 */
		$template = $this->getTemplate();
		$template->add('contact', $this->contact);
	}
}
