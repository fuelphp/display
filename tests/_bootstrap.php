<?php
// This is global bootstrap for autoloading

require __DIR__ . '/../vendor/autoload.php';

require __DIR__.'/stubs/ContainerStub.php';

// ugly hack for making DataContainer work
class_alias('Fuel\Common\Arr', 'Arr');
