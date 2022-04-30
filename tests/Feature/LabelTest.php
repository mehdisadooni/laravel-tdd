<?php

namespace Tests\Feature;

use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->authUser();
    }

    public function test_user_can_create_new_label()
    {
        $label = Arr::except(Label::factory()->raw(), 'user_id');
        $this->postJson(route('labels.store'), $label)->assertCreated()->json();
        $this->assertDatabaseHas('labels', $label);
    }

    public function test_user_can_delete_label()
    {
        $label = $this->createLabel();
        $this->deleteJson(route('labels.destroy', ['label' => $label->id]))->assertNoContent();
        $this->assertDatabaseMissing('labels', ['label' => $label->id]);
    }


    public function test_user_can_update_label()
    {
        $label = $this->createLabel();
        $newLabelData = Label::factory()->raw();
        $this->patchJson(route('labels.update', ['label' => $label->id]), $newLabelData)->assertOk();
        $this->assertDatabaseHas('labels', ['title' => $newLabelData['title'], 'color' => $newLabelData['color']]);
    }

    public function test_fetch_all_labels_for_a_user()
    {
        $label = $this->createLabel(['user_id' => $this->user->id]);
        $this->createLabel();
        $response = $this->getJson(route('labels.index'))->assertOk()->json();
        $this->assertEquals($response[0]['title'], $label->title);
    }

}
