<?php

namespace Tests\Fixtures;

use Illuminate\Routing\Controller as BaseController;

final class Controller extends BaseController
{
    /**
     * First string for the `qwe()` method.
     *
     * Description for the `qwe()` method.
     *
     * @deprecated
     *
     * @throw \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
     * @throw \Exception
     * @throw \Illuminate\Foundation\Http\Exceptions\MaintenanceModeException
     *
     * @return void
     */
    public function qwe()
    {
        //
    }

    /**
     * It's a summary.
     *
     * It's a description.
     *
     * @param  string  $foo  Description for the parameter.
     */
    public function rty(string $foo)
    {
        //
    }

    /**
     * @param  \Tests\Fixtures\Request  $request
     * @param  string  $foo
     * @param  string|null  $bar
     */
    public function qwerty(Request $request, string $foo, string $bar = null)
    {
        //
    }
}
