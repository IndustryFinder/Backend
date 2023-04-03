<?php

namespace Tests\Feature\models;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Company;


class CompanyTest extends TestCase
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
        $data= Company::factory()->make()->toArray();
        Company::create($data);
        $this->assertDatabaseHas('Companies', $data);
    }
}
