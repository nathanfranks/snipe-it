@props([
    'count' => null,
    'model' => null,
])

@can('view', $model)
    <x-tabs.nav-item
            name="assigned"
            icon_type="checkedout"
            label="{{ trans('general.checked_out') }}"
            count="{{ $count }}"
            tooltip="{{ trans('general.checked_out') }}"
    />
@endcan