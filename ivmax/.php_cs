<?php

$rules = [
    '@PSR2' => true,
    '@Symfony' => true,
    'array_syntax' => ['syntax' => 'short'],
    'concat_space' => ['spacing' => 'one'],
    'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
    'no_short_echo_tag' => true,
    'not_operator_with_successor_space' => true,
    'no_useless_else' => true,
    'ordered_imports' => ['sortAlgorithm' => 'length'],
    'phpdoc_order' => true,
    'phpdoc_separation' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_trim' => true,
    'phpdoc_var_without_name' => true,
    'phpdoc_to_comment' => true,
    'single_quote' => true,
    'ternary_operator_spaces' => true,
    'trailing_comma_in_multiline_array' => true,
    'trim_array_spaces' => true,
    'yoda_style' => [
        'always_move_variable' => false,
        'equal' => false,
        'identical' => false,
        'less_and_greater' => false,
    ],
];

$excludes = [
    'vendor',
    'storage',
    'bootstrap',
    'node_modules',
];

return PhpCsFixer\Config::create()
    ->setRules($rules)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->exclude($excludes)
            ->notName('README.md')
            ->notName('*.xml')
            ->notName('*.yml')
            ->notName('_ide_helper.php')
    );