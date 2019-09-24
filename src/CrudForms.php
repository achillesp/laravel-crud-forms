<?php

namespace Achillesp\CrudForms;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

trait CrudForms
{
    /**
     * The model that we use.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The fields shown on the index page.
     *
     * @var array
     */
    protected $indexFields = [];

    /**
     * The fields shown in forms as an array of arrays.
     * Each field is an array with keys:
     * name, label, type, relationship (if applicable).
     * Type can be: text, textarea, email, url, password, date, select, select_multiple, checkbox, radio.
     *
     * @var array
     */
    protected $formFields = [];

    /**
     * The model's relationships that the crud forms may need to use.
     *
     * @var array
     */
    protected $relationships = [];

    /**
     * The form's title (model name or description).
     *
     * @var string
     */
    protected $formTitle;

    /**
     * The base of the resource route.
     *
     * @var string
     */
    protected $route;

    /**
     * The blade layout that we extend.
     *
     * @var string
     */
    protected $bladeLayout;

    /**
     * Whether we want to handle deleted resources.
     *
     * @var bool
     */
    protected $withTrashed = false;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [];

    /**
     * Validation messages.
     *
     * @var array
     */
    protected $validationMessages = [];

    /**
     * Validation attributes nice names.
     *
     * @var array
     */
    protected $validationAttributes = [];

