<?php declare(strict_types=1);

namespace App\Contact\Controls;

use App\Contact\Contact;
use Nette\Application\UI\Control;


final class ContactControl extends Control
{

	/**
	 * @var Contact
	 */
	private $contact;


	public function __construct(
		Contact $contact
	) {
		parent::__construct();
		$this->contact = $contact;
	}


	public function render(): void
	{
		$template = $this->getTemplate();
		$template->contact = $this->contact;
		$template->setFile(__DIR__ . '/templates/contact.latte');
		$template->render();
	}
}
