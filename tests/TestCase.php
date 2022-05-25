<?php

namespace LiveCoinWatchApi\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Dotenv\Dotenv;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $dotenv = Dotenv::createImmutable(dirname(__FILE__, 2));
        /** @noinspection UnusedFunctionResultInspection */
        $dotenv->load();
    }
}