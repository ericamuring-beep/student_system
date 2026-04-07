<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_student_via_web_form(): void
    {
        $response = $this->post('/students/store', [
            'name' => 'Ana Cruz',
            'age' => 20,
            'address' => 'Manila',
            'email' => 'ana@example.com',
            'status' => 'active',
        ]);

        $response->assertRedirect('/students');

        $this->assertDatabaseHas('students', [
            'name' => 'Ana Cruz',
            'email' => 'ana@example.com',
            'status' => 'active',
        ]);
    }

    public function test_it_updates_and_deletes_a_student_via_web_routes(): void
    {
        $student = Student::create([
            'name' => 'Old Name',
            'age' => 19,
            'address' => 'Quezon City',
            'email' => 'old@example.com',
            'status' => 'inactive',
        ]);

        $updateResponse = $this->post('/students/update/' . $student->id, [
            'name' => 'New Name',
            'age' => 21,
            'address' => 'Pasig',
            'email' => 'new@example.com',
            'status' => 'active',
        ]);

        $updateResponse->assertRedirect('/students');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
            'status' => 'active',
        ]);

        $deleteResponse = $this->post('/students/delete/' . $student->id);
        $deleteResponse->assertRedirect('/students');

        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
        ]);
    }

    public function test_active_and_gmail_filters_return_correct_students(): void
    {
        Student::create([
            'name' => 'Active Gmail',
            'age' => 18,
            'address' => 'Taguig',
            'email' => 'active@gmail.com',
            'status' => 'active',
        ]);

        Student::create([
            'name' => 'Inactive Gmail',
            'age' => 22,
            'address' => 'Makati',
            'email' => 'inactive@gmail.com',
            'status' => 'inactive',
        ]);

        Student::create([
            'name' => 'Active Non Gmail',
            'age' => 23,
            'address' => 'Pasay',
            'email' => 'active@yahoo.com',
            'status' => 'active',
        ]);

        $activeResponse = $this->getJson('/api/students/active');
        $activeResponse->assertOk();
        $activeResponse->assertJsonCount(2);

        $gmailResponse = $this->getJson('/api/students/gmail');
        $gmailResponse->assertOk();
        $gmailResponse->assertJsonCount(2);
    }

    public function test_students_page_displays_lists(): void
    {
        Student::create([
            'name' => 'Page Active',
            'age' => 20,
            'address' => 'Caloocan',
            'email' => 'pageactive@gmail.com',
            'status' => 'active',
        ]);

        Student::create([
            'name' => 'Page Inactive',
            'age' => 21,
            'address' => 'Paranaque',
            'email' => 'pageinactive@example.com',
            'status' => 'inactive',
        ]);

        $response = $this->get('/students');

        $response->assertOk();
        $response->assertSee('All Students');
        $response->assertSee('Active Students');
        $response->assertSee('Gmail Students (Optional Filter)');
        $response->assertSee('Page Active');
        $response->assertSee('Page Inactive');
    }
}
