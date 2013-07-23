<?php
include 'vendor/autoload.php';

use Fuel\FileSystem\Finder;
use Fuel\Presenter\ViewManager;
use Fuel\Presenter\Parser\Php as PhpParser;
use Fuel\Presenter\Parser\Twig as TwigParser;
use Fuel\Presenter\Parser\Smarty as SmartyParser;
use Fuel\Presenter\Parser\Mustache as MustacheParser;
use Fuel\Presenter\Parser\Markdown as MarkdownParser;
use Fuel\Presenter\Parser\MarkdownExtra as MarkdownExtraParser;

$manager = new ViewManager(null, array(
	'cache' => __DIR__.'/cache',
));
$finder = $manager->getFinder();
$manager->set('global', 'message');
$finder->addPath(__dir__);
$manager->registerParser('php', new PhpParser);
$manager->registerParser('twig', new TwigParser);
$manager->registerParser('mustache', new MustacheParser);
$manager->registerParser('md', new MarkdownParser);
$manager->registerParser('mde', new MarkdownExtraParser);
$manager->registerParser('tpl', new SmartyParser);
echo ($manager->forge('test.twig', array('name' => 'Frank'))->render());
echo $manager->forge('test.mustache', array('name' => 'Mr. Mustache!'));
echo $manager->forge('test.md')->render();
echo $manager->forge('test.mde');
echo $manager->forge('test.tpl', array('what' => 'Pants'))->render();
