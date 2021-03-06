<?php

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Career\Repositories\Interfaces\CareerInterface;
use Fast\RealEstate\Enums\ProjectStatusEnum;
use Fast\RealEstate\Enums\PropertyStatusEnum;
use Fast\RealEstate\Repositories\Interfaces\ProjectInterface;
use Fast\RealEstate\Repositories\Interfaces\PropertyInterface;
use Fast\Theme\Events\RenderingSiteMapEvent;

require_once __DIR__ . '/../vendor/autoload.php';

register_page_template([
    'default' => 'Default',
]);

register_sidebar([
    'id'          => 'footer_sidebar',
    'name'        => 'Footer sidebar',
    'description' => 'Footer sidebar for Flex Home theme',
]);

theme_option()
    ->setField([
        'id'         => 'copyright',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Copyright'),
        'attributes' => [
            'name'    => 'copyright',
            'value'   => '© 2020 Fast Technologies. All right reserved.',
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => __('Change copyright'),
                'data-counter' => 250,
            ],
        ],
        'helper'     => __('Copyright on footer of site'),
    ])
    ->setField([
        'id'         => 'primary_font',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'googleFonts',
        'label'      => __('Primary font'),
        'attributes' => [
            'name'  => 'primary_font',
            'value' => 'Nunito Sans',
        ],
    ])
    ->setField([
        'id'         => 'about-us',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'textarea',
        'label'      => 'About us',
        'attributes' => [
            'name'    => 'about-us',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'hotline',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => 'Hotline',
        'attributes' => [
            'name'    => 'hotline',
            'value'   => null,
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => 'Hotline',
                'data-counter' => 30,
            ],
        ],
    ])
    ->setField([
        'id'         => 'address',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => 'Address',
        'attributes' => [
            'name'    => 'address',
            'value'   => null,
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => 'Address',
                'data-counter' => 120,
            ],
        ],
    ])
    ->setField([
        'id'         => 'email',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'email',
        'label'      => 'Email',
        'attributes' => [
            'name'    => 'email',
            'value'   => null,
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => 'Email',
                'data-counter' => 120,
            ],
        ],
    ])
    ->setSection([
        'title'      => __('Social'),
        'desc'       => __('Social links'),
        'id'         => 'opt-text-subsection-social',
        'subsection' => true,
        'icon'       => 'fa fa-share-alt',
    ])
    ->setField([
        'id'         => 'facebook',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Facebook',
        'attributes' => [
            'name'    => 'facebook',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'twitter',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Twitter',
        'attributes' => [
            'name'    => 'twitter',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'youtube',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Youtube',
        'attributes' => [
            'name'    => 'youtube',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setSection([
        'title'      => 'Content',
        'desc'       => 'Theme options for content',
        'id'         => 'opt-text-subsection-homepage',
        'subsection' => true,
        'icon'       => 'fa fa-edit',
        'fields'     => [
            [
                'id'         => 'number_of_featured_projects',
                'type'       => 'number',
                'label'      => 'Number of featured projects on homepage',
                'attributes' => [
                    'name'    => 'number_of_featured_projects',
                    'value'   => 4,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'number_of_featured_cities',
                'type'       => 'number',
                'label'      => 'Number of featured cities on homepage',
                'attributes' => [
                    'name'    => 'number_of_featured_cities',
                    'value'   => 10,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'number_of_properties_for_sell',
                'type'       => 'number',
                'label'      => 'Number of properties for sell on homepage',
                'attributes' => [
                    'name'    => 'number_of_properties_for_sell',
                    'value'   => 8,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'number_of_properties_for_rent',
                'type'       => 'number',
                'label'      => 'Number of properties for rent on homepage',
                'attributes' => [
                    'name'    => 'number_of_properties_for_rent',
                    'value'   => 8,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'number_of_projects_per_page',
                'type'       => 'number',
                'label'      => 'Number of projects per page',
                'attributes' => [
                    'name'    => 'number_of_projects_per_page',
                    'value'   => 12,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'number_of_properties_per_page',
                'type'       => 'number',
                'label'      => 'Number of properties per page',
                'attributes' => [
                    'name'    => 'number_of_properties_per_page',
                    'value'   => 12,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'number_of_related_projects',
                'type'       => 'number',
                'label'      => 'Number of related projects',
                'attributes' => [
                    'name'    => 'number_of_related_projects',
                    'value'   => 8,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'number_of_related_properties',
                'type'       => 'number',
                'label'      => 'Number of related properties',
                'attributes' => [
                    'name'    => 'number_of_related_properties',
                    'value'   => 8,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'home_banner',
                'type'       => 'mediaImage',
                'label'      => __('Top banner homepage'),
                'attributes' => [
                    'name'  => 'home_banner',
                    'value' => null,
                ],
            ],
            [
                'id'         => 'home_project_description',
                'type'       => 'textarea',
                'label'      => 'The description for projects block',
                'attributes' => [
                    'name'    => 'home_project_description',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'properties_description',
                'type'       => 'textarea',
                'label'      => 'The description for properties block',
                'attributes' => [
                    'name'    => 'properties_description',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'home_description_for_properties_by_locations',
                'type'       => 'textarea',
                'label'      => 'The description for properties by locations block',
                'attributes' => [
                    'name'    => 'home_description_for_properties_by_locations',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'home_description_for_properties_for_sale',
                'type'       => 'textarea',
                'label'      => 'The description for properties for sale block',
                'attributes' => [
                    'name'    => 'home_description_for_properties_for_sale',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'home_description_for_properties_for_rent',
                'type'       => 'textarea',
                'label'      => 'The description for properties for rent block',
                'attributes' => [
                    'name'    => 'home_description_for_properties_for_rent',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'home_description_for_news',
                'type'       => 'textarea',
                'label'      => 'The description for news block',
                'attributes' => [
                    'name'    => 'home_description_for_news',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
        ],
    ]);

RvMedia::addSize('small', 410, 270);

Event::listen(RenderingSiteMapEvent::class, function () {

    $projects = app(ProjectInterface::class)->advancedGet([
        'condition' => [
            're_projects.status' => ProjectStatusEnum::SELLING,
        ],
        'with'      => ['slugable'],
    ]);

    SiteMapManager::add(route('public.projects'), '2019-12-09 00:00:00', '0.4', 'monthly');

    foreach ($projects as $project) {
        SiteMapManager::add($project->url, $project->updated_at, '0.8', 'daily');
    }

    $properties = app(PropertyInterface::class)->advancedGet([
        'condition' => [
            ['re_properties.status', 'IN', [PropertyStatusEnum::RENTING, PropertyStatusEnum::SELLING()]],
        ],
        'with'      => ['slugable'],
    ]);

    SiteMapManager::add(route('public.properties'), '2019-12-09 00:00:00', '0.4', 'monthly');

    foreach ($properties as $property) {
        SiteMapManager::add($property->url, $property->updated_at, '0.8', 'daily');
    }

    $careers = app(CareerInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);

    SiteMapManager::add(route('public.careers'), '2019-12-09 00:00:00', '0.4', 'monthly');

    foreach ($careers as $career) {
        SiteMapManager::add($career->url, $career->updated_at, '0.6', 'daily');
    }

});

