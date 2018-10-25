<?php
/**
 * Created by PhpStorm.
 * User: greatsir
 * Date: 2018/10/25
 * Time: 上午9:31
 */

namespace think\queue\job;


use think\queue\Job;

class Alimq extends Job
{

    /**
     * Fire the job.
     * @return void
     */
    public function fire()
    {
        // TODO: Implement fire() method.
    }

    /**
     * Get the number of times the job has been attempted.
     * @return int
     */
    public function attempts()
    {
        // TODO: Implement attempts() method.
    }

    /**
     * Get the raw body string for the job.
     * @return string
     */
    public function getRawBody()
    {
        // TODO: Implement getRawBody() method.
    }
}