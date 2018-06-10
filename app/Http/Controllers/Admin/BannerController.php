<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\BannerRepositoryEloquent;
use App\Repositories\Eloquent\ImageRepositoryEloquent;
use App\Services\ImageService;
use App\Validators\BannerValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class BannerController
 * @package App\Http\Controllers\Admin
 */
class BannerController extends BaseController
{
    /**
     * @var BannerRepositoryEloquent
     */
    protected $bannerRepositoryEloquent;

    /**
     * @var BannerValidator
     */
    protected $bannerValidator;

    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * @var ImageRepositoryEloquent
     */
    protected $imageRepositoryEloquent;

    /**
     * BannerController constructor.
     * @param BannerRepositoryEloquent $bannerRepositoryEloquent
     * @param BannerValidator $bannerValidator
     * @param ImageService $imageService
     * @param ImageRepositoryEloquent $imageRepositoryEloquent
     */
    public function __construct(
        BannerRepositoryEloquent $bannerRepositoryEloquent,
        BannerValidator $bannerValidator,
        ImageService $imageService,
        ImageRepositoryEloquent $imageRepositoryEloquent
    )
    {
        parent::__construct();

        $this->bannerRepositoryEloquent = $bannerRepositoryEloquent;
        $this->bannerValidator = $bannerValidator;
        $this->imageService = $imageService;
        $this->imageRepositoryEloquent = $imageRepositoryEloquent;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ? $request->get('limit') : null;

        $banners = $this->bannerRepositoryEloquent
            ->with(['image'])
            ->orderBy('sort', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return view('admin.banner.index', compact('banners'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['visible'] = $request->get('visible') == null ? 0 : $request->get('visible');
            $this->bannerValidator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $path = $this->imageService->upload('image', $request);

            if ($path != null) {
                $image = $this->imageRepositoryEloquent->create([
                    'path' => $path
                ]);
                $data['image_id'] = $image->id;
            }

            $this->bannerRepositoryEloquent->create($data);

            return redirect(route('admin_setting_banner.index'))->with('success', trans('common.create_success'));

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
        $banner = $this->bannerRepositoryEloquent->find($id);

        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $data['visible'] = $request->get('visible') == null ? 0 : $request->get('visible');
            $this->bannerValidator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $article = $this->bannerRepositoryEloquent->find($id);
            $path = $this->imageService->upload('image', $request);

            if ($path != null) {
                Storage::disk('public')->delete($article->image->path);
                $article->image()->update([
                    'path' => $path
                ]);
            }
            $this->bannerRepositoryEloquent->update($data, $id);

            return redirect(route('admin_setting_banner.index'))->with('success', trans('common.update_success'));
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
        $banner = $this->bannerRepositoryEloquent->find($id);
        $banner->delete($id);
        Storage::disk('public')->delete($banner->image->path);
        $banner->image()->delete();

        return redirect(route('admin_setting_banner.index'))->with('success', trans('common.delete_success'));
    }
}
