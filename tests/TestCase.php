<?php

namespace Tests;

use Tests\TestCollectionData;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestHelpers, DetectRepeatedQueries;

    protected $defaultData = [];

    public function setUp() : void
    {
        parent::setUp();

        $this->addTestResponseMacros();

        $this->withoutExceptionHandling();

        $this->enableQueryLog();
    }

    public function tearDown() : void
    {
        $this->flushQueryLog();

        parent::tearDown();
    }

    protected function addTestResponseMacros()
    {
        TestResponse::macro('viewData', function ($key) {
            $this->ensureResponseHasView();
            $this->assertViewHas($key);
            return $this->original->$key;
        });

        TestResponse::macro('assertViewCollection', function ($var) {
            return new TestCollectionData($this->viewData($var));
        });
    }
}
