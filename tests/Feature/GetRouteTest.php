<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

/**
 * The purpose of this test class is to test responses from routes when using a GET.
 * Responses should vary based on if the user has been authenticated,
 * and if the user has admin privileges or not
 */
class GetRouteTest extends TestCase
{
    public function loginWithFakeAdminUser()
    {
        $user = new User([
            'user_id' => 1,
            'name' => 'TestGuy1',
            'is_admin' => 'true'
        ]);
        $this->be($user);
    }

    public function loginWithFakeUser()
    {
        $user = new User([
            'user_id' => 1,
            'name' => 'TestGuy2'
        ]);
        $this->be($user);
    }


    /*
     * Non authenticated user section
     */
    public function testNonAuthenticatedUserCannotGetToAdminDashboard() {
        $response = $this->get('/admin')->assertStatus(403);
    }

    public function testNonAuthenticatedUserCannotGetToSubmissions() {
        $response = $this->get('/submissions')->assertRedirect('/login');
    }

    public function testNonAuthenticatedUserCannotGetToAccount() {
        $response = $this->get('/account')->assertRedirect('/login');
    }

    /*
     * Authenticated, non-admin user section
     */
    public function testNonAdminUserCannotGetToAdminDashboard() {
        $this->loginWithFakeUser();
        $response = $this->get('/admin')->assertStatus(403);
    }

    public function testNonAuthenticatedUserCanGetToSubmissions() {
        $this->loginWithFakeUser();
        $response = $this->get('/submissions')->assertOk();
    }

    public function testNonAuthenticatedUserCanGetToAccount() {
        $this->loginWithFakeUser();
        $response = $this->get('/account')->assertOk();
    }


    /*
     * Admin user section
     */
    public function testAuthenticatedUsersCanSeeAdminDashboard() {
        $this->loginWithFakeAdminUser();
        $response = $this->get('/admin')->assertOk();
    }

    public function testAdminUserCanAccessDatabsaePage() {
        $this->loginWithFakeAdminUser();
        $response = $this->get('/admin/database')->assertOk();
    }

    public function testAdminUserCanAccessUserSubmissionForThemselves() {
        $this->loginWithFakeAdminUser();
        $response = $this->get('/submissions')->assertOk();
    }
}
