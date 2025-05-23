<?php

namespace Tests;

<<<<<<< HEAD
=======
use Laravel\Dusk\TestCase as BaseTestCase;
>>>>>>> 0f30fca72b2b33e45ac6675496ba4b0aa6c31e50
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
<<<<<<< HEAD
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
=======

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     */
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver([
                '--port=9515',
                '--whitelisted-ips=""'
            ]);
>>>>>>> 0f30fca72b2b33e45ac6675496ba4b0aa6c31e50
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
<<<<<<< HEAD
        $options = (new ChromeOptions)->addArguments([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
            '--disable-search-engine-choice-screen',
            '--disable-smooth-scrolling',
            '--disable-gpu',
     
        ]);
    
=======
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
            '--disable-search-engine-choice-screen',
            '--disable-smooth-scrolling',
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
            return $items->merge([
                '--disable-gpu',
                '--headless=new',
            ]);
        })->all());

>>>>>>> 0f30fca72b2b33e45ac6675496ba4b0aa6c31e50
        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? env('DUSK_DRIVER_URL') ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }
<<<<<<< HEAD
    

    protected function baseUrl()
    {
        return 'http://127.0.0.1:8000';
    }
}
=======

    /**
     * Determine whether Dusk should run in headless mode.
     */
    protected function hasHeadlessDisabled(): bool
    {
        return env('DUSK_HEADLESS_DISABLED', false);
    }
}
>>>>>>> 0f30fca72b2b33e45ac6675496ba4b0aa6c31e50
