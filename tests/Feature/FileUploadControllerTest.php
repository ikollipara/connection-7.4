<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Symfony\Component\HttpFoundation\File\UploadedFile as FileUploadedFile;
use Tests\AuthedTestCase;

class FileUploadControllerTest extends AuthedTestCase
{
    /**
     * test that a file can be uploaded
     */
    public function test_a_file_can_be_uploaded()
    {
        Storage::fake();
        $file = UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf');
        $response = $this->post(route('upload.store'), [
            'file' => $file,
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => 1,
        ]);
        Storage::assertExists($response->json('file')['url']);
    }

    /**
     * test that an image can be uploaded
     */
    public function test_an_image_can_be_uploaded()
    {
        Storage::fake();
        $image = UploadedFile::fake()->image('avatar.jpg', 400, 400);
        $response = $this->post(route('upload.store'), [
            'image' => $image,
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => 1,
        ]);
        Storage::assertExists($response->json('file')['url']);
    }

    /**
     * test that a file can be deleted
     */
    public function test_a_file_can_be_deleted()
    {
        Storage::fake();
        $file = UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf');
        $response = $this->post(route('upload.store'), [
            'file' => $file,
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => 1,
        ]);
        $file = $response->json('file')['url'];
        Storage::assertExists($file);
        $response = $this->delete(route('upload.destroy'), [
            'path' => $file,
        ]);
        $response->assertStatus(200);
        Storage::assertMissing($file);
    }

    /**
     * test that an image can be deleted
     */
    public function test_an_image_can_be_deleted()
    {
        Storage::fake();
        $image = UploadedFile::fake()->image('avatar.jpg', 400, 400);
        $response = $this->post(route('upload.store'), [
            'image' => $image,
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'success' => 1,
        ]);
        $image = $response->json('file')['url'];
        Storage::assertExists($image);
        $response = $this->delete(route('upload.destroy'), [
            'path' => $image,
        ]);
        $response->assertStatus(200);
        Storage::assertMissing($image);
    }
}
