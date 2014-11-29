<?php

/**
 * Test: SelectBox values translating
 */

use Nette\Forms\Form,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


class Translator implements \Nette\Localization\ITranslator
{
	function translate($message, $count = NULL)
	{
		return ucfirst($message);
	}
}



test(function() {
	$form = new Form;
	$form->setTranslator(new Translator);

	$name = $form->addSelect('list', 'label', array('one', 'two',))->setPrompt('foo');

	Assert::match('<label for="frm-list">Label</label>', (string) $name->getLabel());
	Assert::same('<select name="list" id="frm-list"><option value="">Foo</option><option value="0">One</option><option value="1">Two</option></select>', (string) $name->getControl());
});



test(function() {
	$form = new Form;
	$form->setTranslator(new Translator);

	$name = $form->addSelect('list', 'label', array('one', 'two',))->setPrompt('foo')->doTranslateOptions(FALSE);

	Assert::match('<label for="frm-list">Label</label>', (string) $name->getLabel());
	Assert::same('<select name="list" id="frm-list"><option value="">Foo</option><option value="0">one</option><option value="1">two</option></select>', (string) $name->getControl());
});
