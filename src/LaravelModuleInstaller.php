<?php

declare(strict_types=1);

namespace Brnbio\LaravelModuleInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Exception;

/**
 * Class LaravelModuleInstaller
 * @package Brnbio\LaravelModuleInstaller
 */
class LaravelModuleInstaller extends LibraryInstaller
{
    /**
     * Default module installation dir
     * @var string
     */
    public const DEFAULT_MODULE_DIR = "Modules";

    /**
     * Get the fully-qualified install path
     *
     * @param PackageInterface $package
     * @return string
     * @throws Exception
     */
    public function getInstallPath(PackageInterface $package): string
    {
        return implode('/', [
            $this->getBaseInstallationPath($package),
            $this->getModuleName($package),
        ]);
    }

    /**
     * Get the base path that the module should be installed into.
     * Defaults to Modules/ and can be overridden in the module's composer.json.
     *
     * @param PackageInterface $package
     * @return string
     */
    protected function getBaseInstallationPath(PackageInterface $package): string
    {
        if (($extra = $package->getExtra()) && !empty($extra['module-dir'])) {
            return $extra['module-dir'];
        }

        return self::DEFAULT_MODULE_DIR;
    }

    /**
     * @param PackageInterface $package
     * @return string
     */
    protected function getModuleName(PackageInterface $package): string
    {
        $module = explode('/', $package->getPrettyName());

        return str_replace('-module', '', array_pop($module));
    }

    /**
     * @param $packageType
     * @return bool
     */
    public function supports($packageType): bool
    {
        return 'laravel-module' === $packageType;
    }
}
