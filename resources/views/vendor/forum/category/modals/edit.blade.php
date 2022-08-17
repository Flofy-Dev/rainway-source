@component('forum::modal-form')
    @slot('key', 'edit-category')
    @slot('title', trans('forum::general.edit'))
    @slot('route', Forum::route('category.update', $category))
    @slot('method', 'PATCH')

    <div class="mb-3">
        <label for="title">{{ trans('forum::general.title') }}</label>
        <input type="text" name="title" value="{{ old('title') ?? $category->title }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="description">{{ trans('forum::general.description') }}</label>
        <input type="text" name="description" value="{{ old('description') ?? $category->description }}" class="form-control">
    </div>
    @if ($privateAncestor != null)
        <div class="alert alert-primary" role="alert">
            {!! trans('forum::categories.access_controlled_by_private_ancestor', ['category' => "<a href=\"{$privateAncestor->route}\">{$privateAncestor->title}</a>"]) !!}
        </div>
    @endif

    @include ('forum::category.partials.inputs.color')

    @slot('actions')
        <button type="submit" class="btn btn-primary pull-right">{{ trans('forum::general.save') }}</button>
    @endslot
@endcomponent