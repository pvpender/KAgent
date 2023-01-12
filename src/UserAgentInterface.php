<?php

namespace pvpender\KAgent;

interface UserAgentInterface {

    /**
     * @see \pvpender\KAgent\Platforms for a list of tested platforms
     */
    public function platform(): ?string;

    /**
     * @see \pvpender\KAgent\Browsers for a list of tested browsers.
     */
    public function browser(): ?string;

    /**
     * The version string. Formatting depends on the browser.
     */
    public function browserVersion(): ?string;
}