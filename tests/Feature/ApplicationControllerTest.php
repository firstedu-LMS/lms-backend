<?php

namespace Tests\Feature;

use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_index_get_the_expect_collection()
    {
        $applications = Application::factory()->count(3)->create();
        $response = $this->get('/api/admin/applications');
        $response->assertStatus(200)
                 ->assertJson([
                     'condition' => config('http_status_code.true'),
                     'message' => 'All applications',
                     'error' => [],
                     'data' => ApplicationResource::collection($applications)->jsonSerialize()
                 ]);
    }
}
