<?php declare(strict_types=1);

namespace App\Contact\Controls;

use App\Contact\Contact;


interface ContactControlFactory
{

	public function create(Contact $contact): ContactControl;
}
