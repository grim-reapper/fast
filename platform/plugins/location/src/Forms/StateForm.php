<?php

namespace Fast\Location\Forms;

use Fast\Base\Forms\FormAbstract;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\Location\Repositories\Interfaces\CountryInterface;
use Fast\Location\Http\Requests\StateRequest;
use Fast\Location\Models\State;
use Throwable;

class StateForm extends FormAbstract
{

    /**
     * @var CountryInterface
     */
    protected $countryRepository;

    /**
     * StateForm constructor.
     * @param CountryInterface $countryRepository
     */
    public function __construct(CountryInterface $countryRepository)
    {
        parent::__construct();

        $this->countryRepository = $countryRepository;
    }

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {

        $countries = $this->countryRepository->pluck('countries.name', 'countries.id');

        $this
            ->setupModel(new State)
            ->setValidatorClass(StateRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('country_id', 'customSelect', [
                'label'      => trans('plugins/location::state.country'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-search-full',
                ],
                'choices'    => [0 => trans('plugins/location::state.select_country')] + $countries,
            ])
            ->add('order', 'number', [
                'label'         => trans('core/base::forms.order'),
                'label_attr'    => ['class' => 'control-label'],
                'attr'          => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('is_default', 'onOff', [
                'label'         => trans('core/base::forms.is_default'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
