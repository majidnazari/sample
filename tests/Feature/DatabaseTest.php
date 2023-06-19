<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\User_Attributes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getTotalCountUser()
    {
        $this->assertDatabaseCount('users', 40000);
    }
    public function test_getFailedSample()
    {
        $user_id=User_Attributes::where('user_id','>', 40000)->first();
        $this->assertNull($user_id);
    }
}
