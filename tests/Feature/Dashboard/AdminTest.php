<?php

namespace Tests\Feature\Dashboard;

use Elnooronline\LaravelBootstrapForms\Facades\BsForm;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Admin;

class AdminTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_display_the_list_of_admins()
    {
        $this->be($admin = create(Admin::class));

        $response = $this->get(route('dashboard.admins.index'));

        $response->assertSuccessful();

        $response->assertViewIs('dashboard.admins.index');
        $response->assertSee($admin->present()->thumbAvatar);
        $response->assertSee($admin->name);
        $response->assertSee($admin->email);
        $response->assertSee($admin->present()->controlButton);
    }

    /**
     * @test
     */
    public function it_can_display_the_create_form_of_admins()
    {
        $this->be(create(Admin::class));

        $response = $this->get(route('dashboard.admins.create'));

        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function it_can_store_newly_created_admin()
    {
        $this->be(create(Admin::class));
        $data = [
            'name' => 'Ahmed Fathy',
            'email' => 'test@gmail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $response = $this->post(route('dashboard.admins.store'), $data);

        $response->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('users', ['type' => Admin::ADMIN_TYPE, 'name' => $data['name']]);
    }

    /**
     * @test
     */
    public function it_can_display_the_edit_form_of_admins()
    {
        $this->be($admin = create(Admin::class));

        $response = $this->get(route('dashboard.admins.edit', $admin));

        $response->assertSuccessful();

        $response->assertSee(BsForm::text('name')->value($admin->name)->toHtml());
    }

    /**
     * @test
     */
    public function it_can_update_the_admin()
    {
        $this->be($admin = create(Admin::class));
        $data = [
            'name' => 'Ahmed Fathy',
            'email' => 'test@gmail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $response = $this->put(route('dashboard.admins.update', $admin), $data);

        $response->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('users', ['type' => Admin::ADMIN_TYPE, 'name' => $data['name']]);
    }

    /**
     * @test
     */
    public function it_can_delete_the_admin()
    {
        $this->be(create(Admin::class));

        $admin = create(Admin::class);

        $response = $this->delete(route('dashboard.admins.destroy', $admin));

        $response->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseMissing('users', ['id' => $admin->id]);
    }
}
