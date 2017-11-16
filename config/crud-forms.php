<?php


return [
    /*
     * The default base layout that the views extend.
     */
    'blade_layout' => 'crud-forms::layout',

    /*
     * The default section in the base blade layout, that the CRUD views will use.
     */
    'blade_section' => 'main-content',

    /*
     * The field that is shown by default in the index view.
     */
    'default_index_field' => 'name',


    /*
     * Whether the action buttons (show, edit, delete) of the index view should use font awesome icons.
     * If true, you will have to load the font-awesome css in the base layout.
     * (eg https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css).
     */
    'button_icons' => true

];
