<?php declare(strict_types=1);

namespace Evozon\ContactUs\Model\Api;

use Evozon\ContactUs\Api\ContactUsInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Webapi\Rest\Request as Request;
use Psr\Log\LoggerInterface;

class ContactUs implements ContactUsInterface
{
    /**
     * @var MailInterface
     */
    private MailInterface $mail;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    private Request $request;

    /**
     * ContactUs constructor
     */
    public function __construct(
        MailInterface $mail,
        LoggerInterface $logger,
        Request $request,
        ResultFactory $resultFactory
    ) {
        $this->mail = $mail;
        $this->logger = $logger;
        $this->request = $request;
    }

    /**
     * Validates Contact Us parameters
     *
     * @return array
     * @throws LocalizedException
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    private function validatedParams()
    {
        if (trim($this->request->getParam('name')) === '') {
            throw new LocalizedException(__('Enter the Name and try again.'));
        }
        if (trim($this->request->getParam('comment')) === '') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }
        if (false === \strpos($this->request->getParam('email'), '@')) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }

        return $this->request->getParams();
    }

    /**
     * Sends the Contact Us email using the given parameters, returns boolean indicating success
     *
     * @return bool
     * @author Bogdan Tomi <bogdan.tomi@evozon.com>
     */
    public function sendMessage()
    {
        $result = false;
        try {
            $this->sendEmail($this->validatedParams());
            $result = true;
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }

        return $result;
    }

    /**
     * Send Contact Us email
     *
     * @param array $post Post data from contact form
     * @return void
     */
    private function sendEmail($post)
    {
        $this->mail->send(
            $post['email'],
            ['data' => new DataObject($post)]
        );
    }
}
