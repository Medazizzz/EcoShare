<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    name: 'app:test-mail',
    description: 'Envoie un email de test via la configuration Symfony Mailer actuelle.',
)]
class TestMailCommand extends Command
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string $notificationEmail = 'medazizwertani@gmail.com',
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $to = $_ENV['APP_PUBLICITE_NOTIFICATION_EMAIL'] ?? $this->notificationEmail;

        $output->writeln('');
        $output->writeln(sprintf('Envoi d\'un email de test à <info>%s</info> ...', $to));

        $email = (new Email())
            ->from($this->fromEmail)
            ->to($to)
            ->subject('Test EcoShare — Brevo SMTP')
            ->text('Ceci est un email de test envoyé depuis EcoShare via Brevo SMTP.')
            ->html('<p>Ceci est un <strong>email de test</strong> envoyé depuis EcoShare via <strong>Brevo SMTP</strong>.</p>');

        $this->mailer->send($email);

        $output->writeln('<info>Email de test envoyé avec succès !</info>');

        return Command::SUCCESS;
    }
}
