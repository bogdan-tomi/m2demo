<?php


namespace Evozon\ContactUs\Api;

interface ContactUsInterface
{
    /**
     * Sends the Contact Us email using the given parameters, returns boolean indicating success
     *
     * @param string $name
     * @param string $email
     * @param string $comment
     * @return bool
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function sendMessage($name, $email, $comment);
}
