<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\GuestTypeEnum;
use App\Entity\Invitation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private array $friends = [
        [
            'name' => 'Petra & Frau Seeger',
            'number_guests_invited' => 2,
            'salutation' => GuestTypeEnum::MULTI
        ],
        [
            'name' => 'Hannelore',
            'number_guests_invited' => 1,
            'salutation' => GuestTypeEnum::SINGLE_FEMALE
        ],
        [
            'name' => 'Dorothea & Rainer',
            'number_guests_invited' => 2,
            'salutation' => GuestTypeEnum::MULTI
        ],
        [
            'name' => 'Anne',
            'number_guests_invited' => 1,
            'salutation' => GuestTypeEnum::SINGLE_FEMALE
        ],
        [
            'name' => 'Liri & Dennis',
            'number_guests_invited' => 2,
            'salutation' => GuestTypeEnum::MULTI
        ],
        [
            'name' => 'Dennis',
            'number_guests_invited' => 1,
            'salutation' => GuestTypeEnum::SINGLE_MALE
        ],
        [
            'name' => 'Adrian',
            'number_guests_invited' => 1,
            'salutation' => GuestTypeEnum::SINGLE_MALE
        ],
        [
            'name' => 'Sascha',
            'number_guests_invited' => 1,
            'salutation' => GuestTypeEnum::SINGLE_MALE
        ],
        [
            'name' => 'Rita & Sven',
            'number_guests_invited' => 2,
            'salutation' => GuestTypeEnum::MULTI
        ], [
            'name' => 'Petra & Mirko',
            'number_guests_invited' => 2,
            'salutation' => GuestTypeEnum::MULTI
        ], [
            'name' => 'Annika, Alex, Henri, Hedda, Loki & Johan',
            'number_guests_invited' => 6,
            'salutation' => GuestTypeEnum::MULTI
        ], [
            'name' => 'Aline, Benni, Fiona & Hailey',
            'number_guests_invited' => 4,
            'salutation' => GuestTypeEnum::MULTI
        ], [
            'name' => 'Thomas',
            'number_guests_invited' => 1,
            'salutation' => GuestTypeEnum::SINGLE_MALE
        ], [
            'name' => 'Hanna, Axel, Eric & Henri',
            'number_guests_invited' => 4,
            'salutation' => GuestTypeEnum::MULTI
        ], [
            'name' => 'Juli, Lutz & Frederik',
            'number_guests_invited' => 3,
            'salutation' => GuestTypeEnum::MULTI
        ], [
            'name' => 'Astrid',
            'number_guests_invited' => 1,
            'salutation' => GuestTypeEnum::SINGLE_FEMALE
        ], [
            'name' => 'Claudi & Böhm',
            'number_guests_invited' => 2,
            'salutation' => GuestTypeEnum::MULTI
        ], [
            'name' => 'Grita, Ferdinand, Leonard, Johanna & Laura',
            'number_guests_invited' => 5,
            'salutation' => GuestTypeEnum::MULTI
        ]
    ];

    private $family = [
        [
            'name' => 'Hans',
            'number_guests_invited' => 1,
            'salutation' => GuestTypeEnum::SINGLE_MALE
        ], [
            'name' => 'Silvia',
            'number_guests_invited' => 1,
            'salutation' => GuestTypeEnum::SINGLE_FEMALE
        ], [
            'name' => 'Lisa, Sven, Marlene & Frieda',
            'number_guests_invited' => 4,
            'salutation' => GuestTypeEnum::MULTI
        ], [
            'name' => 'Linda, Stephan & Anton',
            'number_guests_invited' => 3,
            'salutation' => GuestTypeEnum::MULTI
        ], [
            'name' => 'Gudrun & Peter',
            'number_guests_invited' => 2,
            'salutation' => GuestTypeEnum::MULTI
        ]
    ];

    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasherInterface)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();
        $admin->setUsername('TopfUndDeckel');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->userPasswordHasherInterface->hashPassword(
                $admin, "WeddingFirlefatz13!"
            )
        );
        $manager->persist($admin);

        foreach ($this->friends as $friendMember) {
            $invitation = new Invitation();
            $invitation->setName($friendMember['name']);
            $invitation->setNumberGuestsInvited($friendMember['number_guests_invited']);
            $invitation->setIsFamily(false);
            $invitation->setSalutation($friendMember['salutation']);
            $manager->persist($invitation);
        }

        foreach ($this->family as $familyMember) {
            $invitation = new Invitation();
            $invitation->setName($familyMember['name']);
            $invitation->setNumberGuestsInvited($familyMember['number_guests_invited']);
            $invitation->setIsFamily(true);
            $invitation->setSalutation($familyMember['salutation']);
            $manager->persist($invitation);
        }
        $manager->flush();
    }
}
