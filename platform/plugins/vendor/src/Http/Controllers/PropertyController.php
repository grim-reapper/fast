<?php

namespace Fast\Vendor\Http\Controllers;

use Assets;
use Auth;
use Fast\Base\Events\BeforeEditContentEvent;
use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\UpdatedContentEvent;
use Fast\Base\Forms\FormBuilder;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\RealEstate\Models\Property;
use Fast\RealEstate\Repositories\Interfaces\PropertyInterface;
use Fast\Vendor\Forms\PropertyForm;
use Fast\Vendor\Http\Requests\PropertyRequest;
use Fast\Vendor\Models\Vendor;
use Fast\Vendor\Repositories\Interfaces\VendorActivityLogInterface;
use Fast\Vendor\Repositories\Interfaces\VendorInterface;
use Fast\Vendor\Tables\PropertyTable;
use Exception;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SeoHelper;

class PropertyController extends Controller
{
    /**
     * @var VendorInterface
     */
    protected $vendorRepository;

    /**
     * @var PropertyInterface
     */
    protected $propertyRepository;

    /**
     * @var VendorActivityLogInterface
     */
    protected $activityLogRepository;

    /**
     * PublicController constructor.
     * @param Repository $config
     * @param VendorInterface $vendorRepository
     * @param PropertyInterface $propertyRepository
     * @param VendorActivityLogInterface $vendorActivityLogRepository
     */
    public function __construct(
        Repository $config,
        VendorInterface $vendorRepository,
        PropertyInterface $propertyRepository,
        VendorActivityLogInterface $vendorActivityLogRepository
    ) {
        $this->vendorRepository = $vendorRepository;
        $this->propertyRepository = $propertyRepository;
        $this->activityLogRepository = $vendorActivityLogRepository;

        Assets::setConfig($config->get('plugins.vendor.assets'));
    }

    /**
     * @param Request $request
     * @param PropertyTable $propertyTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Response
     * @throws \Throwable
     */
    public function index(PropertyTable $propertyTable)
    {
        SeoHelper::setTitle(__('Properties'));

        return $propertyTable->render('plugins/vendor::table.base');
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     * @throws \Throwable
     */
    public function create(FormBuilder $formBuilder)
    {
        if (!Auth::guard('vendor')->user()->canPost()) {
            abort(403);
        }

        SeoHelper::setTitle(__('Write a property'));

        return $formBuilder->create(PropertyForm::class)->renderForm();
    }

    /**
     * @param PropertyRequest $request
     * @param BaseHttpResponse $response
     * @param VendorInterface $vendorRepository
     * @return BaseHttpResponse
     */
    public function store(PropertyRequest $request, BaseHttpResponse $response, VendorInterface $vendorRepository)
    {
        if (!Auth::guard('vendor')->user()->canPost()) {
            abort(403);
        }

        /**
         * @var Property $property
         */
        $property = $this->propertyRepository->createOrUpdate(array_merge($request->input(), [
            'author_id'   => auth()->guard('vendor')->user()->getKey(),
            'author_type' => Vendor::class,
        ]));

        if ($property) {
            $property->features()->sync($request->input('features', []));
        }

        event(new CreatedContentEvent(PROPERTY_MODULE_SCREEN_NAME, $request, $property));

        $this->activityLogRepository->createOrUpdate([
            'action'         => 'create_property',
            'reference_name' => $property->name,
            'reference_url'  => route('public.vendor.properties.edit', $property->id),
        ]);

        $vendor = $vendorRepository->findOrFail(auth()->guard('vendor')->user()->getKey());
        $vendor->package_available_quota--;
        $vendor->save();

        return $response
            ->setPreviousUrl(route('public.vendor.properties.index'))
            ->setNextUrl(route('public.vendor.properties.edit', $property->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     *
     * @throws \Throwable
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $property = $this->propertyRepository->getFirstBy([
            'id'          => $id,
            'author_id'   => auth()->guard('vendor')->user()->getKey(),
            'author_type' => Vendor::class,
        ]);

        if (!$property) {
            abort(404);
        }

        event(new BeforeEditContentEvent($request, $property));

        SeoHelper::setTitle(trans('plugins/real-estate::property.edit') . ' "' . $property->name . '"');

        return $formBuilder
            ->create(PropertyForm::class, ['model' => $property])
            ->renderForm();
    }

    /**
     * @param int $id
     * @param PropertyRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update($id, PropertyRequest $request, BaseHttpResponse $response)
    {
        $property = $this->propertyRepository->getFirstBy([
            'id'          => $id,
            'author_id'   => auth()->guard('vendor')->user()->getKey(),
            'author_type' => Vendor::class,
        ]);

        if (!$property) {
            abort(404);
        }

        $property->fill($request->input());

        $this->propertyRepository->createOrUpdate($property);

        $property->features()->sync($request->input('features', []));

        event(new UpdatedContentEvent(PROPERTY_MODULE_SCREEN_NAME, $request, $property));

        $this->activityLogRepository->createOrUpdate([
            'action'         => 'update_property',
            'reference_name' => $property->name,
            'reference_url'  => route('public.vendor.properties.edit', $property->id),
        ]);

        return $response
            ->setPreviousUrl(route('public.vendor.properties.index'))
            ->setNextUrl(route('public.vendor.properties.edit', $property->id))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function destroy($id, BaseHttpResponse $response)
    {
        $property = $this->propertyRepository->getFirstBy([
            'id'          => $id,
            'author_id'   => auth()->guard('vendor')->user()->getKey(),
            'author_type' => Vendor::class,
        ]);

        if (!$property) {
            abort(404);
        }

        $this->propertyRepository->delete($property);

        $this->activityLogRepository->createOrUpdate([
            'action'         => 'delete_property',
            'reference_name' => $property->name,
        ]);

        return $response->setMessage(__('Delete property successfully!'));
    }
}
