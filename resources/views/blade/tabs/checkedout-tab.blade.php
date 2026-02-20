@props([
    'count' => null,
    'model' => null,
    'class' => false,
])

@can('view', $model)
    <x-tabs.nav-item
            name="assigned"
            :$class
            icon_type="checkedout"
            label="{{ trans('general.checked_out') }}"
            count="{{ $count }}"
            tooltip="{{ trans('general.checked_out') }}"
    />
@endcan