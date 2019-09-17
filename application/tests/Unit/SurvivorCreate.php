<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurvivorCreate extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->withHeaders([
                        'Accept' => 'application/json',
                    ])
                    ->json('POST', '/api/survivor/', [
                        'name' => 'Sally',
                        "gender"=>1,
                        "age"=>22,
                        "lat"=>1.587,
                        "long"=>-8.887,
                        "inventory"=>[
                            [
                                "item"=>3,
                                "ammount"=>5
                            ],
                            [
                                "item"=>1,
                                "ammount"=>2
                            ]
                        ]
                    ]);
        $response->assertStatus(201);
    }
}
