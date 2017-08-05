<?php declare(strict_types = 1);

namespace App\BlogModule\Controls;

use App\BlogModule\Post\Post;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;


final class PostInfoControl extends Control
{

	public function render(Post $post): void
	{
		/**
		 * @var Template $template
		 */
		$template = $this->getTemplate();
		$template->setParameters([
			'post' => $post,
		]);
		$template->setFile(__DIR__ . '/templates/postInfo.latte');
		$template->render();
	}
}
