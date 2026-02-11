@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ $model->name }}
    {{ ($model->model_number) ? '(#'.$model->model_number.')' : '' }}
@parent
@stop

@section('header_right')
    <i class="fa-regular fa-2x fa-square-caret-right pull-right" id="expand-info-panel-button" data-tooltip="true" title="{{ trans('button.show_hide_info') }}"></i>
@endsection

{{-- Page content --}}
@section('content')
    <x-container columns="2">

        @if ($model->deleted_at!='')
            <div class="col-md-12">
                <div class="callout callout-warning">
                    <x-icon type="warning" />
                    {{ trans('admin/models/general.deleted') }}
                </div>
            </div>
        @endif

        <x-page-column class="col-md-9 main-panel">
            <x-tabs>
                <x-slot:tabnav>
                    <x-tabs.asset-tab count="{{ $model->assets()->AssetsForShow()->count() }}" />
                    <x-tabs.files-tab name="files" count="{{ $model->uploads()->count() }}" />

                    @can('update', $model)
                        <x-tabs.nav-item-upload />
                    @endcan
                </x-slot:tabnav>


                <x-slot:tabpanes>
                    <x-tabs.pane name="assets" class="in active">
                        <x-table.assets :route="route('api.assets.index', ['model_id' => $model->id])" />
                    </x-tabs.pane>

                    <x-tabs.pane name="files">
                        <x-filestable :object="$model" object_type="models" />
                    </x-tabs.pane>
                </x-slot:tabpanes>
            </x-tabs>

        </x-page-column>
        <x-page-column class="col-md-3">
            <x-box>
                <x-box.info-panel :infoPanelObj="$model" img_path="{{ app('models_upload_url') }}">
                    <x-slot:before_list>

                        @can('update', \App\Models\AssetModel::class)
                                <a href="{{ ($model->deleted_at=='') ? route('models.edit', $model->id) : '#' }}" class="btn btn-block btn-sm btn-warning btn-social hidden-print{{ ($model->deleted_at!='') ? ' disabled' : '' }}">
                                    <x-icon type="edit" />
                                    {{ trans('admin/models/table.edit') }}
                                </a>

                        @endcan

                        @can('create', \App\Models\AssetModel::class)
                                <a href="{{ route('models.clone.create', $model->id) }}" class="btn btn-block btn-sm btn-warning btn-social hidden-print">
                                    <x-icon type="clone" />
                                    {{ trans('admin/models/table.clone') }}
                                </a>
                        @endcan

                        @can('delete', \App\Models\AssetModel::class)

                                @if ($model->deleted_at!='')
                                    <form method="POST" action="{{ route('models.restore.store', $model->id) }}" style="padding-top: 5px">
                                        @csrf
                                        <button style="width: 100%;" class="btn btn-block btn-sm btn-warning btn-social hidden-print">
                                            <x-icon type="restore" />
                                            {{ trans('button.restore') }}
                                        </button>
                                    </form>

                                @elseif ($model->assets()->count() > 0)
                                    <button class="btn btn-block btn-sm btn-danger btn-social hidden-print disabled" data-tooltip="true"  data-placement="top" data-title="{{ trans('general.cannot_be_deleted') }}">
                                        <x-icon type="delete" />
                                        {{ trans('general.delete') }}
                                    </button>
                                @else
                                    <button class="btn btn-block btn-sm btn-danger btn-social delete-asset" data-toggle="modal" title="{{ trans('general.delete_what', ['item'=> trans('general.asset_model')]) }}" data-content="{{ trans('general.sure_to_delete_var', ['item' => $model->name]) }}" data-target="#dataConfirmModal" data-tooltip="true" data-icon="fa fa-trash" data-placement="top" data-title="{{ trans('general.delete_what', ['item'=> trans('general.asset_model')]) }}" onClick="return false;">
                                        <x-icon type="delete" />
                                        {{ trans('general.delete') }}
                                    </button>
                        @endif
                        @endcan

                    </x-slot:before_list>

                </x-box.info-panel>
            </x-box>
        </x-page-column>
    </x-container>



@can('update', \App\Models\AssetModel::class)
    @include ('modals.upload-file', ['item_type' => 'models', 'item_id' => $model->id])
@endcan
@stop

@section('moar_scripts')

    @include ('partials.bootstrap-table', ['exportFile' => 'manufacturer' . $model->name . '-export', 'search' => false])

@stop
