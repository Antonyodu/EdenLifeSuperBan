# Superban Laravel Package

## Overview

Superban is a Laravel package designed to enhance your application's rate-limiting capabilities by providing the ability to ban clients completely for a specified period of time. This package integrates seamlessly with Laravel's built-in rate limiting features and allows you to configure different cache drivers such as Redis, Database, etc.

## Installation

To get started with Superban, simply install the package through Composer:

<pre><div class="bg-black rounded-md"><div class="p-4 overflow-y-auto"><code class="!whitespace-pre hljs language-bash">composer require edenlife/superban
</code></div></div></pre>

## Configuration

In the `superban.php` configuration file, you can:

1. **Specify Cache Driver:**
   * Choose the cache driver that Superban should use (e.g., Redis, Database).
2. **Set Ban Threshold:**
   * Configure the number of requests after which a client will be banned.
3. **Define Ban Duration:**
   * Specify the duration of the ban for a client after reaching the threshold.
4. **Choose Ban Criteria:**
   * Decide whether to ban by user ID, IP address, email, or a combination of these.
5. **Apply Bans Globally or Per Route:**
   * Choose whether to apply bans globally for all routes or specify particular routes.

## Usage

To utilize Superban in your Laravel application, add the Superban middleware to the desired routes or apply it globally in your `App\Http\Kernel`:

<pre>protected$middleware = [
     // ... other middleware
     \Edenlife\Superban\Http\Middleware\SuperbanMiddleware::class,
     ];</pre>

### Example Middleware Usage

<pre>Route::get('/protected-route', 'YourController@protectedAction')->middleware('superban');
</pre>

## Contributing

If you encounter any issues or have suggestions for improvements, feel free to open an issue or submit a pull request on the [GitHub repository](https://github.com/Antonyodu/superban).

## License

Superban is open-sourced software licensed under the [MIT license](https://chat.openai.com/c/LICENSE.md).
