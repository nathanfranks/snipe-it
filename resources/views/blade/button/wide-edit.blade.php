@props([
    'item' => null,
    'route' => null,
])

<a href="{{ ($item->deleted_at == '') ? $route: '#' }}" class="btn btn-block btn-sm btn-warning btn-social hidden-print{{ ($item->deleted_at!='') ? ' disabled' : '' }}">
    <x-icon type="edit" />
    {{ trans('general.update') }}
</a>