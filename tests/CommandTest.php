<?php

namespace Tests;

final class CommandTest extends TestCase
{
    public function testCommand()
    {
        $this->artisan('swagger:generate');
    }
}
