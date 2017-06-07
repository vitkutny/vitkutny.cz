<?php declare(strict_types=1);

namespace App\Presenters;

use App\Contact\Contact;
use App\Contact\Controls\ContactControl;
use App\Contact\Controls\ContactControlFactory;


trait BasePresenter
{

	/**
	 * @var Contact
	 */
	private $contact;
	/**
	 * @var ContactControlFactory
	 */
	private $contactControlFactory;


	public function injectContact(Contact $contact, ContactControlFactory $contactControlFactory): void
	{
		$this->contact = $contact;
		$this->contactControlFactory = $contactControlFactory;
	}


	protected function createComponentContact(): ContactControl
	{
		return $this->contactControlFactory->create($this->contact);
	}
}
