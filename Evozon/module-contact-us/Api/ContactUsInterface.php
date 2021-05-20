<?php


namespace Evozon\ContactUs\Api;

interface ContactUsInterface
{
    /**
     * Sends the Contact Us email using the request parameters, returns boolean indicating success
     *
     * @return bool
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function sendMessage();
}
