<?php

use PHPUnit\Framework\TestCase;
use App\Controller\HomeController;

class HomeControllerTest extends TestCase
{
    protected $homeController;

    protected function setUp(): void
    {
        $this->homeController = new HomeController();
    }

    public function testHomePageRendering()
    {
        $response = $this->homeController->index();
        $this->assertStringContainsString('<h1>Welcome to the Home Page</h1>', $response);
    }

    public function testHomePageStatusCode()
    {
        $response = $this->homeController->index();
        $this->assertEquals(200, http_response_code());
    }
}