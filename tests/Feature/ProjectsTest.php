<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    // WithFaker generates random data
    // RefreshDatabase runs the test and then resets back to initial state
    /** @test */
    public function a_user_can_create_a_project() {

        // Don't catch + handle exceptions gracefully, we wanna see it 
        $this->withoutExceptionHandling();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $this->post('/projects', $attributes )->assertRedirect('/projects');

        // $this->assertDatabaseHas('projects', $attributes);

        // $this->get('/projects')->assertSee($attributes['title']);
    }
    
    /** @test */
    public function a_project_requires_a_title() {
        // $attributes = factory('App\Models\Projects')->raw(['title' => '']);
        $attributes = \App\Models\Project::factory()->raw(['title' => '']);
        $this->post('/projects', [$attributes])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description() {
        $attributes = \App\Models\Project::factory()->raw(['description' => '']);
        $this->post('/projects', [$attributes])->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_user_can_view_a_project() {
        $this->withoutExceptionHandling();
        
        $project = \App\Models\Project::factory()->create();

        $this->get('/projects/' . $project->id)
            ->assertSee($project->title)
            ->assertSee($project->description);
    }
}
