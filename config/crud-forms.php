<?php


return [
    /*
     * The default base layout that the views extend.
     * Change this to your app's main layout or the layout you want to use for the forms.
     */
    'blade_layout' => 'crud-forms::layout',

    /*
     * The default section in the base blade layout, that the CRUD views will use.
     */
    'blade_section' => 'main-content',

    /*
     * The field that is shown by default in the index view (if not defined).
     * If you have a field named 'name' or 'title' in most of your models,
     * you can set it here instead of defining the index view display fields.
     */
    'default_index_field' => 'name',


    /*
     * Whether the action buttons (show, edit, delete) of the index view should use font awesome icons.
     * If true, you will have to load the font-awesome css in the base layout.
     * (eg https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css).
     */
    'button_icons' => true

];
