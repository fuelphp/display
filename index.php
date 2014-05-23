<?php

include 'vendor/autoload.php';

use Fuel\Display\ViewManager;
use Fuel\Display\Parser\Php as PhpParser;
use Fuel\Display\Parser\Twig as TwigParser;
use Fuel\Display\Parser\Smarty as SmartyParser;
use Fuel\Display\Parser\Mustache as MustacheParser;
use Fuel\Display\Parser\Markdown as MarkdownParser;
use Fuel\Display\Parser\MarkdownExtra as MarkdownExtraParser;

$finder = new \Fuel\FileSystem\Finder();
$manager = new ViewManager($finder, array(
	'cache' => __DIR__.'/cache',
));
$finder = $manager->getFinder();
$manager->set('global', 'message');
$finder->addPath(__DIR__);

$manager->registerParser('php', new PhpParser);
$manager->registerParser('twig', new TwigParser);
$manager->registerParser('mustache', new MustacheParser);
$manager->registerParser('md', new MarkdownParser);
$manager->registerParser('mde', new MarkdownExtraParser);
$manager->registerParser('tpl', new SmartyParser);

echo $manager->forge('test.twig', array('name' => 'Frank'))->render();
echo $manager->forge('test.mustache', array('name' => 'Mr. Mustache!'));
echo $manager->forge('test.md')->render();
echo $manager->forge('test.mde');
echo $manager->forge('test.tpl', array('what' => 'Pants'))->render();

$manager->registerParser('handlebars', new \Fuel\Display\Parser\Handlebars());
echo $manager->forge('partial_container.handlebars', ['names' => [
		'Bob',
		'Jack',
		'Juan',
		'Andy',
	]])
	->render();
echo "\n";
