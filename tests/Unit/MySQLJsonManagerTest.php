<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MySQLJSONManagerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_add_an_item_to_the_json_column()
    {
        $user = factory('App\User')->create();

        $user->options()->add('key1', '123456');

        $this->assertDatabaseHas('users', ['options' => '{"key1":"123456"}']);
    }

    /** @test */
    public function the_add_method_can_work_with_array()
    {
        $user = factory('App\User')->create();

        $user->options()->add(['key1' => '123456', 'key2' => '654321']);

        $this->assertDatabaseHas('users', ['options' => '{"key1":"123456","key2":"654321"}']);
    }

    /** @test */
    public function can_update_an_item_in_the_json_column()
    {
        $user = factory('App\User')->create();

        $user->options()->add(['key1' => '123456', 'key2' => '654321']);
        $user->options()->update('key1', 'updated');

        $this->assertDatabaseHas('users', ['options' => '{"key1":"updated","key2":"654321"}']);
    }

    /** @test */
    public function the_update_method_can_work_with_array()
    {
        $user = factory('App\User')->create();

        $user->options()->add(['key1' => '123456', 'key2' => '654321']);
        $user->options()->update(['key1' => 'updated', 'key2' => 'updated']);

        $this->assertDatabaseHas('users', ['options' => '{"key1":"updated","key2":"updated"}']);
    }

    /** @test */
    public function can_delete_an_item_in_the_json_column()
    {
        $user = factory('App\User')->create();

        $user->options()->add(['key1' => '123456', 'key2' => '654321']);
        $user->options()->delete('key1');

        $this->assertDatabaseHas('users', ['options' => '{"key2":"654321"}']);
    }

    /** @test */
    public function the_delete_method_can_work_with_array()
    {
        $user = factory('App\User')->create();

        $user->options()->add(['key1' => '123456', 'key2' => '654321']);
        $user->options()->delete(['key1', 'key2']);

        $this->assertDatabaseHas('users', ['options' => '[]']);
    }

    /** @test */
    public function can_get_specific_value_by_key()
    {
        $user = factory('App\User')->create();
        $key1 = '123456';

        $user->options()->add(['key1' => $key1, 'key2' => '654321']);        

        $this->assertEquals($key1, $user->options()->get('key1'));
    }

    /** @test */
    public function can_use_dynamic_property()
    {
        $user = factory('App\User')->create();
        $key1 = '123456';

        $user->options()->add(['key1' => $key1, 'key2' => '654321']);        

        $this->assertEquals($key1, $user->options()->key1);
    }

    /** @test */
    public function can_get_all_data_using_all_method()
    {
        $user = factory('App\User')->create();
        $options = ['key1' => '123456', 'key2' => '654321'];

        $user->options()->add($options);        

        $this->assertEquals($options, $user->options()->all());
    }
}
