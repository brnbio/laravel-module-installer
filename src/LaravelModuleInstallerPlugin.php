<?php

declare(strict_types=1);

namespace Brnbio\LaravelModuleInstaller;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * Class LaravelModuleInstallerPlugin
 * @package Brnbio\LaravelModuleInstaller
 */
class LaravelModuleInstallerPlugin implements PluginInterface
{
    /**
     * @param Composer $composer
     * @param IOInterface $io
     * @return void
     */
    public function activate(Composer $composer, IOInterface $io): void
    {
        $installer = new LaravelModuleInstaller($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
}
