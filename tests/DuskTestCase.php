<?php

namespace Tests;

use App\Services\Shaarli\Shaarli;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->shaarli()->setLocale('en');
        $this->shaarli()->setSecureLogin(false);
    }

    /**
     * @beforeClass
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--window-size=1920,1080',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    protected function shaarli(): Shaarli
    {
        return app(Shaarli::class);
    }
}
