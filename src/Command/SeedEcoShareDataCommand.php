<?php

namespace App\Command;

use App\Entity\Publicite;
use App\Entity\SponsorPartenaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:seed-ecoshare',
    description: 'Insère des données d\'exemple pour Sponsors / Partenaires / Publicités',
)]
class SeedEcoShareDataCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $repoSponsor = $this->em->getRepository(SponsorPartenaire::class);
        $repoPub = $this->em->getRepository(Publicite::class);

        if ($repoSponsor->count([]) > 0 || $repoPub->count([]) > 0) {
            $io->warning('Il y a déjà des données en base. Aucune donnée de démo n\'a été ajoutée.');
            return Command::SUCCESS;
        }

        $greenBank = (new SponsorPartenaire())
            ->setNom('GreenBank')
            ->setLogo('https://via.placeholder.com/200x80?text=GreenBank')
            ->setDescription('Banque engagée dans le financement de projets verts.')
            ->setType('sponsor')
            ->setLien('https://example.com/greenbank');

        $ecoCity = (new SponsorPartenaire())
            ->setNom('EcoCity')
            ->setLogo('https://via.placeholder.com/200x80?text=EcoCity')
            ->setDescription('Initiative locale pour des villes plus propres.')
            ->setType('partenaire')
            ->setLien('https://example.com/ecocity');

        $solarWorld = (new SponsorPartenaire())
            ->setNom('SolarWorld')
            ->setLogo('https://via.placeholder.com/200x80?text=SolarWorld')
            ->setDescription('Entreprise spécialisée dans l\'énergie solaire.')
            ->setType('sponsor')
            ->setLien('https://example.com/solarworld');

        $this->em->persist($greenBank);
        $this->em->persist($ecoCity);
        $this->em->persist($solarWorld);

        $pub1 = (new Publicite())
            ->setImage('https://via.placeholder.com/600x300?text=Campagne+GreenBank')
            ->setDescription('Ouvrez un compte vert et financez des projets écologiques.')
            ->setLien('https://example.com/greenbank/campagne')
            ->setSponsorPartenaire($greenBank);

        $pub2 = (new Publicite())
            ->setImage('https://via.placeholder.com/600x300?text=EcoCity+Nettoyage')
            ->setDescription('Participez aux journées de nettoyage de votre quartier.')
            ->setLien('https://example.com/ecocity/actions')
            ->setSponsorPartenaire($ecoCity);

        $pub3 = (new Publicite())
            ->setImage('https://via.placeholder.com/600x300?text=SolarWorld+Promo')
            ->setDescription('Installez des panneaux solaires à prix réduit.')
            ->setLien('https://example.com/solarworld/offre')
            ->setSponsorPartenaire($solarWorld);

        $pub4 = (new Publicite())
            ->setImage('https://via.placeholder.com/600x300?text=Campagne+EcoShare')
            ->setDescription('Réutilisez, partagez, réduisez vos déchets avec EcoShare.')
            ->setLien('https://example.com/ecoshare')
            ->setSponsorPartenaire(null);

        $this->em->persist($pub1);
        $this->em->persist($pub2);
        $this->em->persist($pub3);
        $this->em->persist($pub4);

        $this->em->flush();

        $io->success('Données de démo insérées : 3 sponsors/partenaires et 4 publicités.');

        return Command::SUCCESS;
    }
}
