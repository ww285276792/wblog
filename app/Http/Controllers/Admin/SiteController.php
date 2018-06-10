<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Admin;

use App\Repositories\Eloquent\SiteRepositoryEloquent;
use App\Services\ImageService;
use App\Validators\SiteValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class SiteController
 * @package App\Http\Controllers\Admin
 */
class SiteController extends BaseController
{
    /**
     * @var SiteRepositoryEloquent
     */
    protected $siteRepositoryEloquent;

    /**
     * @var SiteValidator
     */
    protected $siteValidator;

    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * SiteController constructor.
     * @param SiteRepositoryEloquent $siteRepositoryEloquent
     * @param SiteValidator $siteValidator
     * @param ImageService $imageService
     */
    public function __construct(
        SiteRepositoryEloquent $siteRepositoryEloquent,
        SiteValidator $siteValidator,
        ImageService $imageService
    )
    {
        parent::__construct();

        $this->siteRepositoryEloquent = $siteRepositoryEloquent;
        $this->siteValidator = $siteValidator;
        $this->imageService = $imageService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $site = $this->siteRepositoryEloquent->first();

        return view('admin.site.edit', compact('site'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $data['is_comment'] = $request->get('is_comment') == null ? 0 : $request->get('is_comment');
            $data['is_message'] = $request->get('is_message') == null ? 0 : $request->get('is_message');

            $this->siteValidator->with($data)->passesOrFail();

            $site = $this->siteRepositoryEloquent->find($id);
            $path = $this->imageService->upload('image', $request);

            if ($path != null) {
                if ($site->image) {
                    Storage::disk('public')->delete($site->image->path);
                }
                $site->image()->update([
                    'path' => $path
                ]);
            }
            $this->siteRepositoryEloquent->update($data, $id);

            return redirect(route('admin_setting_site.edit'))->with('success', trans('common.update_success'));
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
}
