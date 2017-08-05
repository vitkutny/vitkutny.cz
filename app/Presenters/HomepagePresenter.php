<?php declare(strict_types = 1);

namespace App\Presenters;

use App\BlogModule\Controls\PostListControl;
use App\BlogModule\Controls\PostListControlFactory;
use Nette\Application\UI\Presenter;


final class HomepagePresenter extends Presenter
{

	use BasePresenter;

	/**
	 * @var PostListControlFactory
	 */
	private $postListControlFactory;


	public function __construct(
		PostListControlFactory $postListControlFactory
	) {
		parent::__construct();
		$this->postListControlFactory = $postListControlFactory;
	}


	protected function createComponentPostList(): PostListControl
	{
		return $this->postListControlFactory->create();
	}

}
