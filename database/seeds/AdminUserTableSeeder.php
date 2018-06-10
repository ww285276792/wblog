<?php

use Illuminate\Database\Seeder;

class AdminUserTableSeeder extends Seeder
{
    /**
     * @var \App\Repositories\Eloquent\AdminUserRepositoryEloquent
     */
    protected $adminUserRepositoryEloquent;

    /**
     * AdminUserTableSeeder constructor.
     * @param \App\Repositories\Eloquent\AdminUserRepositoryEloquent $adminUserRepositoryEloquent
     */
    public function __construct(
        \App\Repositories\Eloquent\AdminUserRepositoryEloquent $adminUserRepositoryEloquent
    )
    {
        $this->adminUserRepositoryEloquent = $adminUserRepositoryEloquent;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->adminUserRepositoryEloquent->create([
            'name' => 'superadministrator',
            'email' => 'admin@qq.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
