<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('permission_seeder');

        foreach ($permissions as $key => $permission) {
            foreach ($permission['permissions'] as $perm) {
                DB::table('permissions')->insert([
                    'name' => $perm['name'],
                    'display_name' => $perm['display_name'],
                    'description' => $perm['description'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'type' => $key,
                ]);
            }
        }
    }
}
