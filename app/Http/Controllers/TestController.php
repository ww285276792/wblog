<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers;

use App\Criteria\ArticleCriteria;
use App\Jobs\SendReminderEmail;
use App\Repositories\Eloquent\AdminUserRepositoryEloquent;
use App\Repositories\Eloquent\ArticleRepositoryEloquent;
use App\Repositories\Eloquent\TagRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use App\User;
use Faker\Generator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mews\Captcha\Facades\Captcha;

/**
 * Class CaptchaController
 * @package App\Http\Controllers
 */
class TestController extends Controller
{
    protected $adminUserRepositoryEloquent;

    protected $userRepositoryEloquent;
    protected $articleRepositoryEloquent;
    protected $faker;
    protected $tagRepositoryEloquent;


    public function __construct(
        AdminUserRepositoryEloquent $adminUserRepositoryEloquent,
        UserRepositoryEloquent $userRepositoryEloquent,
        ArticleRepositoryEloquent $articleRepositoryEloquent,
        Generator $generator,
        TagRepositoryEloquent $tagRepositoryEloquent
    )
    {
        $this->adminUserRepositoryEloquent = $adminUserRepositoryEloquent;
        $this->userRepositoryEloquent = $userRepositoryEloquent;
        $this->articleRepositoryEloquent = $articleRepositoryEloquent;
        $this->faker = $generator;
        $this->tagRepositoryEloquent = $tagRepositoryEloquent;
    }

    function randomDate($begintime, $endtime = "")
    {
        $begin = strtotime($begintime);
        $end = $endtime == "" ? mktime() : strtotime($endtime);
        $timestamp = rand($begin, $end);
        return date("Y-m-d H:i:s", $timestamp);
    }

    public function index()
    {
//        $data = $this->tagRepositoryEloquent
//            ->all(['name']);

        $data= $this->tagRepositoryEloquent
            ->withCount(['articles as value'])
            ->all();

//        dd($a->toArray());
//        dd(array_flatten($data->toArray()));
//        dd($data->toArray());

//        $this->userRepositoryEloquent->create([
//            'meail'=>'ffffff',
//            'password'=>'ffffff',
//        ]);
//        dd(1);
//        $a = $this->userRepositoryEloquent
//            ->all();
//
//        $b = DB::table('users')
//            ->select('id', 'name', DB::raw('count(*) as total'))
//            ->groupBy(['name'])
//            ->orderBy('total', 'desc')
//            ->get();

//        $a = $this->userRepositoryEloquent->find(1021);
//dd($a);
//        $c = User::select([
//            DB::raw('count(*) as total'),
//            DB::raw("FROM_UNIXTIME(UNIX_TIMESTAMP(created_at),'%Y-%m-%d') as riqi")
//        ])
//            ->groupBy(DB::raw("FROM_UNIXTIME(UNIX_TIMESTAMP(created_at),'%Y-%m-%d')"))
////            ->whereBetween('created_at', ['2018-05-30 00:00:00', '2018-06-07 23:59:59'])
//            ->orderBy("riqi", "asc")
//            ->get()->toArray();
//
//        $d = User::
//            where('id',7)
////            whereBetween('created_at', ['2018-06-01 00:00:00', '2018-06-02 23:59:59'])
//            ->get()->toArray();
//
//        dd($d);
//
//        $total = json_encode(array_pluck($c, 'total'));
//        $date = json_encode(array_pluck($c, 'riqi'));
////dd($date);
        return view('test', compact('data', 'date'));

//        for ($i = 1; $i <= 500; $i++) {
//            $date = $this->randomDate('2018-01-01 01:00:00', '2018-07-01 01:00:00');
//            $this->userRepositoryEloquent->makeModel()->insert(
//                [
//                    'name' => $this->faker->name,
//                    'email' => $this->faker->unique()->safeEmail,
//                    'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
//                    'remember_token' => str_random(10),
//                    'created_at' => $date,
//                    'updated_at' => $date
//                ]
//            );
//        }

        dd(1);
        $article = $this->articleRepositoryEloquent
            ->withCount('comments')
            ->orderBy('comments_count', 'asc')
            ->all();

        dd($article->toArray());

        $rules = ['name' => 'nullable|email'];

        $input = ['name' => 123];

        $a = Validator::make($input, $rules)->passes();
        dd($a);

        $a = $this->userRepositoryEloquent
            ->scopeQuery(function ($query) {
                $a = "./head.jpeg";
                /**
                 * @var Builder $query
                 */
                return $query->select('id', 'name',
                    DB::raw("CASE WHEN avatar is null THEN '" . $a . "' ELSE avatar END as avatar"));
            })->all();

        $b = $this->articleRepositoryEloquent
            ->pushCriteria(new ArticleCriteria(null, 'nginx'))
            ->with(['image', 'tags'])
            ->all();


        dd($b->toArray());
    }
}
