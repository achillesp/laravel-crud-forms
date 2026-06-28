<?php


return [
    /*
     * The view theme used to render the CRUD forms and index page.
     * Supported values: "bootstrap" (Bootstrap 3, the default) and "tailwind"
     * (Tailwind CSS). This selects which bundled view set is used, with no need
     * to publish anything. If you publish a view set (see the readme), the
     * published views always take precedence over this setting.
     */
    'theme' => 'bootstrap',

    /*
     * The default base layout that the views extend.
     * Change this to your app's main layout or the layout you want to use for the forms.
     */
    'blade_layout' => 'crud-forms::layout',

    /*
     * The default section in the base blade layout, that the CRUD views will use.
     */
    'blade_section' => 'content',

    /*
     * Whether the action buttons (show, edit, delete) of the index view should use icons.
     * The "tailwind" theme renders inline SVG icons (no extra dependency).
     * The "bootstrap" theme uses Font Awesome, so you must load the font-awesome css
     * in your layout (eg https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css).
     */
    'button_icons' => true

];
