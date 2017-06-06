<?php declare(strict_types=1);

namespace App\Template;

use App\Contact\Contact;
use Nette\Application\UI\Control;
use Nette\Application\UI\ITemplate;
use Nette\Application\UI\ITemplateFactory;
use Nette\Application\UI\Presenter;


final class TemplateFactory implements ITemplateFactory
{

	/**
	 * @var ITemplateFactory
	 */
	private $templateFactory;
	/**
	 * @var Contact
	 */
	private $contact;


	public function __construct(
		ITemplateFactory $templateFactory,
		Contact $contact
	) {
		$this->templateFactory = $templateFactory;
		$this->contact = $contact;
	}


	public function createTemplate(Control $control = NULL): ITemplate
	{
		$template = $this->templateFactory->createTemplate($control);
		$template->contact = $this->contact;

		return $template;
	}

}
