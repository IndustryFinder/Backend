<?php

namespace Tests\Feature\models;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Ad;


class AdTest extends TestCase
{
    use refreshDarabase;
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function insertdata()
    {
        $data= Ad::factory()->make()->toArray();
        Ad::create($data);
        $this->assertDatabaseHas('Ads', $data);
    }
}
