# Sample WordPress Plugin

This plugin was written by [Alex Delgado](https://github.com/alexdelgado) as an easy way to teach some fundamental WordPress concepts.

## [WordPress Metaboxes](https://developer.wordpress.org/plugins/metadata/custom-meta-boxes/)
Meta boxes are handy, flexible, modular edit screen elements that can be used to collect information related to the post being edited. 

There are several ways to create custom metaboxes, but I will highlight the three most common:
1. [WordPress API](#wordpress-api)
2. [Custom Metaboxes Plugin](#cmb2-plugin)
3. [Advanced Custom Fields](#advanced-custom-fields)

### WordPress API
WordPress exposes the ability to create your own metaboxes via the [`add_meta_box`](https://developer.wordpress.org/reference/functions/add_meta_box/) function. As you can see from the documentation, there are several parameters required by the `add_meta_box` function, of them however, the most important is the `$callback` parameter. Per the documentation the `$callback` is a }function that fills the box with the desired content [and] should echo its output.". For the purposes of this plugin, our `$callback` function is called `generate_sample_meta_box`.

Our `generate_sample_meta_box` does a few things:
1. Checks to see if we already have any saved metadata, and if so prepares that data for display in our form fields.
2. Creates a [wordpress nonce](https://developer.wordpress.org/reference/functions/wp_nonce_field/) to "validate that the contents of [our metabox] form came from" inside our WordPress Admin.
3. Renders our metabox form on the desired WordPress `post_type` editor screen.

You'll notice that our `generate_sample_meta_box` function does not save our metadata, that is because WordPress decouples the save logic from the display logic. Therefore, to save our metabox form, we have to hook into the [`save_post`](https://developer.wordpress.org/reference/hooks/save_post/) action.  For the purposes of this plugin, when WordPress calls the `save_post` action, our `save_post_meta` function gets called.

Inside our `save_post_meta` function we run a few checks to verify that it the right time to save our metabox form. These checks include:
1. Checking that WordPress isn't performing an AJAX request (because we don't save our metabox forms via AJAX requests).
2. Validate the nonce we created in our `generate_sample_meta_box` function
3. Make sure the current user has permission to edit the given post
4. Then finally, save our metabox fields to the database (via `_save_article_meta_box`)

### CMB2 Plugin
Using the WordPress API is great for understanding how WordPress works, but we might not always want to go so deep into the codebase or have to write so much boilerplate. Fortunately there are plugins like [CMB2](https://cmb2.io/) that can help us! CMB2 allows us to quickly create custom WordPress Metaboxes with lots of additonal functionality.

CMB2 handles the display and save logic for us so all we have to do is register a metabox using the [`new_cmb2_box`](https://cmb2.io/docs/display-options) function as shown in our `CMB2->register_meta_boxes` function, then add our desired fields using the `add_field` function as demonstrated in our `CMB2->register_meta_boxes` function.

### Advanced Custom Fields
Plugins like CMB2 are great time savers, but they still require some coding. Wouldn't it be great if we could just configure everything in a UI without having to write code? [Advanced Custom Fields](https://www.advancedcustomfields.com/) also known as ACF, let's us do just that! Once you install the plugin you'll have access to a UI with options for creating highly customizeable custom fields and metaboxes.

### What Works Best
These are just three of the most popular options out there - if you do some quick research online you're likely to find even more impressive options. However for the purposes of this tutorial, we'll stick to these three options.

1. **WordPress API** The WordPress API is great if you have the time and energy to code everything from scratch. It's very handy to know how it all works together, but most developers won't need that level of control.

2. **CMB2** CMB2 simplifies the WordPress API and allows you to work quickly. It also gives you access to several add-ons such as repeatable fields, different field types, and you can use it for more than just metaboxes. CMB2 is also highly customizeable so it's unlikely you'll run into a situation it can't handle.

3. **Advanced Custom Fields** ACF requires no code on the backend, is highly customizeble, and has free and paid add-ons to help you solve even the most difficult of problems. It's quick, easy, and well-maintained.
