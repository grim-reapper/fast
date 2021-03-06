<?php

namespace Fast\Menu\Forms;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Base\Forms\FormAbstract;
use Fast\Menu\Http\Requests\MenuRequest;
use Fast\Menu\Models\Menu;
use Throwable;

class MenuForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $locations = [];

        if ($this->getModel()) {
            $locations = $this->getModel()->locations()->pluck('location')->all();
        }

        $this
            ->setupModel(new Menu)
            ->setFormOption('class', 'form-save-menu')
            ->withCustomFields()
            ->setValidatorClass(MenuRequest::class)
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->addMetaBoxes([
                'structure' => [
                    'wrap'    => false,
                    'content' => view('packages/menu::menu-structure', [
                        'menu'      => $this->getModel(),
                        'locations' => $locations,
                    ])->render(),
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
