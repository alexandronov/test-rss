<?php

namespace App\Message;

use App\Entity\User;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class SendWelcomeEmailHandler implements MessageHandlerInterface
{
    private UserRepository $userRepository;

    private MailerInterface $mailer;

    private LoggerInterface $logger;

    public function __construct(UserRepository $userRepository, MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function __invoke(SendWelcomeEmail $command): void
    {
        /** @var User|null $user */
        $user = $this->userRepository->find($command->getUserId());
        if (null === $user) {
            $this->logger->error('Welcome email failed', [
                'message' => 'User not found by id',
                'user_id' => $command->getUserId(),
            ]);

            throw new \RuntimeException('User not found');
        }

        $email = (new Email())
            ->from('welcome@test-rss.com')
            ->to($user->getEmail())
            ->subject('Welcome to TestRSS!')
            ->text('Hello and welcome to Test RSS project!');

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $this->logger->critical('Welcome email failed', [
                'message' => $e->getMessage(),
                'user_id' => $command->getUserId(),
            ]);
        }
    }
}
