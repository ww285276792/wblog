<?php

use Illuminate\Database\Seeder;

class SiteTableSeeder extends Seeder
{
    /**
     * @var \App\Repositories\Eloquent\SiteRepositoryEloquent
     */
    protected $siteRepositoryEloquent;

    /**
     * SiteTableSeeder constructor.
     * @param \App\Repositories\Eloquent\SiteRepositoryEloquent $siteRepositoryEloquent
     */
    public function __construct(
        \App\Repositories\Eloquent\SiteRepositoryEloquent $siteRepositoryEloquent
    )
    {
        $this->siteRepositoryEloquent = $siteRepositoryEloquent;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->siteRepositoryEloquent->create([
            'author' => '镜花水月',
            'author_description' => '我不想成为一个庸俗的人。十年百年后，当我们死去，质疑我们的人同样死去，后人看到的是裹足不前、原地打转的你，还是一直奔跑、走到远方的我？',
            'site_description' => '这是一个使用laravel做的简单的个人博客。使用laravel以及众多的三方开源库进行集成开发，用以技术交流和个人技术测试。',
            'is_comment' => 1,
        ]);
    }
}
