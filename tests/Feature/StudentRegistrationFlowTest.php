<?php

namespace Tests\Feature;

use App\Models\Ekskul;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentRegistrationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_pending_registration_is_not_visible_on_student_dashboard_until_accepted(): void
    {
        $teacher = User::factory()->create([
            'name' => 'Guru Futsal',
            'role' => 'guru',
        ]);

        $student = User::factory()->create([
            'name' => 'Siswa A',
            'role' => 'siswa',
        ]);

        $ekskul = Ekskul::create([
            'title' => 'Futsal',
            'category' => 'Olahraga',
            'coach' => $teacher->name,
            'description' => 'Ekskul latihan sepak bola.',
            'image' => 'https://example.com/futsal.jpg',
        ]);

        Registration::create([
            'user_id' => $student->id,
            'ekskul_id' => $ekskul->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($student)->get('/dashboard');

        $response->assertOk();
        $this->assertCount(0, $response->original->getData()['registrations']);
    }

    public function test_teacher_can_grade_student_once_per_day_and_update_existing_score_for_that_day(): void
    {
        $teacher = User::factory()->create([
            'name' => 'Guru Futsal',
            'role' => 'guru',
        ]);

        $student = User::factory()->create([
            'name' => 'Siswa A',
            'role' => 'siswa',
        ]);

        $ekskul = Ekskul::create([
            'title' => 'Futsal',
            'category' => 'Olahraga',
            'coach' => $teacher->name,
            'description' => 'Ekskul latihan sepak bola.',
            'image' => 'https://example.com/futsal.jpg',
        ]);

        $registration = Registration::create([
            'user_id' => $student->id,
            'ekskul_id' => $ekskul->id,
            'status' => 'diterima',
        ]);

        $today = now()->toDateString();
        $tomorrow = now()->addDay()->toDateString();

        $this->actingAs($teacher)
            ->post('/guru/evaluation/' . $registration->id, [
                'score' => 85,
                'notes' => 'Hari pertama',
                'evaluation_date' => $today,
            ])
            ->assertRedirect();

        $this->actingAs($teacher)
            ->post('/guru/evaluation/' . $registration->id, [
                'score' => 92,
                'notes' => 'Hari berikutnya',
                'evaluation_date' => $tomorrow,
            ])
            ->assertRedirect();

        $this->assertDatabaseCount('ekskul_evaluations', 2);
        $this->assertDatabaseHas('ekskul_evaluations', [
            'registration_id' => $registration->id,
            'evaluation_date' => $today,
            'score' => 85,
        ]);
        $this->assertDatabaseHas('ekskul_evaluations', [
            'registration_id' => $registration->id,
            'evaluation_date' => $tomorrow,
            'score' => 92,
        ]);

        $this->actingAs($teacher)
            ->post('/guru/evaluation/' . $registration->id, [
                'score' => 97,
                'notes' => 'Edit karena typo',
                'evaluation_date' => $today,
            ])
            ->assertRedirect();

        $this->assertDatabaseCount('ekskul_evaluations', 2);
        $this->assertDatabaseHas('ekskul_evaluations', [
            'registration_id' => $registration->id,
            'evaluation_date' => $today,
            'score' => 97,
        ]);
    }
}
