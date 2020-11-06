<?php

use Tests\Fixtures\Controller;

app('router')->get('/foo', function () {
});

app('router')->match(['PUT', 'PATCH'], '/bar', function () {
});

app('router')->get('/_ignition/baq', function () {
});

app('router')->get('/telescope/baw', function () {
});

app('router')->get('/_debugbar/bae', function () {
});

app('router')->get('/api/qwe', [Controller::class, 'qwe']);

app('router')->get('/api/rty/{foo}', [Controller::class, 'rty']);

app('router')->post('/api/qwerty/{foo}/{bar?}', [Controller::class, 'qwerty']);
