<?php

namespace Dotenv;

/**
 * Dotenv.
 *
 * Loads a `.env` file in the given directory and sets the environment vars.
 */
class Dotenv
{
    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath;

    /**
     * The loader instance.
     *
     * @var \Dotenv\Loader|null
     */
    protected $loader;

    public function __construct($path, $file = '.env')
    {
        $this->filePath = $this->getFilePath($path, $file);
        $this->loader = new Loader($this->filePath, $immutable = true);
    }

    /**
     * Load `.env` file in given directory.
     *
     * @return array
     */
    public function load()
    {
        $this->loader = new Loader($this->filePath, $immutable = true);

        return $this->loader->load();
    }

    /**
     * Load `.env` file in given directory.
     *
     * @return array
     */
    public function overload()
    {
        $this->loader = new Loader($this->filePath, $immutable = false);

        return $this->loader->load();
    }

    /**
     * Returns the full path to the file.
     *
<<<<<<< HEAD
     * @param $value
     * @return string
     */
    protected static function sanitiseVariableValue($value)
    {
        $value = trim($value);
        $value = trim($value, '> ,');
        if (!$value) return '';
        if (strpbrk($value[0], '"\'') !== false) { // value starts with a quote
            $quote = $value[0];
            $regexPattern = sprintf('/^
                %1$s          # match a quote at the start of the value
                (             # capturing sub-pattern used
                 (?:          # we do not need to capture this
                  [^%1$s\\\\] # any character other than a quote or backslash
                  |\\\\\\\\   # or two backslashes together
                  |\\\\%1$s   # or an escaped quote e.g \"
                 )*           # as many characters that match the previous rules
                )             # end of the capturing sub-pattern
                %1$s          # and the closing quote
                .*$           # and discard any string after the closing quote
                /mx', $quote);
            $value = preg_replace($regexPattern, '$1', $value);
            $value = str_replace("\\$quote", $quote, $value);
            $value = str_replace('\\\\', '\\', $value);
        } else {
            $parts = explode(' #', $value, 2);
            $value = $parts[0];
        }
        return trim($value);
    }

    /**
     * Strips quotes and the optional leading "export " from the environment variable name.
     *
     * @param $name
     * @return string
     */
    protected static function sanitiseVariableName($name)
    {
        return trim(str_replace(array('export ', '\'', '"'), '', $name));
    }

    /**
     * Look for {$varname} patterns in the variable value and replace with an existing
     * environment variable.
=======
     * @param string $path
     * @param string $file
>>>>>>> 101d5d7498bcd827e73c20da2f687e79d2d139f9
     *
     * @return string
     */
    protected function getFilePath($path, $file)
    {
        if (!is_string($file)) {
            $file = '.env';
        }

        $filePath = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$file;

        return $filePath;
    }

    /**
     * Required ensures that the specified variables exist, and returns a new Validator object.
     *
     * @param string|string[] $variable
     *
     * @return \Dotenv\Validator
     */
    public function required($variable)
    {
        return new Validator((array) $variable, $this->loader);
    }
}
