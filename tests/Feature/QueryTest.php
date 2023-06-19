<?php

namespace Tests\Feature;

use App\Http\Controllers\IsTestController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $obj=new IsTestController ;
        $query= $obj->makeQuery(new User,"name,like,Dr.%",'attributes',"mobile,regexp,\+1[0-9-]+","mobile,desc");
        //echo ($query->toSql());

    }
}
