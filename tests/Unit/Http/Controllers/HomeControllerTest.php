<?php

namespace Tests\Unit\Http\Controllers;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\HomeController;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection as Collection;

class HomeControllerTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->mock(UserRepositoryInterface::class);

        $this->controller = new HomeController(
            $this->userRepository
        );
    }

    public function mock($class)
    {
        $this->mock = Mockery::mock($class);

        $this->app->instance($class, $this->mock);

        return $this->mock;
    }

    /**
     * Test show user success
     *
     * @return void
     */
    public function test_index_return_view()
    {
        $user = User::all();
        $this->userRepository->shouldReceive('findAll');
        $view = $this->controller->index();

        $this->assertEquals('home', $view->getName());
        $this->assertArrayHasKey('user', $view->getData());
    }
}
