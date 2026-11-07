<?php

namespace Laravolt\Indonesia\Test;

use Illuminate\Support\Facades\Route;
use Laravolt\Indonesia\Permission;

class RouteAuthorizationTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('laravolt.indonesia.route.enabled', true);
    }

    public function test_admin_routes_require_the_manage_permission(): void
    {
        $names = [
            'indonesia::provinsi.store', 'indonesia::provinsi.update', 'indonesia::provinsi.destroy',
            'indonesia::kabupaten.destroy', 'indonesia::kecamatan.destroy', 'indonesia::kelurahan.destroy',
        ];

        foreach ($names as $name) {
            $route = Route::getRoutes()->getByName($name);
            $this->assertNotNull($route, $name);
            $this->assertContains('can:'.Permission::MANAGE_INDONESIA, $route->gatherMiddleware(), $name);
        }
    }
}