    /**
     * The model relations types that are eager loaded, or load data for options.
     *
     * @var array
     */
    protected $relationTypesToLoad = [
        'Illuminate\Database\Eloquent\Relations\BelongsToMany',
        'Illuminate\Database\Eloquent\Relations\BelongsTo',
    ];
    // ---------------------------
    // Resource Controller Methods
    // ---------------------------

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->withTrashed) {
            $entities = $this->model->withTrashed()->get();
        } else {
            $entities = $this->model->all();
        }

        $this->loadModelRelationships($entities);

        $fields = $this->getIndexFields();
        $title = $this->getFormTitle();
        $route = $this->getRoute();
        $withTrashed = $this->withTrashed;
        $bladeLayout = $this->bladeLayout;

        return view('crud-forms::index',
            compact(
                'entities',
                'fields',
                'title',
                'route',
                'withTrashed',
                'bladeLayout'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $entity = $this->model;

        if (count($this->getRelationships())) {
            $relationshipOptions = $this->getModelRelationshipData();
        }

        $fields = $this->getFormFields();
        $title = $this->getFormTitle();
        $route = $this->getRoute();
        $bladeLayout = $this->bladeLayout;

        return view('crud-forms::create',
            compact(
                'entity',
                'fields',
                'title',
                'route',
                'bladeLayout',
                'relationshipOptions'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Validator::make($request->all(),
            $this->getValidationRules(),
            $this->getValidationMessages(),
            $this->getValidationAttributes()
        )->validate();

        $entity = $this->model->create($request->all());

        $this->syncModelRelationships($entity, $request);

        $request->session()->flash('status', 'Data saved successfully!');

        return redirect(route($this->getRoute().'.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entity = $this->model->findOrFail($id);

        $this->loadModelRelationships($entity);

        $fields = $this->getFormFields();
        $title = $this->getFormTitle();
        $route = $this->getRoute();
        $bladeLayout = $this->bladeLayout;

        return view('crud-forms::show',
            compact(
                'entity',
                'fields',
                'title',
                'route',
                'bladeLayout'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entity = $this->model->findOrFail($id);

        $this->loadModelRelationships($entity);

        if (count($this->getRelationships())) {
            $relationshipOptions = $this->getModelRelationshipData();
        }

        $fields = $this->getFormFields();
        $title = $this->getFormTitle();
        $route = $this->getRoute();
        $bladeLayout = $this->bladeLayout;

        return view('crud-forms::edit',
            compact(
                'entity',
                'fields',
                'title',
                'route',
                'bladeLayout',
                'relationshipOptions'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(),
            $this->getValidationRules(),
            $this->getValidationMessages(),
            $this->getValidationAttributes()
        )->validate();

        $entity = $this->model->findOrFail($id);

        // Handle checkboxes
        foreach ($this->getFormFields() as $field) {
            if ('checkbox' == $field['type']) {
                $request["{$field['name']}"] = ($request["{$field['name']}"]) ? true : false;
            }
        }

        $entity->update($request->all());

        $this->syncModelRelationships($entity, $request);

        $request->session()->flash('status', 'Data saved.');

        return redirect(route($this->getRoute().'.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entity = $this->model->findOrFail($id);

        $entity->delete();

        request()->session()->flash('status', 'Data deleted.');

        return redirect(route($this->getRoute().'.index'));
    }

    /**
     * Restore the specified softdeleted resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $this->model->withTrashed()->where('id', $id)->restore();

        request()->session()->flash('status', 'Data restored.');

        return redirect(Str::before(request()->path(), "/$id/restore"));
    }

    /**
     * Get the array of fields that we need to present in the forms.
     *
     * @return array
     */
    public function getFormFields()
    {
        // No fields declared. We have a table with only a name field.
        if (0 == count($this->formFields)) {
            array_push($this->formFields, ['name' => 'name', 'label' => 'Name', 'type' => 'text']);

            return $this->formFields;
        }

        foreach ($this->formFields as $key => $field) {
            if (Arr::has($field, 'relationship') && !Arr::has($field, 'relFieldName')) {
                // set default name of related table main field
                $this->formFields[$key]['relFieldName'] = 'name';
            }
        }

        return $this->formFields;
    }

    /**
     * Get an array of all the model's relationships needed in the crud forms.
     *
     * @return array
     */
    public function getRelationships()
    {
        foreach ($this->getFormFields() as $field) {
            if (
                Arr::has($field, 'relationship') &&
                !Arr::has($this->relationships, $field['relationship']) &&
                method_exists($this->model, $field['relationship'])
            ) {
                $this->relationships[] = $field['relationship'];
            }
        }

        return $this->relationships;
    }

    // --------------------------------
    // Getters & Setters
    // --------------------------------

    /**
     * Get an array of the defined validation rules.
     *
     * @return array
     */
    protected function getValidationRules()
    {
        return $this->validationRules ?: [];
    }

    /**
     * Get an array of the defined validation custom messages.
     *
     * @return array
     */
    protected function getValidationMessages()
    {
        return $this->validationMessages ?: [];
    }

    /**
     * Get an array of the defined validation attributes nice names.
     * These are used in the default Laravel validation messages.
     *
     * @return array
     */
    protected function getValidationAttributes()
    {
        $attributes = [];

        foreach ($this->getFormFields() as $field) {
            $attributes[$field['name']] = $field['label'];
        }

        return array_merge($attributes, $this->validationAttributes);
    }

    /**
     * Get the base route of the resource.
     *
     * @return string
     */
    protected function getRoute()
    {
        if ($this->route) {
            return $this->route;
        }

        // No route defined.
        // We find the full route from the request and get the base from there.
        $routeName = request()->route()->getName();

        return substr($routeName, 0, strrpos($routeName, '.'));
    }

    /**
     * Get the title of the resource to use in form headers.
     *
     * @return string
     */
    protected function getFormTitle()
    {
        if ($this->formTitle) {
            return $this->formTitle;
        }
        // No title defined. We return the model name.
        return Str::title(class_basename($this->model));
    }

    /**
     * Get the array of fields that we need to present in the resource index.
     *
     * @return array
     */
    protected function getIndexFields()
    {
        // If none declared, use the first of the formFields.
        if (0 == count($this->indexFields)) {
            $this->indexFields = [$this->formFields[0]['name']];

            return array_slice($this->getFormFields(), 0, 1);
        }

        return Arr::where($this->getFormFields(), function ($value) {
            return in_array($value['name'], $this->indexFields, true);
        });
    }

    /**
     * Get an array of collections of related data.
     *
     * @return array array of collections
     */
    protected function getModelRelationshipData()
    {
        $formFields = $this->getFormFields();

        $relationships = $this->getRelationships();

        foreach ($relationships as $relationship) {
            // We need to find the relationship's field
            $field = Arr::first(array_filter($formFields, function ($var) use ($relationship) {
                if (Arr::has($var, 'relationship') && ($relationship == $var['relationship'])) {
                    return $var;
                }
            }));

            if (in_array(get_class($this->model->$relationship()), $this->relationTypesToLoad, true)) {
                $relationshipData["$relationship"] = $this->model->$relationship()->getRelated()->all()->pluck($field['relFieldName'], 'id');
            }
        }

        return $relationshipData;
    }

    // --------------------------------
    // Helper methods
    // --------------------------------

    /**
     * Sync any BelongsToMany Relationships.
     *
     * @param Model   $model
     * @param Request $request
     */
    protected function syncModelRelationships(Model $model, Request $request)
    {
        $relationships = $this->getRelationships();

        foreach ($relationships as $relationship) {
            if ('Illuminate\Database\Eloquent\Relations\BelongsToMany' == get_class($model->$relationship())) {
                $model->$relationship()->sync($request->input($relationship, []));
            }
        }
    }

    /**
     * Eager load all the BelongsTo and BelongsToMany relationships.
     *
     * @param mixed $entities
     */
    protected function loadModelRelationships($entities)
    {
        $relationships = $this->getRelationships();

        foreach ($relationships as $relationship) {
            if (in_array(get_class($this->model->$relationship()), $this->relationTypesToLoad, true)) {
                $entities->load($relationship);
            }
        }
    }

    /**
     *  Check if a form field of a given name is defined.
     *
     * @param string $fieldName
     *
     * @return bool
     */
    protected function hasField($fieldName)
    {
        return in_array($fieldName, array_column($this->formFields, 'name'), true);
    }
}
