<?php
namespace LyraNetwork\Tests;

use PHPUnit_Framework_TestCase;

/**
 * ./vendor/bin/phpunit src/LyraNetwork/Tests/AutoloaderTest.php
 */
class AutloaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * ./vendor/bin/phpunit --filter testAutoloader src/LyraNetwork/Tests/AutoloaderTest.php
     * Test standalone autoloader (not the composer one)
     */
    public function testAutoloader()
    {
        require(__DIR__ . '/../../autoload.php');
    }
}