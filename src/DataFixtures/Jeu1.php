<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Plat;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class Jeu1 extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        //Creation des categories
        $categoriesData = [
            ['Pizza', 'pizza_cat.jpg', 'Yes'],
            ['Burger', 'burger_cat.jpg', 'Yes'],
            ['Wraps', 'wrap_cat.jpg', 'Yes'],
            ['Pasta', 'pasta_cat.jpg', 'Yes'],
            ['Sandwich', 'sandwich_cat.jpg', 'Yes'],
            ['Asian Food', 'asian_food_cat.jpg', 'No'],
            ['Salade', 'salade_cat.jpg', 'Yes'],
            ['Veggie', 'veggie_cat.jpg', 'Yes'],
        ];
        foreach ($categoriesData as $Cat) {
            $categorie = new Categorie();
            $categorie->setlibelle($Cat[0])
                ->setimage($Cat[1])
                ->setactive($Cat[2]);

            $manager->persist($categorie);
            
        }

        /*  // Création des plats
        $platsData = [
            ['District Burger', 'Burger composé d’un bun’s du boulanger, deux steaks de 80g (origine française), de deux tranches poitrine de porc fumée, de deux tranches cheddar affiné, salade et oignons confits. .', 8.00, 'hamburger.jpg', 2, 'Yes'],
            ['Pizza Bianca', 'Une pizza fine et croustillante garnie de crème mascarpone légèrement citronnée et de tranches de saumon fumé, le tout relevé de baies roses et de basilic frais.', 14.00, 'pizza-salmon.png', 1, 'Yes'],
            ['CBuffalo Chicken Wrap', 'Du bon filet de poulet mariné dans notre spécialité sucrée & épicée, enveloppé dans une tortilla blanche douce faite maison.', 5.00, 'buffalo-chicken.webp', 3, 'Yes'],
            ['Cheeseburger', 'Burger composé d’un bun’s du boulanger, de salade, oignons rouges, pickles, oignon confit, tomate, d’un steak d’origine Française, d’une tranche de cheddar affiné, et de notre sauce maison.', 8.00, 'cheesburger.jpg', 2, 'Yes'],
            ['Spaghetti aux légumes', 'Un plat de spaghetti au pesto de basilic et légumes poêlés, très parfumé et rapide', 10.00, 'spaghetti-legumes.jpg', 4, 'Yes'],
            ['Salade César', 'Une délicieuse salade Caesar (César) composée de filets de poulet grillés, de feuilles croquantes de salade romaine, de croutons à l\'ail, de tomates cerise et surtout de sa fameuse sauce Caesar. Le tout agrémenté de copeaux de parmesan.', 7.00, 'cesar_salad.jpg', 7, 'Yes'],
            ['Pizza Margherita', 'Une authentique pizza margarita, un classique de la cuisine italienne! Une pâte faite maison, une sauce tomate fraîche, de la mozzarella Fior di latte, du basilic, origan, ail, sucre, sel & poivre...', 14.00, 'pizza-margherita.jpg', 1, 'Yes'],
            ['Courgettes farcies et duxelles de champignons', 'Voici une recette équilibrée à base de courgettes, quinoa et champignons, 100% vegan et sans gluten!', 8.00, 'courgettes_farcies.jpg', 8, 'Yes'],
            ['Lasagnes', 'Découvrez notre recette des lasagnes, l\'une des spécialités italiennes que tout le monde aime avec sa viande hachée et gratinée à l\'emmental. Et bien sûr, une inoubliable béchamel à la noix de muscade.\n\n', 12.00, 'lasagnes_viande.jpg\n', 4, 'Yes'],
            ['Tagliatelles au saumon', 'Découvrez notre recette délicieuse de tagliatelles au saumon frais et à la crème qui qui vous assure un véritable régal!  \n\n', 12.00, 'tagliatelles_saumon.webp\n', 4, 'Yes']
        ];

        foreach ($platsData as $pla) {
            $plat = new Plat();
            $plat->setlibelle($pla[0])
                ->setdescription($pla[1])
                ->setprix($pla[2])
                ->setimage($pla[3])
                //->setcategorie_id($pla[4])
                ->setactive($pla[5]);

            $manager->persist($plat);

           // $plat->setCategorie($pla[4]);
        }
 */
        //creation de client
        $utilisateurData = [
            ['kelly@gmail.com', 'afpa123', 'Dillard', 'Kelly', '0789654780','308 Post Avenue', '80000', 'Amiens'],
            ['thom@gmail.com', 'azerty987', 'Gilchrist', 'Thomas', '0741000145', '1277 Sunburst Drive', '80000', 'Amiens']
        ];

        foreach ($utilisateurData as $user) {
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail($user[0]);
            $password = $this->hasher->hashPassword($utilisateur, $user[1]);
            $utilisateur->setPassword($password)
            ->setNom($user[2])
            ->setPrenom($user[3])
            ->setTelephone($user[4])
            ->setAdresse($user[5])
            ->setCp($user[6])
            ->setVille(($user[7]));

            $manager->persist($utilisateur);
        }

        $manager->flush();
    }
}
