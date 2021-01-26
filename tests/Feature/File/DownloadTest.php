<?php

namespace Tests\Feature\File;

use App\Http\Livewire\FileUpload;
use App\Http\Livewire\File as LivewireFile;
use App\Models\Download;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class DownloadTest extends TestCase
{
    use RefreshDatabase;

    protected $user1;
    protected $user2;
    protected $disk = 'local';

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake($this->disk); // fakes actual file creation to the specified disk

        $this->user1 = User::factory(['name' => 'User One'])->withPersonalTeam()->create();
        $this->user2 = User::factory(['name' => 'User Two'])->withPersonalTeam()->create();
    }

    /**
     * 1. A public file can be downloaded by any user (authenticated or not)
     * 2. A private file can only be downloaded by the logged-in owner
     *
     * Might as well test download tracking while I'm at it...
     * 3. A downloaded file is tracked properly in the DB
     * 4. A file downloaded by its owner is flagged correctly
     *
     * @test
     */
    public function filesCanBeDownloadedBasedOnVisibility()
    {
        $name = 'fakefile.bin';
        $size = 2 * 1024;
        $mime = 'application/octet-stream';
        $file = UploadedFile::fake()->create($name, $size, $mime);

        // Sign in User One
        $this->actingAs($this->user1);

        // Upload a public file
        Livewire::test(FileUpload::class)
            ->set([
                'file' => $file,
                'storageDisk' => $this->disk,
                'isPublic' => true,
            ])
            ->call('save');

        $newFile = File::first();

        // Scenario 3 - There should be 0 downloads for this file initially
        $this->assertDatabaseMissing('downloads', [
            'file_id' => $newFile->id,
        ]);

        // Scenario 1 - Download the public file as authenticated owner (User One)
        $this
            ->assertAuthenticatedAs($this->user1)
            ->get("/f/{$newFile->uuid}/{$newFile->name}")
            ->assertOk();

        // Scenario 3 - There should be 1 download for this file initially
        // Scenario 4 - The download is flagged as downloaded by the owner
        $this
            ->assertDatabaseCount('downloads', 1)
            ->assertDatabaseHas('downloads', [
                'file_id' => $newFile->id,
                'disk' => $this->disk,
                'name' => $name,
                'by_owner' => 1,
            ]);

        // Sign out User One
        Auth::logout();
        // Scenario 1 - Download the public file as unauthenticated user
        $this
            ->assertGuest()
            ->get("/f/{$newFile->uuid}/{$newFile->name}")
            ->assertOk();

        // Scenario 3 - There should now be 2 downloads for this file
        // Scenario 4 - One download is by owner, the other anonymous
        $this->assertDatabaseCount('downloads', 2);
        $downloads = Download::all()->pluck('by_owner');
        $this->assertEquals([1, 0], $downloads->toArray());

        // Sign in User Two
        $this->actingAs($this->user2);
        // Scenario 1 - Download the public file as User Two (not owner)
        $this
            ->assertAuthenticatedAs($this->user2)
            ->get("/f/{$newFile->uuid}/{$newFile->name}")
            ->assertOk();

        // Sign in User One
        $this->actingAs($this->user1);
        // Make it private
        Livewire::test(LivewireFile::class, ['file' => $newFile])
            ->call('toggleVisibility');
        // Scenario 2 - Download the private file as authenticated owner (User One)
        $this
            ->assertAuthenticatedAs($this->user1)
            ->get("/f/{$newFile->uuid}/{$newFile->name}")
            ->assertOk();

        // Sign out User One
        Auth::logout();
        // Scenario 2 - Download the private file as unauthenticated user
        $this
            ->assertGuest()
            ->get("/f/{$newFile->uuid}/{$newFile->name}")
            ->assertNotFound();

        // Sign in User Two
        $this->actingAs($this->user2);
        // Scenario 2 - Download the private file as User Two (not owner)
        $this
            ->assertAuthenticatedAs($this->user2)
            ->get("/f/{$newFile->uuid}/{$newFile->name}")
            ->assertNotFound();

        // Scenario 3 - There should now be 4 downloads
        $this->assertDatabaseCount('downloads', 4);
    }
}
