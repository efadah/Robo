<?php
use AspectMock\Test as test;
use Robo\Robo;

class PHPUnitTest extends \Codeception\TestCase\Test
{
    /**
     * @var \AspectMock\Proxy\ClassProxy
     */
    protected $phpunit;

    protected function _before()
    {
        $this->phpunit = test::double('Robo\Task\Testing\PHPUnit', [
            'executeCommand' => null,
            'getOutput' => new \Symfony\Component\Console\Output\NullOutput()
        ]);
    }

    // tests
    public function testPhpUnitRun()
    {
        (new \Robo\Task\Testing\PHPUnit())->run();
        $this->phpunit->verifyInvoked('executeCommand');
    }

    public function testPHPUnitCommand()
    {
        $task = (new \Robo\Task\Testing\PHPUnit('phpunit'))
            ->bootstrap('bootstrap.php')
            ->filter('Model')
            ->group('important')
            ->xml('result.xml')
            ->debug();
        verify($task->getCommand())->equals('phpunit --bootstrap bootstrap.php --filter Model --group important --log-junit result.xml --debug');
        $task->run();
        $this->phpunit->verifyInvoked('executeCommand', ['phpunit --bootstrap bootstrap.php --filter Model --group important --log-junit result.xml --debug']);
    }

}
