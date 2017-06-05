<?php declare(strict_types=1);

namespace App\Presenters;

use App\Contact\Contact;
use Nette\Application\UI\Presenter;


final class HomepagePresenter extends Presenter
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


	public function renderDefault()
	{
		$this->template->contact = $this->contact;
	}

}
