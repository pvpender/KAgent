<?php

namespace pvpender\KAgent;
use pvpender\KAgent\UserAgentInterface;

class UserAgent implements UserAgentInterface {


    private ?string $platform;
    private ?string $browser;
    private ?string $browserVersion;

    /**
     * UserAgent constructor
     */
    public function __construct(?string $platform, ?string $browser, ?string $browserVersion ) {
        $this->platform       = $this->checkIfNull($platform);
        $this->browser        = $this->checkIfNull($browser);
        $this->browserVersion = $this->checkIfNull($browserVersion);
    }

    /**
     * @see \pvpender\KAgent\Platforms for a list of tested platforms
     */
    public function platform(): ?string
    {
        return $this->platform;
    }

    /**
     * @see \pvpender\KAgent\Browsers for a list of tested browsers.
     */
    public function browser(): ?string
    {
        return $this->browser;
    }

    /**
     * The version string. Formatting depends on the browser.
     */
    public function browserVersion(): ?string
    {
        return $this->browserVersion;
    }

    private function checkIfNull(?string $arg): ?string
    {
        if (is_null($arg) || $arg === "null" || $arg === "false"){
            return null;
        }
        return $arg;
    }
}