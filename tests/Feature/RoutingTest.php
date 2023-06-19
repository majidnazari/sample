<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_exported_file()
    {
        $route="/check-export";
        $response=$this->get($route);
        $response->assertStatus(200);
        
    } 
    public function test_exist_excel_file()
    {
        $route="/checkExcelFile";
        $response=$this->get($route);
        $this->assertEquals(200,$response->status());  
        
    } 
     
}
