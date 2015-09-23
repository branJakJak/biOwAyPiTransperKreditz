<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 9/23/15
 * Time: 7:03 PM
 * To change this template use File | Settings | File Templates.
 */

class RemoteVicidialBase {
    /**
     * @var $remote_user SipAccount
     */
    protected $remote_user;

    /**
     *
     * @param SipAccount $current_user
     */
    function __construct(SipAccount $current_user)
    {
        $this->setRemoteUser($current_user);
    }

    public function setRemoteUser($current_user)
    {
        $this->remote_user = $current_user;
    }

    public function getRemoteUser()
    {
        return $this->remote_user;
    }

}