<?php

namespace Tests\Feature\File;

use App\Http\Livewire\FileUpload;
use App\Http\Livewire\File as LivewireFile;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class OperationsTest extends TestCase
{
    use RefreshDatabase;

    protected $user1;
    protected $disk = 'local';

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake($this->disk); // fakes actual file creation to the specified disk

        $this->user1 = User::factory(['name' => 'User One'])->withPersonalTeam()->create();

    }

    /**
     * A file is uploaded and saved successfully on disk and in the DB
     *
     * @test
     */
    public function fileIsUploadedAndSavedToDiskAndDb()
    {
        $name = 'fakefile.bin';
        $size = 2 * 1024;
        $mime = 'application/octet-stream';
        $file = UploadedFile::fake()->create($name, $size, $mime);

        $this->actingAs($this->user1);

        Livewire::test(FileUpload::class)
            ->set([
                'file' => $file,
                'storageDisk' => $this->disk,
            ])
            ->call('save')
            ->assertEmitted('newFileUploaded');

        $this->assertDatabaseHas('files', [
            'user_id' => $this->user1->id,
            'public' => 1,
            'disk' => $this->disk,
            'name' => $name,
            'mime' => $mime,
            'size' => $size * 1024,
        ]);

        $newFile = File::first();

        Storage::disk($this->disk)->assertExists($newFile->path());
    }

    /**
     * A file's visibility can be toggled
     *
     * @test
     */
    public function fileVisibilityCanBeToggled()
    {
        $name = 'fakefile.bin';
        $size = 2 * 1024;
        $mime = 'application/octet-stream';
        $file = UploadedFile::fake()->create($name, $size, $mime);

        $this->actingAs($this->user1);

        // Upload a private file
        Livewire::test(FileUpload::class)
            ->set([
                'file' => $file,
                'storageDisk' => $this->disk,
                'isPublic' => false,
            ])
            ->call('save');

        $this->assertDatabaseHas('files', [
            'user_id' => $this->user1->id,
            'public' => 0,
            'disk' => $this->disk,
            'name' => $name,
            'mime' => $mime,
            'size' => $size * 1024,
        ]);

        $newFile = File::first();

        // Make it public
        Livewire::test(LivewireFile::class, ['file' => $newFile])
            ->call('toggleVisibility');

        $this->assertDatabaseHas('files', [
            'id' => $newFile->id,
            'user_id' => $this->user1->id,
            'public' => 1,
        ]);

        // Make it private again
        Livewire::test(LivewireFile::class, ['file' => $newFile])
            ->call('toggleVisibility');

        $this->assertDatabaseHas('files', [
            'id' => $newFile->id,
            'user_id' => $this->user1->id,
            'public' => 0,
        ]);
    }

    /**
     * Test plan
     */

    //
    // A user can only see their files
    // A file can be deleted

    // When a user is deleted, their **local** files are also deleted - does not apply to files stored in the cloud
    // Uploading a file of the same name as an existing file will overwrite it - does not apply to files stored in the cloud

}
