<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call(PrefecturesTableSeeder::class);
      $this->call(ProfessionTypesTableSeeder::class);
      $this->call(SkillTypesTableSeeder::class);
      $this->call(UsersTableSeeder::class);
      $this->call(CustomerProfessionTypesTableSeeder::class);
      $this->call(SelectablesTableSeeder::class);
      $this->call(WorksTableSeeder::class);
      $this->call(WorkSkillsTableSeeder::class);
      $this->call(NoteTemplatesTableSeeder::class);
      $this->call(FollowsTableSeeder::class);
      $this->call(RelationsTableSeeder::class);
    }
}
