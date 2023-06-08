<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Http\Requests\NovaRequest;

class TestAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Boolean::make(__('Test Boolean'), 'boolean')->default(true),
            BooleanGroup::make(__('Test Boolean Group'), 'boolean_group')->options(['foo' => 'Foo'])->default(['foo' => false])
                ->dependsOn('boolean', function (BooleanGroup $field, NovaRequest $request, FormData $form) {
                    $bool = (bool) $form->get('boolean');
                    $field->setValue(['foo' => $bool]);
                }),
            Boolean::make(__('Test Dependent Boolean'), 'dependent_boolean')->default(false)
                ->dependsOn('boolean', function (Boolean $field, NovaRequest $request, FormData $form) {
                    $bool = (bool) $form->get('boolean');
                    $field->setValue($bool);
                }),
            ];
    }
}
