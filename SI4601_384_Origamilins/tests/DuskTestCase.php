<?php

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     */
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--no-sandbox',
            '--window-size=1920,1080',
            '--disable-dev-shm-usage',
            '--ignore-certificate-errors',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', 
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, 
                $options
            )
        );
    }
}
