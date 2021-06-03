<?php

declare(strict_types=1);

use Contao\EasyCodingStandard\Sniffs\ContaoFrameworkClassAliasSniff;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowArrayTypeHintSyntaxSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__.'/vendor/contao/easy-coding-standard/config/set/contao.php');

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::CACHE_DIRECTORY, sys_get_temp_dir().'/ecs_self_cache');
    $parameters->set(
        Option::SKIP,
        [
            HeaderCommentFixer::class => null,
            ContaoFrameworkClassAliasSniff::class => null,
            DisallowArrayTypeHintSyntaxSniff::class => null,
        ]
    );
};
