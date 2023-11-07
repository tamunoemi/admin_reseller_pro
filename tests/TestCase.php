<?php

namespace Teckipro\Admin\Tests;

use Teckipro\Admin\Providers\TeckiproAdminBladeServiceProvider;
use Teckipro\Admin\Providers\TeckiproAdminServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    // additional setup
  }

  protected function getPackageProviders($app)
  {
    return [
        TeckiproAdminServiceProvider::class,
        TeckiproAdminBladeServiceProvider::class
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
  }
}
