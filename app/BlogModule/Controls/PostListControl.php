<?php declare(strict_types=1);

namespace App\BlogModule\Controls;

use App\BlogModule\Post\PostRepository;
use Nette\Application\UI\Control;


final class PostListControl extends Control
{

	/**
	 * @var PostRepository
	 */
	private $postRepository;
	/**
	 * @var PostInfoControlFactory
	 */
	private $postInfoControlFactory;


	public function __construct(
		PostRepository $postRepository,
		PostInfoControlFactory $postInfoControlFactory
	) {
		parent::__construct();
		$this->postRepository = $postRepository;
		$this->postInfoControlFactory = $postInfoControlFactory;
	}


	public function render(): void
	{
		$template = $this->getTemplate();
		$template->posts = $this->postRepository->findAll();
		$template->setFile(__DIR__ . '/templates/postList.latte');
		$template->render();
	}


	protected function createComponentPostInfo(): PostInfoControl
	{
		return $this->postInfoControlFactory->create();
	}
}
