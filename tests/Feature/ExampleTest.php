<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test plan
     */

    // A file is uploaded and saved successfully on disk and in the DB
    // A file's visibility can be toggled
    // A user can only see their files
    // A public file can be downloaded by authenticated or unauthenticated users
    // A private file cannot be downloaded by unauthenticated users
    // A private file cannot be downloaded by other users than the owner
    // A private file can be downloaded by the logged-in owner
    // A downloaded file is tracked properly in the DB
    // A file is deleted properly
    // When a user is deleted, their **local** files are also deleted - does not apply to files stored in the cloud
}
