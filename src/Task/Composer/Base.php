<?php
namespace Robo\Task\Composer;

use Robo\Task\BaseTask;
use Robo\Exception\TaskException;

abstract class Base extends BaseTask
{
    use \Robo\Common\ExecOneCommand;
    use \Robo\Common\IO;

    protected $prefer;
    protected $dev;
    protected $optimizeAutoloader;
    protected $ansi;
    protected $dir;

    /**
     * Action to use
     *
     * @var string
     */
    protected $action = '';

    /**
     * adds `prefer-dist` option to composer
     *
     * @return $this
     */
    public function preferDist()
    {
        $this->prefer = '--prefer-dist';
        return $this;
    }

    /**
     * adds `prefer-source` option to composer
     *
     * @return $this
     */
    public function preferSource()
    {
        $this->prefer = '--prefer-source';
        return $this;
    }

    /**
     * adds `no-dev` option to composer
     *
     * @return $this
     */
    public function noDev()
    {
        $this->dev = '--no-dev';
        return $this;
    }

    /**
     * adds `no-ansi` option to composer
     *
     * @return $this
     */
    public function noAnsi()
    {
        $this->ansi = '--no-ansi';
        return $this;
    }

    /**
     * adds `ansi` option to composer
     *
     * @return $this
     */
    public function ansi()
    {
        $this->ansi = '--ansi';
        return $this;
    }

    /**
     * adds `optimize-autoloader` option to composer
     *
     * @return $this
     */
    public function optimizeAutoloader()
    {
        $this->optimizeAutoloader = '--optimize-autoloader';
        return $this;
    }

    public function __construct($pathToComposer = null)
    {
        $this->command = $pathToComposer;
        if (!$this->command) {
            $this->command = $this->findExecutablePhar('composer');
        }
        if (!$this->command) {
            throw new TaskException(__CLASS__, "Neither local composer.phar nor global composer installation could be found.");
        }

        if ($this->getOutput()->isDecorated()) {
            $this->ansi();
        }
    }

    public function getCommand()
    {
        $this->option($this->prefer)
            ->option($this->dev)
            ->option($this->optimizeAutoloader)
            ->option($this->ansi);
        return "{$this->command} {$this->action}{$this->arguments}";
    }
}
