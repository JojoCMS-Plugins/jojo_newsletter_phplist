<?php
/*

These arrays are used to define custom fields for the contact form.

DO NOT edit this file, as this file will change with futire versions.
Instead, copy the contents of this file into a new file called "fields.php"
(in the same directory). Make whatever changes you like to fields.php

This is a simple 2d array describing the form. Although the output is simple,
it is clean CSS, has reliable server side validation and basic Javascript
validation.

Fields should be defined as follows...

++$f;
$fields[$f]['field'] = 'FirstName';                     //The ID of the field - no spaces, keep it short but descriptive
$fields[$f]['display'] = 'First Name';                  //The display name - this will show on the form and in the resulting email
$fields[$f]['required'] = true;                         //true or false - is this a required field?
$fields[$f]['validation'] = '';                         //The type of validation to be used - options are 'email', 'url', 'text', 'integer' or leave blank for no validation.
$fields[$f]['type'] = 'text';                           //type of input - use 'text', 'textarea', or 'checkboxes' - more options to come
$fields[$f]['size'] = 40;                               //Used for 'text' type fields - the size of the input
$fields[$f]['value'] = '';                              //A default value if any
$fields[$f]['options'] = array('option 1','option 2');  //An array of options. Required for 'checkboxes' type
$fields[$f]['rows'] = '15';                             //number of rows - only needed for textareas
$fields[$f]['cols'] = '40';                             //number of columns - only needed for textareas
$fields[$f]['fieldset'] = 'Contact';                    //Name of fieldset this field belongs to - empty means no fieldset will be used
$fields[$f]['description'] = 'Foo bar';                 //A short description to be shown below the field, to explain the field to the user
*/

$from_name_fields = array('firstname',' ','lastname'); //this is an array of all fields to be used

$f=0;
$fields[$f]['field'] = 'replyemail';
$fields[$f]['display'] = 'Email';
$fields[$f]['required'] = true;
$fields[$f]['validation'] = 'email';
$fields[$f]['type'] = 'text';
$fields[$f]['size'] = 30;
$fields[$f]['value'] = '';
$fields[$f]['description'] = '';

++$f;
$fields[$f]['field'] = 'Comments';
$fields[$f]['display'] = 'Reasons for Leaving';
$fields[$f]['required'] = false;
$fields[$f]['validation'] = '';
$fields[$f]['type'] = 'textarea';
$fields[$f]['rows'] = '5';
$fields[$f]['cols'] = '40';
$fields[$f]['value'] = '';
$fields[$f]['description'] = '';

/*
++$f;
$fields[$f]['field'] = 'Phone';
$fields[$f]['display'] = 'Phone';
$fields[$f]['required'] = false;
$fields[$f]['validation'] = '';
$fields[$f]['type'] = 'text';
$fields[$f]['size'] = 20;
$fields[$f]['value'] = '';
$fields[$f]['description'] = '';
*/