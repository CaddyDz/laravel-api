<?php

namespace Tests;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    /** @var array $logFile today's log file content */
    protected $logFile;
    /** @var string $supposedLastEventLogged allegedly the last logged event broadcasting message */
    protected $supposedLastEventLogged;

    /**
     * Setup test case
     *
     * set global variables for every test
     *
     * @return void
     **/
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Set the currently logged in user for the application.
     *
     * @param Illuminate\Contracts\Auth\Authenticatable
     *
     * @return App\User authenticated
     */
    protected function login($user = null)
    {
        $user = $user ?: create(User::class);
        Passport::actingAs($user);
        return $this;
    }

    /**
     * Assert the given event is broadcasted on the given channel
     *
     * Search the log file for the event broadcasting info message title
     *
     * @param \Illuminate\Broadcasting\Channel $channel Channel name
     * @param Event $broadcastedEvent event name that has been broadcasted
     * @return void
     **/
    public function assertChannelHasBroadcastedEvent($channel, $broadcastedEvent)
    {
        $this->assertAnEventIsBroadcasted();
        $this->assertSpecifiedEventIsBroadcasted($broadcastedEvent);
        $this->assertContains(
            "Broadcasting [$broadcastedEvent] on channels [$channel]",
            $this->supposedLastEventLogged,
            "($broadcastedEvent) event was found, but not on the expected channel $channel\n"
        );
    }

    /**
     * Assert the given event is broadcasted
     *
     * Search the log file for the event broadcasting info message title
     *
     * @param Event $broadcastedEvent event name that has been broadcasted
     * @return void
     **/
    public function assertSpecifiedEventIsBroadcasted($broadcastedEvent)
    {
        $this->assertContains(
            'Broadcasting [' . $broadcastedEvent . ']',
            $this->supposedLastEventLogged,
            "A broadcast was found, but not for the classname '" . $broadcastedEvent . "'.\n"
        );
    }

    /**
     * Assert an anonymous event is broadcasted
     *
     * Search the log file for the event broadcasting info message title
     *
     * @return void
     **/
    public function assertAnEventIsBroadcasted()
    {
        $indexOfLoggedEvent = $this->getIndexOfAloggedMessage('testing.INFO: Broadcasting', $this->getLogInfo());
        $this->supposedLastEventLogged = $this->getLogInfo()[$indexOfLoggedEvent];
        $this->assertContains('Broadcasting [', $this->supposedLastEventLogged, "No broadcasts were found.\n");
    }

    /**
     * Get index of logged message
     *
     * Get log line index number of the message
     *
     * @param string $title the logged message title
     * @param array $log log content
     * @return int line index number
     **/
    protected function getIndexOfAloggedMessage($title, array $log)
    {
        // Remove the last line CRLF
        for ($i = count($log) - 1; $i >= 0; $i--) { // Start at the end of the array 12
            // reduce line each time and stop when reach 0
            if (strpos($log[$i], $title) !== false) { // Strict checking for line index 0 is false
                return $i;
            }
        }
        $this->fail('No information found in the log file ' . $this->getLogFileFullPath());
    }

    /**
     * Get log information
     *
     * Get today's log file and convert its content to array
     *
     * @return array $log
     **/
    protected function getLogInfo()
    {
        $log = explode(PHP_EOL, file_get_contents($this->getLogFileFullPath()));
        return $log;
    }

    /**
     * Get log file full path
     *
     * resolve the log file system path in storage
     *
     * @return string $logFilePullPath the path to the log file
     **/
    private function getLogFileFullPath()
    {
        $date = now()->format('Y-m-d');
        $logfileFullpath = storage_path("logs/laravel-{$date}.log");
        return $logfileFullpath;
    }

    protected function resetAuth(array $guards = null)
    {
        $guards = $guards ?: array_keys(config('auth.guards'));

        foreach ($guards as $guard) {
            $guard = $this->app['auth']->guard($guard);

            if ($guard instanceof \Illuminate\Auth\SessionGuard) {
                $guard->logout();
            }
        }

        $protectedProperty = new \ReflectionProperty($this->app['auth'], 'guards');
        $protectedProperty->setAccessible(true);
        $protectedProperty->setValue($this->app['auth'], []);
    }
}
