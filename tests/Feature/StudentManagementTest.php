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
        $this->actingAs($this->makeAdminUser());

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
        $this->actingAs($this->makeAdminUser());

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
        $this->actingAs($this->makeAdminUser());

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

        $response = $this->get('/admin/students');

        $response->assertOk();
        $response->assertSee('All Students');
        $response->assertSee('Active Students');
        $response->assertSee('Gmail Students (Optional Filter)');
        $response->assertSee('Page Active');
        $response->assertSee('Page Inactive');
    }

    public function test_students_page_filters_results_by_search_term(): void
    {
        $this->actingAs($this->makeAdminUser());

        Student::create([
            'name' => 'Jethro Pestano',
            'age' => 21,
            'address' => 'Bulan Sorsogon',
            'email' => 'jethro.pestano@sorsu.edu.ph',
            'status' => 'active',
        ]);

        Student::create([
            'name' => 'Erica Muring',
            'age' => 20,
            'address' => 'Bulan Sorsogon',
            'email' => 'erica.muring@sorsu.edu.ph',
            'status' => 'active',
        ]);

        Student::create([
            'name' => 'Jhazel Cruzet',
            'age' => 21,
            'address' => 'Bulan Sorsogon',
            'email' => 'jhazel.cruzet@sorsu.edu.ph',
            'status' => 'inactive',
        ]);

        $response = $this->get('/admin/students?q=erica');

        $response->assertOk();
        $response->assertSee('Showing results for "erica".');
        $response->assertSee('Erica Muring');
        $response->assertDontSee('Jethro Pestano');
        $response->assertDontSee('Jhazel Cruzet');
    }

    public function test_user_students_page_hides_management_actions(): void
    {
        $this->actingAs($this->makeUser());

        Student::create([
            'name' => 'Limited Access Student',
            'age' => 19,
            'address' => 'Mandaluyong',
            'email' => 'limited@example.com',
            'status' => 'active',
        ]);

        $response = $this->get('/user/students');

        $response->assertOk();
        $response->assertSee('Limited Access Student');
        $response->assertSee('View');
        $response->assertDontSee('Edit');
        $response->assertDontSee('Delete');
    }

    public function test_user_cannot_access_admin_student_actions(): void
    {
        $this->actingAs($this->makeUser());

        $this->get('/students/create')->assertForbidden();
    }

    private function makeAdminUser(): \App\Models\User
    {
        return \App\Models\User::create([
            'name' => 'Admin Tester',
            'email' => 'admin-tester@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);
    }

    private function makeUser(): \App\Models\User
    {
        return \App\Models\User::create([
            'name' => 'User Tester',
            'email' => 'user-tester@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);
    }
}
