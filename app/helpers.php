<?php

use App\Helpers\General\Timezone;
use App\Helpers\General\HtmlHelper;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (! function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (! function_exists('timezone')) {
    /**
     * Access the timezone helper.
     */
    function timezone()
    {
        return resolve(Timezone::class);
    }
}

if (! function_exists('device_agent')) {
    /**
     * Access the device agent helper.
     */
    function device_agent()
    {
        return new Agent();
    }
}

if (! function_exists('include_route_files')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (! function_exists('home_route')) {

    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
        if (auth()->check()) {
            if (auth()->user()->can('view backend')) {
                return 'admin.dashboard';
            } else {
                return 'frontend.user.dashboard';
            }
        }

        return 'frontend.index';
    }
}


if (! function_exists('current_user')) {
    function current_user()
    {
        if (auth()->check()) {
            return auth()->user();
        } else {
            return false;
        }
    }
}

if (! function_exists('style')) {

    /**
     * @param       $url
     * @param array $attributes
     * @param null  $secure
     *
     * @return mixed
     */
    function style($url, $attributes = [], $secure = null)
    {
        return resolve(HtmlHelper::class)->style($url, $attributes, $secure);
    }
}

if (! function_exists('script')) {

    /**
     * @param       $url
     * @param array $attributes
     * @param null  $secure
     *
     * @return mixed
     */
    function script($url, $attributes = [], $secure = null)
    {
        return resolve(HtmlHelper::class)->script($url, $attributes, $secure);
    }
}

if (! function_exists('form_cancel')) {

    /**
     * @param        $cancel_to
     * @param        $title
     * @param string $classes
     *
     * @return mixed
     */
    function form_cancel($cancel_to, $title, $classes = 'btn btn-danger btn-sm')
    {
        return resolve(HtmlHelper::class)->formCancel($cancel_to, $title, $classes);
    }
}

if (! function_exists('form_submit')) {

    /**
     * @param        $title
     * @param string $classes
     *
     * @return mixed
     */
    function form_submit($title, $classes = 'btn btn-success btn-sm pull-right')
    {
        return resolve(HtmlHelper::class)->formSubmit($title, $classes);
    }
}

if (! function_exists('camelcase_to_word')) {

    /**
     * @param $str
     *
     * @return string
     */
    function camelcase_to_word($str)
    {
        return implode(' ', preg_split('/
          (?<=[a-z])
          (?=[A-Z])
        | (?<=[A-Z])
          (?=[A-Z][a-z])
        /x', $str));
    }
}

if (! function_exists('body_classes')) {
    function body_classes()
    {
        $body_classes = [];
        $class        = "";

        foreach (Request::segments() as $segment) {
            if (is_numeric($segment) ||
                empty($segment) ||
                $segment == 'lang' ||
                in_array($segment, array_keys(config('locale.languages')))) {
                continue;
            }

            $class .= ! empty($class) ? "-" . $segment : $segment;

            array_push($body_classes, $class);
        }

        array_push($body_classes, implode(' ', get_device_classes()));

        if (empty($body_classes)) {
            $body_classes[] = 'home';
        }

        return ! empty($body_classes) ? implode(' ', $body_classes) : null;
    }
}

if (! function_exists('get_device_classes')) {
    function get_device_classes()
    {
        $device_classes[] = device_agent()->isDesktop() ? 'is-desktop' : 'not-desktop';
        $device_classes[] = device_agent()->isTablet() ? 'is-tablet' : 'not-tablet';
        $device_classes[] = device_agent()->isMobile() ? 'is-mobile ' . kebab_case(
                device_agent()->device() . ' grade-' . device_agent()->mobileGrade()
            ) : ' not-mobile';
        $device_classes[] = kebab_case(device_agent()->platform());
        $device_classes[] = kebab_case(device_agent()->browser());

        return $device_classes;
    }
}

if (! function_exists('clean_slash_it')) {
    function clean_slash_it($url)
    {
        return preg_replace('/([^:])(\/{2,})/', '$1/', $url);
    }
}

if (! function_exists('plural_from_model')) {
    function plural_from_model($model)
    {
        $plural = Str::plural(class_basename($model));

        return Str::kebab($plural);
    }
}

if (! function_exists('singular_from_model')) {
    function singular_from_model($model)
    {
        $plural = Str::singular(class_basename($model));

        return Str::kebab($plural);
    }
}

if (! function_exists('plural_model')) {
    function plural_model($model)
    {
        return Str::plural(class_basename($model));
    }
}

if (! function_exists('singular_model')) {
    function singular_model($model)
    {
        return Str::singular(class_basename($model));
    }
}

if (! function_exists('str_readable_permission')) {
    function str_readable_permission($permission_name)
    {
        return Str::title(str_replace('-', ' ', $permission_name));
    }
}
