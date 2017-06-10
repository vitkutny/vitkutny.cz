<?php declare(strict_types=1);

namespace App\BlogModule\Controls;

interface PostInfoControlFactory
{

	public function create(): PostInfoControl;
}
