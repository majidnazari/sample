<?php

namespace Tests\Feature;

use App\Http\Controllers\IsTestController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Middleware\CheckIranianMiddleware;
use Illuminate\Http\Request;

use Tests\TestCase;

class QueryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_makeQuery()
    {
        $request = new Request;
        $user = User::whereHas('attributes', function ($query) {
            $query->where('country', 'like', 'Iran');
        })
            ->with(['attributes' => function ($query) {
                $query->where('country', 'like', 'Iran');
            }])
            ->first();

        $url = 'http://localhost/iranian-user/'.$user->id;
        $this->assertStringContainsString("The user: Delphine Hudson with id:" . $user->id, $this->get($url)->getContent());
    }
}
