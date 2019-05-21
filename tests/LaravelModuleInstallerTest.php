<?php

declare(strict_types=1);

use Brnbio\LaravelModuleInstaller\LaravelModuleInstaller;
use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use PHPUnit\Framework\TestCase;
use Mockery\MockInterface;

/**
 * Class LaravelModuleInstallerTest
 */
class LaravelModuleInstallerTest extends TestCase
{
    /**
     * @var IOInterface
     */
    protected $io;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var LaravelModuleInstaller
     */
    protected $laravelModuleInstaller;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->io = Mockery::mock(IOInterface::class);
        $this->composer = Mockery::mock(Composer::class);
        $package = Mockery::mock(PackageInterface::class);
        $package->shouldReceive('getExtra')->andReturn([]);

        $this->composer
            ->allows([
                'getPackage' => $this->composer,
                'getDownloadManager' => $this->composer,
                'getConfig' => $this->composer,
                'get' => $this->composer,
            ]);

        $this->laravelModuleInstaller = new LaravelModuleInstaller($this->io, $this->composer);
    }

    /**
     * Your package composer.json file must include:
     * "type": "laravel-module",
     *
     * @return void
     */
    public function testSupport(): void
    {
        $this->assertFalse($this->laravelModuleInstaller->supports('module'));
        $this->assertTrue($this->laravelModuleInstaller->supports('laravel-module'));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testPackageName(): void
    {
        /** @var PackageInterface $package */
        $package = $this->getMockPackage('vendor');
        $this->assertEquals('Modules/vendor', $this->laravelModuleInstaller->getInstallPath($package));

        /** @var PackageInterface $package */
        $package = $this->getMockPackage('vendor/name');
        $this->assertEquals('Modules/name', $this->laravelModuleInstaller->getInstallPath($package));

        /** @var PackageInterface $package */
        $package = $this->getMockPackage('vendor/name-module');
        $this->assertEquals('Modules/name', $this->laravelModuleInstaller->getInstallPath($package));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCustomModuleDir(): void
    {
        /** @var PackageInterface $package */
        $package = Mockery::mock(PackageInterface::class);
        $package->shouldReceive('getPrettyName')->andReturn('vendor/name');
        $package->shouldReceive('getExtra')->andReturn(['module-dir' => 'Custom']);

        $this->assertEquals('Custom/name', $this->laravelModuleInstaller->getInstallPath($package));
    }

    /**
     * @param string $packageName
     * @return MockInterface
     */
    public function getMockPackage(string $packageName): MockInterface
    {
        $package = Mockery::mock(PackageInterface::class);
        $package->shouldReceive('getPrettyName')->andReturn($packageName);
        $package->shouldReceive('getExtra')->andReturn(null);

        return $package;
    }
}
