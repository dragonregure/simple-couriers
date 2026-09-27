<?php

namespace Tests\Feature;

use App\Modules\Couriers\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourierApiTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexPaginatesSortsByNameByDefaultAndFiltersSearchAndLevel(): void
    {
        Courier::factory()->create(['name' => 'Zeta Courier', 'level' => 2]);
        $matched = Courier::factory()->create(['name' => 'Budiono Hadi Agung', 'level' => 3]);
        Courier::factory()->create(['name' => 'Budiono Raya', 'level' => 4]);
        Courier::factory()->create(['name' => 'Agung Express', 'level' => 2]);

        $response = $this->getJson('/api/v1/couriers?search=budi+agung&level=2,3&per_page=10');

        $response->assertOk()
            ->assertJsonPath('data.0.id', $matched->id)
            ->assertJsonPath('meta.per_page', 10)
            ->assertJsonCount(1, 'data');
    }

    public function testIndexCanSortByRegisteredAt(): void
    {
        Courier::factory()->create(['name' => 'A Courier', 'registered_at' => '2026-01-03 00:00:00']);
        $older = Courier::factory()->create(['name' => 'Z Courier', 'registered_at' => '2026-01-01 00:00:00']);

        $response = $this->getJson('/api/v1/couriers?sort=registered_at&per_page=10');

        $response->assertOk()
            ->assertJsonPath('data.0.id', $older->id);
    }

    public function testShowReturnsCourierData(): void
    {
        $courier = Courier::factory()->create(['name' => 'Budi Agung']);

        $response = $this->getJson('/api/v1/couriers/' . $courier->id);

        $response->assertOk()
            ->assertJsonPath('data.id', $courier->id)
            ->assertJsonPath('data.name', 'Budi Agung');
    }

    public function testStoreValidatesAndPersistsCourier(): void
    {
        $payload = $this->validPayload();

        $response = $this->postJson('/api/v1/couriers', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.name', $payload['name'])
            ->assertJsonPath('data.level', 4);

        $this->assertDatabaseHas('couriers', [
            'name' => $payload['name'],
            'phone' => $payload['phone'],
            'level' => 4,
        ]);
    }

    public function testStoreRejectsInvalidPayload(): void
    {
        $response = $this->postJson('/api/v1/couriers', [
            'name' => '',
            'phone' => 'not a phone',
            'level' => 6,
            'status' => 'unknown',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'phone', 'level', 'status']);
    }

    public function testUpdateValidatesAndPersistsChanges(): void
    {
        $courier = Courier::factory()->create(['level' => 1]);

        $response = $this->putJson('/api/v1/couriers/' . $courier->id, [
            'name' => 'Updated Courier',
            'level' => 5,
            'status' => 'inactive',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.name', 'Updated Courier')
            ->assertJsonPath('data.level', 5)
            ->assertJsonPath('data.status', 'inactive');

        $this->assertDatabaseHas('couriers', [
            'id' => $courier->id,
            'name' => 'Updated Courier',
            'level' => 5,
            'status' => 'inactive',
        ]);
    }

    public function testDestroyDeletesCourier(): void
    {
        $courier = Courier::factory()->create();

        $response = $this->deleteJson('/api/v1/couriers/' . $courier->id);

        $response->assertNoContent();
        $this->assertDatabaseMissing('couriers', ['id' => $courier->id]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validPayload(): array
    {
        return [
            'name' => 'Budi Agung',
            'phone' => '+62 812 3456 7890',
            'email' => 'budi.agung@example.test',
            'level' => 4,
            'status' => 'active',
            'vehicle_type' => 'motorcycle',
            'vehicle_plate_number' => 'B 1234 AG',
            'service_area' => 'Jakarta Selatan',
            'registered_at' => '2026-09-27T08:00:00+07:00',
            'notes' => 'Available for same-day delivery.',
        ];
    }
}
