# Sample WordPress Plugin

This plugin was written by [Alex Delgado](https://github.com/alexdelgado) as an easy way to teach some fundamental WordPress concepts.


## [WordPress Metaboxes](https://developer.wordpress.org/plugins/metadata/custom-meta-boxes/)

Meta boxes are handy, flexible, modular edit screen elements that can be used to collect information related to the post being edited. 

There are several ways to create custom metaboxes, but I will highlight the three most common:
1. [WordPress API](#wordpress-api)
2. [Custom Metaboxes Plugin](#cmb2-plugin)
3. [Advanced Custom Fields](#advanced-custom-fields)

### WordPress API

WordPress exposes the ability to create your own metaboxes via the [`add_meta_box`](https://developer.wordpress.org/reference/functions/add_meta_box/) method. As you can see from the documentation, there are several parameters required by the `add_meta_box` method, of them however, the most important is the `$callback` parameter. Per the documentation the `$callback` is a method that fills the box with the desired content [and] should echo its output.". For the purposes of this plugin, our `$callback` method is called `generate_sample_meta_box`.

Our `generate_sample_meta_box` does a few things:
1. Checks to see if we already have any saved metadata, and if so prepares that data for display in our form fields.
2. Creates a [wordpress nonce](https://developer.wordpress.org/reference/functions/wp_nonce_field/) to "validate that the contents of [our metabox] form came from" inside our WordPress Admin.
3. Renders our metabox form on the desired WordPress `post_type` editor screen.

You'll notice that our `generate_sample_meta_box` method does not save our metadata, that is because WordPress decouples the save logic from the display logic. Therefore, to save our metabox form, we have to hook into the [`save_post`](https://developer.wordpress.org/reference/hooks/save_post/) action.  For the purposes of this plugin, when WordPress calls the `save_post` action, our `save_post_meta` method gets called.

Inside our `save_post_meta` method we run a few checks to verify that it the right time to save our metabox form. These checks include:
1. Checking that WordPress isn't performing an AJAX request (because we don't save our metabox forms via AJAX requests).
2. Validate the nonce we created in our `generate_sample_meta_box` method
3. Make sure the current user has permission to edit the given post
4. Then finally, save our metabox fields to the database (via `_save_article_meta_box`)

### [CMB2 Plugin](https://cmb2.io/)

Using the WordPress API is great for understanding how WordPress works, but we might not always want to go so deep into the codebase or have to write so much boilerplate. Fortunately there are plugins like CMB2 that can help us! CMB2 allows us to quickly create custom WordPress Metaboxes with lots of additonal functionality.

CMB2 handles the display and save logic for us so all we have to do is register a metabox using the [`new_cmb2_box`](https://cmb2.io/docs/display-options) method as shown in our `CMB2->register_meta_boxes` method, then add our desired fields using the `add_field` method as demonstrated in our `CMB2->register_meta_boxes` method.

### [Advanced Custom Fields](https://www.advancedcustomfields.com/)

Plugins like CMB2 are great time savers, but they still require some coding. Wouldn't it be great if we could just configure everything in a UI without having to write code? Advanced Custom Fields (also known as ACF), let's us do just that! Once you install the plugin you'll have access to a UI with options for creating highly customizeable custom fields and metaboxes.

### What Works Best

These are just three of the most popular options out there - if you do some quick research online you're likely to find even more impressive options. However for the purposes of this tutorial, we'll stick to these three options.

1. **WordPress API** The WordPress API is great if you have the time and energy to code everything from scratch. It's very handy to know how it all works together, but most developers won't need that level of control.

2. **CMB2** CMB2 simplifies the WordPress API and allows you to work quickly. It also gives you access to several add-ons such as repeatable fields, different field types, and you can use it for more than just metaboxes. CMB2 is also highly customizeable so it's unlikely you'll run into a situation it can't handle.

3. **Advanced Custom Fields** ACF requires no code on the backend, is highly customizeble, and has free and paid add-ons to help you solve even the most difficult of problems. It's quick, easy, and well-maintained.


## [WordPress Nav Walker](https://developer.wordpress.org/reference/classes/walker_nav_menu/)

The WordPress Nav Walker class builds WordPress navigation menus. There are two methods in particular we should be familiar with: `start_el` and `start_lvl`. 

* The `start_el` method generates each individual menu item (`li` and `a` tags) at every level of the navigation menu. There are several hooks in the `start_el` method to modify it's output so it is unlikely you'll need to overwrite this method.

* The `start_lvl` method generates the `ul` tag for every child menu. 
**Note:** This method is not called unless there are sub-menus present.


## [Internationalization](https://developer.wordpress.org/apis/handbook/internationalization/internationalization-functions/)

The process of localizing software has two steps. The first step is to create a way for the application to be translated to suit local preferences and languages. The second step is the actual localization (l10n) of the application to suit the local preferences and language.

### Basic functions

| Function | Description |
| -------- | ----------- |
| __( string $text, string $domain = 'default' ) | Returns the translation or the original text.
| _e( string $text, string $domain = 'default' ) | Echos the translation or the original text.
| _x( string $text, string $context, string $domain = 'default' ) | Returns the translation or the original text (with context).
| _ex( string $text, string $context, string $domain = 'default' ) | Echos the translation or the original text (with context).
| _n( string $single, string $plural, int $number, string $domain = 'default' ) | Returns the translated singular or plural form of the text.
| _nx( string $single, string $plural, int $number, string $context, string $domain = 'default' ) | Returns the translated singular or plural form of the text (with context).

### Translate & Escape functions

| Function | Description |
| -------- | ----------- |
| esc_html__( string $text, string $domain = 'default' ) | Returns the translation or the original text and escapes it for safe use in HTML output.
| esc_html_e( string $text, string $domain = 'default' ) | Echos the translation or the original text and escapes it for safe use in HTML output.
| esc_html_x( string $text, string $context, string $domain = 'default' ) | Returns the translation or the original text (with context) and escapes it for safe use in HTML output.
| esc_attr__( string $text, string $domain = 'default' ) | Returns the translation or the original text and escapes it for safe use in an attribute.
| esc_attr_e( string $text, string $domain = 'default' ) | Echos the translation or the original text and escapes it for safe use in an attribute.
| esc_attr_x( string $text, string $context, string $domain = 'default' ) | Returns the translation or the original text (with context) and escapes it for safe use in an attribute.

### Date and Number functions
| Function | Description |
| -------- | ----------- |
| number_format_i18n( float $number, int $decimals ) | Returns the given number in the local format.
| date_i18n( string $format, int|bool $timestamp_with_offset = false, bool $gmt = false ) | Returns the given date in the local format.

### [Creating a POT File](https://developer.wordpress.org/apis/handbook/internationalization/localization/#generating-pot-file)

The first step to making your WordPress theme or plugin is to create a POT file. 

There are several ways to create POT files, including:

1. **[WP CLI](https://developer.wordpress.org/apis/handbook/internationalization/localization/#wp-cli):** `wp i18n make-pot path/to/your-plugin-directory`
2. **[Poedit](https://developer.wordpress.org/apis/handbook/internationalization/localization/#poedit):** An open source tool for all major operating systems.
3. **[Loco Translate][https://wordpress.org/plugins/loco-translate/]:** A WordPress plugin that provides in-browser editing of WordPress translation files.

### [Creating PO and MO Files](https://developer.wordpress.org/apis/handbook/internationalization/localization/#translate-po-file)

After creating a POT file, you will need to create a PO file for every language you want to support. A PO file has the same format as the POT, but with translations and some specific headers.

There are several ways to create PO and MO files, including:

1.  **[Poedit](https://developer.wordpress.org/apis/handbook/internationalization/localization/#poedit):** An open source tool for all major operating systems.
3. **[Loco Translate][https://wordpress.org/plugins/loco-translate/]:** A WordPress plugin that provides in-browser editing of WordPress translation files.
3. **[WPML][https://wpml.org/]:** WPML makes it easy to build multilingual sites and run them. It’s powerful enough for corporate sites, yet simple for blogs.


## [Using Localizations](https://developer.wordpress.org/apis/handbook/internationalization/localization/#using-localizations)
As of WordPress 4.0 you can change the language in the “General Settings”. If you do not see any option or the language that you want to switch to then do the following steps:

1. Define WPLANG inside of wp-config.php to your chosen language. For example, if you wanted to use french, you would have: `define ('WPLANG', 'fr_FR');`
2. Go to wp-admin/options-general.php or “Settings” -> “General”
3. Select your language in “Site Language” dropdown
4. Go to wp-admin/update-core.php
5. Click “Update translations”, when available
6. Core translations files are downloaded, when available

> *Additional Reference:* https://premium.wpmudev.org/blog/ultimate-guide-wordpress-localization