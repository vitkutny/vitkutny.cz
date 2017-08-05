<?php declare(strict_types = 1);

namespace App\DisqusModule\Controls;

interface DisqusControlFactory
{

	public function create(): DisqusControl;
}
