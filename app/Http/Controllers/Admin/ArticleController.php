<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Admin;

use App\Criteria\AdminArticleCriteria;
use App\Repositories\Eloquent\ArticleRepositoryEloquent;
use App\Repositories\Eloquent\ImageRepositoryEloquent;
use App\Repositories\Eloquent\TagRepositoryEloquent;
use App\Services\ImageService;
use App\Validators\ArticleValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ArticleController
 * @package App\Http\Controllers\Admin
 */
class ArticleController extends BaseController
{
    /**
     * @var TagRepositoryEloquent
     */
    protected $articleRepositoryEloquent;

    /**
     * @var ArticleValidator
     */
    protected $articleValidator;

    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * @var ImageRepositoryEloquent
     */
    protected $imageRepositoryEloquent;

    /**
     * @var TagRepositoryEloquent
     */
    protected $tagRepositoryEloquent;

    /**
     * ArticleController constructor.
     * @param ArticleRepositoryEloquent $articleRepositoryEloquent
     * @param ArticleValidator $articleValidator
     * @param ImageService $imageService
     * @param ImageRepositoryEloquent $imageRepositoryEloquent
     * @param TagRepositoryEloquent $tagRepositoryEloquent
     */
    public function __construct(
        ArticleRepositoryEloquent $articleRepositoryEloquent,
        ArticleValidator $articleValidator,
        ImageService $imageService,
        ImageRepositoryEloquent $imageRepositoryEloquent,
        TagRepositoryEloquent $tagRepositoryEloquent
    )
    {
        parent::__construct();

        $this->articleRepositoryEloquent = $articleRepositoryEloquent;
        $this->articleValidator = $articleValidator;
        $this->imageService = $imageService;
        $this->imageRepositoryEloquent = $imageRepositoryEloquent;
        $this->tagRepositoryEloquent = $tagRepositoryEloquent;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ? $request->get('limit') : null;

        $tags = $this->tagRepositoryEloquent->all();
        $articles = $this->articleRepositoryEloquent
            ->pushCriteria(new AdminArticleCriteria(
                $request->get('title'),
                $request->get('description'),
                $request->input('created_at_from'),
                $request->input('created_at_to'),
                $request->input('tags')
            ))
            ->with(['tags'])
            ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return view('admin.article.index', compact('articles', 'tags'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $tags = $this->tagRepositoryEloquent->all();

        return view('admin.article.create', compact('tags'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $this->articleValidator->with($request->all())->passesOrFail();
            $path = $this->imageService->upload('image', $request);

            if ($path != null) {
                $image = $this->imageRepositoryEloquent->create([
                    'path' => $path
                ]);
                $data['image_id'] = $image->id;
            }

            $article = $this->articleRepositoryEloquent->create($data);

            if (is_array($request->input('tag'))) {
                foreach ($request->input('tag') as $tag) {
                    $article->tags()->attach($tag);
                }
            }

            return redirect(route('admin_article.index'))->with('success', trans('common.create_success'));
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $article = $this->articleRepositoryEloquent->find($id);
        $tags = $this->tagRepositoryEloquent->all();
        $tgs = array_column($article->tags->toArray(), 'id');

        return view('admin.article.edit', compact('article', 'tags', 'tgs'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->articleValidator->with($request->all())->passesOrFail();
            $article = $this->articleRepositoryEloquent->find($id);
            $path = $this->imageService->upload('image', $request);
            $data = $request->all();

            if ($path != null) {
                if ($article->image != null) {
                    Storage::disk('public')->delete($article->image->path);
                    $article->image()->update([
                        'path' => $path
                    ]);
                } else {
                    $image = $this->imageRepositoryEloquent->create([
                        'path' => $path
                    ]);
                    $data['image_id'] = $image->id;
                }
            }

            $article->tags()->sync($request->get('tag'));
            $this->articleRepositoryEloquent->update($data, $id);

            return redirect(route('admin_article.index'))->with('success', trans('common.update_success'));
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $article = $this->articleRepositoryEloquent->find($id);
        $article->delete($id);
        if ($article->image) {
            Storage::disk('public')->delete($article->image->path);
            $article->image()->delete();
        }

        return redirect(route('admin_article.index'))->with('success', trans('common.delete_success'));
    }
}
