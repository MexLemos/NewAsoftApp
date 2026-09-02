<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Course;
use Spatie\Permission\Models\Role;

class TurmaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_update_a_turma()
    {
        // Create an admin user
        $admin = User::factory()->create();
        // Ensure required roles exist
        \App\Models\Role::create(['name' => 'admin']);
        \App\Models\Role::create(['name' => 'formador']);
        $admin->assignRole('admin');

        // Create a trainer (formador)
        $trainer = User::factory()->create(['name' => 'John Trainer']);
        $trainer->assignRole('formador');

        // Create a course
        $course = Course::factory()->create(['title' => 'English Basics']);

        // Create a turma linked to the course
        $turma = Turma::create([
            'course_id'    => $course->id,
            'name'         => 'Morning Class',
            'monthly_fee'  => 20000,
            'is_active'    => true,
        ]);

        // Prepare update data
        $updateData = [
            'course_id'    => $course->id,
            'name'         => 'Updated Class Name',
            'monthly_fee'  => 25000,
            'trainer_id'   => $trainer->id,
            // Checkbox present to set active
            'is_active'    => 'on',
        ];

        // Perform the update request as admin
        $response = $this->actingAs($admin)
                         ->put(route('admin.turmas.update', $turma->id), $updateData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('turmas', [
            'id'           => $turma->id,
            'name'         => 'Updated Class Name',
            'monthly_fee'  => 25000,
            'trainer_id'   => $trainer->id,
            'is_active'    => true,
        ]);
    }
}
?>
