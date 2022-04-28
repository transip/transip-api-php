<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->in('.')
    ->files()
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->exclude('vendor');

return (new PhpCsFixer\Config)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder);
