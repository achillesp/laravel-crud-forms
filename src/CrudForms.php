<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

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
    protected $indexFields = ['name']; // TODO: get default from config file.

    /**
     * The fields shown in forms as an array of arrays.
     * Each field is an array with keys:
     * name, label, type, relationship (if applicable).
     * Type can be: text, textarea, date, select, select_multiple, checkbox
     * TODO: add radio field (must add view).
     *
     * @var array
     */
    protected $formFields = [];

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
    protected $bladeLayout = 'layouts.app'; // TODO: get default from config file.

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

        if ($this->model->relationships) {
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
        $this->validate($request);

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

        if ($this->model->relationships) {
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
        $this->validate($request);

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

        return redirect(route($this->getRoute().'.index'));
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
        return title_case(class_basename($this->model));
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
            if (array_has($field, 'relationship') && !array_has($field, 'relFieldName')) {
                // set default name of related table main field
                $this->formFields[$key]['relFieldName'] = 'name';
            }
        }

        return $this->formFields;
    }

    /**
     * Get the array of fields that we need to present in the resource index.
     *
     * @return array
     */
    protected function getIndexFields()
    {
        // We only want the fields that are declared to use for index pages.
        // So we restrict the formFields to those declared in the indexFields
        $this->formFields = array_where($this->getFormFields(), function ($value) {
            return in_array($value['name'], $this->indexFields, true);
        });

        return $this->getFormFields();
    }

    /**
     * Get an array of collections of related data.
     *
     * @return array array of collections
     */
    protected function getModelRelationshipData()
    {
        $model = $this->model;

        $formFields = $this->getFormFields();

        $relationships = $model->relationships ?: [];

        foreach ($relationships as $relationship) {
            $methodClass = get_class($model->$relationship());

            // We only need to find the relationship's field name
            $field = array_first(array_filter($formFields, function ($var) use ($relationship) {
                if (array_has($var, 'relationship') && ($relationship == $var['relationship'])) {
                    return $var;
                }
            }));

            switch ($methodClass) {
                case 'Illuminate\Database\Eloquent\Relations\BelongsToMany':
                    $relationshipData["$relationship"] = $model->$relationship()->getRelated()->all()->pluck($field['relFieldName'], 'id');
                    break;
                case 'Illuminate\Database\Eloquent\Relations\BelongsTo':
                    $relationshipData["$relationship"] = $model->$relationship()->getRelated()->all()->pluck($field['relFieldName'], 'id');
                    break;
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
        $relationships = $model->relationships ?: [];

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
        $relationships = $this->model->relationships ?: [];

        foreach ($relationships as $relationship) {
            switch (get_class($this->model->$relationship())) {
                case 'Illuminate\Database\Eloquent\Relations\BelongsToMany':
                    $entities->load($relationship);
                    break;
                case 'Illuminate\Database\Eloquent\Relations\BelongsTo':
                    $entities->load($relationship);
                    break;
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

    /**
     * Validate the request.
     *
     * @param Request $request
     */
    protected function validate(Request $request)
    {
        $validator = Validator::make($request->all(),
            $this->getValidationRules(),
            $this->getValidationMessages(),
            $this->getValidationAttributes()
        )->validate();
    }
}
