Laravel App Toolkit
---

<a href="https://floobits.com/r/rtablada/app-toolkit/redirect">
  <img alt="Floobits status" width="80" height="40" src="https://floobits.com/r/rtablada/app-toolkit.png" />
</a>

This App Toolkit will help you to create sub-applications similar to subapps found in Django and other frameworks.
This helps you make small MVC apps to organize your larger apps.

To learn more about this mentality, check out [my blog post about this file structure](http://ryantablada.com/post/juggling-larger-laravel-applications).

Installing
===

Add `rtablada/app-toolkit` to your `composer.json` file.
Then add `Rtablada\AppToolkit\AppToolkitServiceProvider` to your `providers` list in your `app/config/app.php` file.

Configuring Your Application
===

App Toolkit needs to know what your app name is so that it knows where to place all of it's files.
To configure this, run `php artisan config:publish rtablada/app-toolkit` then go to `app/config/packages/rtablada/app-toolkit/config.php` and change the `app_name` config option to your application namespace.

You will also need to set this up to be autoloaded in your `composer.json`.
So if your `app_name` is `Blog` in your autoload section, you should have something that looks like this:

```
"psr-0": {
    "Rtablada\\AppToolkit": "src/"
}
```

Creating Your Sub-Application
===

Now you can just create a sub-app by just running `php artisan application:make subAppName`.
Just register your generated Service Provider in your `app/config/app.php` file and you are set to go.

Future Features
===

IMO, the setup process is a bit much with the whole composer autoloader.
I'm looking to create a command `application:start` which will ask you your application namespace, setup the configuration PSR-0 autoloading, and setup some shared application resources and folders.

I'd also like to have sub-applications automatically register themselves in `app/config/app.php`.

Finally, I'd like to add options to the `application:make` command so that you can specify different view namespaces, decide whether to include filters and routes.
