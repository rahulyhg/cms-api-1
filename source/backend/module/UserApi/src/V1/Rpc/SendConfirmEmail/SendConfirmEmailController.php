<?php
namespace UserApi\V1\Rpc\SendConfirmEmail;

use UserApi\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;

class SendConfirmEmailController extends AbstractActionController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function sendConfirmEmailAction()
    {
        $data = $this->getInputFilter()->getValues();

        try {
            $this->userService
                ->getByEmail($data['email'])
                ->sendConfirmEmail();
            $response = [
                'success' => true,
                'result' => [],
                'message' => '',
            ];
        } catch (\RuntimeException $e) {
            $response = [
                'success' => false,
                'result' => [],
                'message' => $e->getMessage(),
            ];
        }

        // TODO create new class to generate the response array
        return $response;
    }
}
