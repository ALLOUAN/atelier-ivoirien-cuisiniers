<?php

namespace App\Support;

/**
 * Sample content of the free mock-up offered to "Atelier Ivoirien Des Cuisiniers" (Cocody).
 * No database on purpose: every figure, price, name and review is an example to be replaced with the client's own.
 */
class AtelierCuisiniers
{
    /**
     * Site pages: slug => [view, title, description]. The empty slug is the home page.
     *
     * @var array<string, array{view: string, title: string, description: string}>
     */
    public const PAGES = [
        '' => ['view' => 'accueil', 'title' => 'Formation culinaire à Cocody', 'description' => 'Formations en cuisine ivoirienne, pâtisserie et traiteur à Cocody. Menu en ligne et commandes sur WhatsApp.'],
        'formations' => ['view' => 'formations', 'title' => 'Nos formations', 'description' => 'Cuisine ivoirienne, pâtisserie, cuisinier professionnel et traiteur : toutes nos formations à Cocody.'],
        'menu' => ['view' => 'menu', 'title' => 'Menu & commandes', 'description' => 'Commandez nos plats ivoiriens, pâtisseries et boissons, livrés à Cocody et Riviera, sur WhatsApp.'],
        'traiteur' => ['view' => 'traiteur', 'title' => 'Traiteur & événements', 'description' => 'Mariages, baptêmes, anniversaires et entreprises : nos formules traiteur et devis sur WhatsApp.'],
        'calendrier' => ['view' => 'calendrier', 'title' => 'Calendrier des sessions', 'description' => 'Les prochaines rentrées de nos formations et les places restantes.'],
        'atelier' => ['view' => 'atelier', 'title' => 'L’atelier & les chefs', 'description' => 'Notre histoire, nos cuisines et les chefs formateurs de l’atelier.'],
        'reussites' => ['view' => 'reussites', 'title' => 'Réussites d’élèves', 'description' => 'Ils ont suivi nos formations et vivent aujourd’hui de la cuisine.'],
        'galerie' => ['view' => 'galerie', 'title' => 'Galerie', 'description' => 'Photos et vidéos de nos cours et de nos plats.'],
        'avis' => ['view' => 'avis', 'title' => 'Avis clients', 'description' => 'Ce que disent nos élèves et nos clients.'],
        'inscription' => ['view' => 'inscription', 'title' => 'Inscription en ligne', 'description' => 'Réservez votre place en formation en deux minutes.'],
        'contact' => ['view' => 'contact', 'title' => 'Contact & accès', 'description' => 'Adresse, horaires, téléphone et itinéraire jusqu’à l’atelier.'],
        'faq' => ['view' => 'faq', 'title' => 'Questions fréquentes', 'description' => 'Âge minimum, paiement, attestation, livraison : nos réponses.'],
        'mentions-legales' => ['view' => 'mentions', 'title' => 'Mentions légales & confidentialité', 'description' => 'Informations légales et protection des données.'],
        'gerant' => ['view' => 'gerant.tableau-de-bord', 'title' => 'Tableau de bord', 'description' => 'Espace gérant.'],
        'gerant/caisse' => ['view' => 'gerant.caisse', 'title' => 'Caisse', 'description' => 'Espace gérant.'],
        'gerant/stock' => ['view' => 'gerant.stock', 'title' => 'Stock', 'description' => 'Espace gérant.'],
        'gerant/clients' => ['view' => 'gerant.clients', 'title' => 'Élèves & clients', 'description' => 'Espace gérant.'],
    ];

    /**
     * @return array{name: string, short: string, city: string, address: string, hours: string, whatsapp: string, phone: string, email: string}
     */
    public function business(): array
    {
        return [
            'name' => 'Atelier Ivoirien Des Cuisiniers',
            'short' => 'AIC',
            'city' => 'Cocody, Abidjan',
            'address' => 'Cocody Angré, non loin du carrefour (adresse à confirmer)',
            'hours' => 'Lun – Sam · 8h00 – 18h00',
            'whatsapp' => '2250700000000',
            'phone' => '+225 07 00 00 00 00',
            'email' => 'contact@atelier-cuisiniers.ci',
        ];
    }

    /**
     * @return list<array{slug: string, icon: string, title: string, category: string, level: string, duration: string, schedule: string, price: int, installments: int, featured: bool, summary: string, points: list<string>, program: list<array{week: string, topic: string}>, included: list<string>}>
     */
    public function trainings(): array
    {
        return [
            [
                'slug' => 'cuisine-ivoirienne', 'icon' => '🍲', 'image' => 'sauce-graine1', 'title' => 'Cuisine ivoirienne', 'category' => 'debutant',
                'level' => 'Débutant', 'duration' => '4 semaines', 'schedule' => '3 matinées par semaine', 'price' => 75000, 'installments' => 2, 'featured' => false,
                'summary' => 'Maîtrisez les grands classiques de chez nous, pour la famille ou pour vendre.',
                'points' => ['Sauces graine, arachide, gombo', 'Kédjénou, foutou, placali', 'Hygiène et organisation'],
                'program' => [
                    ['week' => 'Semaine 1', 'topic' => 'Hygiène, découpe, bases des sauces (tomate, arachide)'],
                    ['week' => 'Semaine 2', 'topic' => 'Sauce graine, sauce gombo, foutou banane et igname'],
                    ['week' => 'Semaine 3', 'topic' => 'Kédjénou, poisson braisé, attiéké et alloco'],
                    ['week' => 'Semaine 4', 'topic' => 'Placali, sauce kopè, repas complet noté'],
                ],
                'included' => ['Tous les ingrédients', 'Tablier et toque', 'Livret de recettes', 'Attestation'],
            ],
            [
                'slug' => 'patisserie-boulangerie', 'icon' => '🥐', 'image' => 'gateau', 'title' => 'Pâtisserie & boulangerie', 'category' => 'debutant',
                'level' => 'Tous niveaux', 'duration' => '6 semaines', 'schedule' => '2 après-midi par semaine', 'price' => 120000, 'installments' => 3, 'featured' => false,
                'summary' => 'Des viennoiseries aux gâteaux d’anniversaire, avec le calcul du prix de vente.',
                'points' => ['Pâtes de base, viennoiseries', 'Gâteaux d’anniversaire', 'Calcul du prix de revient'],
                'program' => [
                    ['week' => 'Semaines 1–2', 'topic' => 'Pâte brisée, sablée, feuilletée ; tartes'],
                    ['week' => 'Semaines 3–4', 'topic' => 'Pain, croissants, pains au chocolat, beignets'],
                    ['week' => 'Semaine 5', 'topic' => 'Génoise, crèmes, montage et décor de gâteaux'],
                    ['week' => 'Semaine 6', 'topic' => 'Prix de revient, présentation, examen pratique'],
                ],
                'included' => ['Tous les ingrédients', 'Petit matériel prêté', 'Livret de recettes', 'Attestation'],
            ],
            [
                'slug' => 'cuisinier-professionnel', 'icon' => '👨🏾‍🍳', 'image' => 'cuisiniere2', 'title' => 'Cuisinier professionnel', 'category' => 'professionnel',
                'level' => 'Certifiant', 'duration' => '6 mois', 'schedule' => 'Du lundi au vendredi', 'price' => 350000, 'installments' => 6, 'featured' => true,
                'summary' => 'La formation complète pour travailler en restaurant, hôtel ou ouvrir votre maquis.',
                'points' => ['Cuisine africaine & internationale', 'Stage en restaurant', 'Attestation de fin de formation'],
                'program' => [
                    ['week' => 'Mois 1', 'topic' => 'Hygiène HACCP, techniques de base, organisation du poste'],
                    ['week' => 'Mois 2–3', 'topic' => 'Cuisine ivoirienne et africaine, grillades, sauces'],
                    ['week' => 'Mois 4', 'topic' => 'Cuisine internationale, pâtisserie de restaurant'],
                    ['week' => 'Mois 5', 'topic' => 'Gestion : stock, fiches techniques, coûts, service'],
                    ['week' => 'Mois 6', 'topic' => 'Stage en restaurant partenaire et examen final'],
                ],
                'included' => ['Tous les ingrédients', 'Tenue complète', 'Stage en entreprise', 'Attestation de fin de formation'],
            ],
            [
                'slug' => 'traiteur-evenementiel', 'icon' => '🎉', 'image' => 'garba2', 'title' => 'Traiteur & événementiel', 'category' => 'court',
                'level' => 'Intermédiaire', 'duration' => '3 semaines', 'schedule' => '3 journées par semaine', 'price' => 90000, 'installments' => 2, 'featured' => false,
                'summary' => 'Cuisiner pour 50 à 300 personnes et lancer votre activité traiteur.',
                'points' => ['Buffets mariages et baptêmes', 'Grandes quantités', 'Lancer son activité'],
                'program' => [
                    ['week' => 'Semaine 1', 'topic' => 'Menus de buffet, quantités par personne, achats'],
                    ['week' => 'Semaine 2', 'topic' => 'Production en grande quantité, conservation, transport'],
                    ['week' => 'Semaine 3', 'topic' => 'Dressage, devis, prix, trouver ses premiers clients'],
                ],
                'included' => ['Tous les ingrédients', 'Modèles de devis', 'Livret de recettes', 'Attestation'],
            ],
            [
                'slug' => 'atelier-week-end', 'icon' => '🔥', 'image' => 'poelee', 'title' => 'Atelier du samedi', 'category' => 'court',
                'level' => 'Découverte', 'duration' => '1 journée', 'schedule' => 'Samedi 9h – 14h', 'price' => 15000, 'installments' => 1, 'featured' => false,
                'summary' => 'Un plat, un chef, un samedi : idéal pour découvrir ou offrir.',
                'points' => ['Un thème différent chaque samedi', 'Repas partagé sur place', 'Bon cadeau possible'],
                'program' => [
                    ['week' => '9h00', 'topic' => 'Accueil, présentation du plat et des produits'],
                    ['week' => '10h00', 'topic' => 'Préparation guidée par le chef'],
                    ['week' => '13h00', 'topic' => 'Dégustation et remise des recettes'],
                ],
                'included' => ['Tous les ingrédients', 'Fiche recette', 'Repas sur place'],
            ],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function training(string $slug): ?array
    {
        return collect($this->trainings())->firstWhere('slug', $slug);
    }

    /**
     * @return array<string, list<array{name: string, desc: string, price: int, emoji: string}>>
     */
    public function menu(): array
    {
        return [
            'Plats ivoiriens' => [
                ['name' => 'Attiéké poisson braisé', 'desc' => 'Carpe braisée, attiéké, alloco, piment frais', 'price' => 3500, 'emoji' => '🐟', 'image' => 'garba2'],
                ['name' => 'Kédjénou de poulet', 'desc' => 'Poulet mijoté à l’étouffée, riz blanc', 'price' => 4000, 'emoji' => '🍗', 'image' => 'kedjenou-marmite'],
                ['name' => 'Foutou sauce graine', 'desc' => 'Foutou banane, sauce graine viande de bœuf', 'price' => 3500, 'emoji' => '🥘', 'image' => 'foutou-graine'],
                ['name' => 'Garba complet', 'desc' => 'Attiéké, thon frit, oignons, tomates', 'price' => 1500, 'emoji' => '🍛', 'image' => 'garba'],
                ['name' => 'Placali sauce kopè', 'desc' => 'Placali, sauce gombo frais, poisson fumé', 'price' => 3000, 'emoji' => '🍲', 'image' => 'placali'],
            ],
            'Grillades' => [
                ['name' => 'Poulet braisé entier', 'desc' => 'Mariné aux épices, alloco ou attiéké', 'price' => 7000, 'emoji' => '🍗', 'image' => 'attieke-poulet'],
                ['name' => 'Brochettes de bœuf (x5)', 'desc' => 'Soya, oignons, piment', 'price' => 2500, 'emoji' => '🍢', 'image' => 'brochettes'],
                ['name' => 'Choukouya de mouton', 'desc' => 'Mouton grillé, oignons, attiéké', 'price' => 5000, 'emoji' => '🥩', 'image' => 'cuisine-ci'],
            ],
            'Pâtisseries' => [
                ['name' => 'Gâteau d’anniversaire', 'desc' => '8 parts, décor personnalisé (48 h avant)', 'price' => 15000, 'emoji' => '🎂', 'image' => 'gateau'],
                ['name' => 'Beignets (x10)', 'desc' => 'Beignets sucrés maison', 'price' => 1000, 'emoji' => '🍩'],
                ['name' => 'Croissants (x6)', 'desc' => 'Pur beurre, cuits le matin', 'price' => 3000, 'emoji' => '🥐', 'image' => 'croissants'],
            ],
            'Boissons' => [
                ['name' => 'Bissap maison 1 L', 'desc' => 'Fleurs d’hibiscus, menthe', 'price' => 1000, 'emoji' => '🍷', 'image' => 'jus'],
                ['name' => 'Gnamankoudji 1 L', 'desc' => 'Jus de gingembre frais', 'price' => 1000, 'emoji' => '🫚', 'image' => 'jus'],
                ['name' => 'Jus de baobab 1 L', 'desc' => 'Pain de singe, lait', 'price' => 1500, 'emoji' => '🥛', 'image' => 'jus'],
            ],
        ];
    }

    /**
     * @return list<array{area: string, fee: int, delay: string}>
     */
    public function deliveryZones(): array
    {
        return [
            ['area' => 'Angré, Deux-Plateaux', 'fee' => 500, 'delay' => '30 – 45 min'],
            ['area' => 'Riviera 2, 3, Palmeraie', 'fee' => 1000, 'delay' => '45 – 60 min'],
            ['area' => 'Cocody centre, Blockhaus', 'fee' => 1000, 'delay' => '45 – 60 min'],
            ['area' => 'Bingerville, Plateau, Marcory', 'fee' => 2000, 'delay' => '60 – 90 min'],
        ];
    }

    /**
     * @return list<array{name: string, guests: string, price: string, items: list<string>, featured: bool}>
     */
    public function cateringPackages(): array
    {
        return [
            ['name' => 'Formule Famille', 'image' => 'kedjenou', 'guests' => '20 à 50 personnes', 'price' => 'dès 4 500 FCFA / pers.', 'featured' => false, 'items' => ['2 plats ivoiriens au choix', 'Attiéké, riz, alloco', 'Boissons maison', 'Livraison incluse à Cocody']],
            ['name' => 'Formule Cérémonie', 'image' => 'banniere-traiteur', 'guests' => '50 à 200 personnes', 'price' => 'dès 6 500 FCFA / pers.', 'featured' => true, 'items' => ['Buffet 4 plats + grillades', 'Entrées et desserts', 'Service et dressage', 'Vaisselle fournie']],
            ['name' => 'Formule Entreprise', 'image' => 'buffet', 'guests' => 'Séminaires, pauses-café', 'price' => 'Sur devis', 'featured' => false, 'items' => ['Pause-café et déjeuner', 'Plateaux individuels', 'Facture au nom de la société', 'Livraison à l’heure']],
        ];
    }

    /**
     * @return list<array{month: string, training: string, slug: string, start: string, days: string, seats: int, left: int}>
     */
    public function sessions(): array
    {
        return [
            ['month' => 'Novembre 2026', 'training' => 'Cuisine ivoirienne', 'slug' => 'cuisine-ivoirienne', 'start' => 'Lundi 3 novembre', 'days' => 'Lun · Mer · Ven, 8h – 12h', 'seats' => 12, 'left' => 3],
            ['month' => 'Novembre 2026', 'training' => 'Atelier du samedi : kédjénou', 'slug' => 'atelier-week-end', 'start' => 'Samedi 8 novembre', 'days' => '9h – 14h', 'seats' => 10, 'left' => 0],
            ['month' => 'Novembre 2026', 'training' => 'Pâtisserie & boulangerie', 'slug' => 'patisserie-boulangerie', 'start' => 'Mardi 11 novembre', 'days' => 'Mar · Jeu, 14h – 18h', 'seats' => 12, 'left' => 7],
            ['month' => 'Décembre 2026', 'training' => 'Traiteur & événementiel', 'slug' => 'traiteur-evenementiel', 'start' => 'Lundi 1er décembre', 'days' => 'Lun · Mer · Ven, 8h – 16h', 'seats' => 10, 'left' => 5],
            ['month' => 'Décembre 2026', 'training' => 'Atelier du samedi : bûche de Noël', 'slug' => 'atelier-week-end', 'start' => 'Samedi 20 décembre', 'days' => '9h – 14h', 'seats' => 10, 'left' => 4],
            ['month' => 'Janvier 2027', 'training' => 'Cuisinier professionnel', 'slug' => 'cuisinier-professionnel', 'start' => 'Lundi 12 janvier', 'days' => 'Lun – Ven, 8h – 15h', 'seats' => 15, 'left' => 9],
            ['month' => 'Janvier 2027', 'training' => 'Cuisine ivoirienne', 'slug' => 'cuisine-ivoirienne', 'start' => 'Lundi 19 janvier', 'days' => 'Lun · Mer · Ven, 8h – 12h', 'seats' => 12, 'left' => 12],
        ];
    }

    /**
     * @return list<array{name: string, role: string, bio: string, emoji: string}>
     */
    public function chefs(): array
    {
        return [
            ['name' => 'Chef Adjoua K.', 'role' => 'Fondatrice, cuisine ivoirienne', 'bio' => '20 ans de cuisine, dont 8 en hôtellerie au Plateau.', 'emoji' => '👩🏾‍🍳'],
            ['name' => 'Chef Yao M.', 'role' => 'Cuisine professionnelle', 'bio' => 'Ancien chef de partie en restaurant gastronomique.', 'emoji' => '👨🏾‍🍳'],
            ['name' => 'Chef Mariam T.', 'role' => 'Pâtisserie & boulangerie', 'bio' => 'Pâtissière formée à Dakar, spécialiste des gâteaux de fête.', 'emoji' => '🧁'],
        ];
    }

    /**
     * @return list<array{name: string, training: string, before: string, after: string, quote: string, emoji: string, image: string}>
     */
    public function successes(): array
    {
        return [
            ['name' => 'Aminata K.', 'training' => 'Pâtisserie & boulangerie', 'before' => 'Vendeuse en boutique', 'after' => 'Ses gâteaux sur commande à Angré', 'quote' => 'Je gagne aujourd’hui plus qu’avant, et je travaille pour moi.', 'emoji' => '🎂', 'image' => 'gateau'],
            ['name' => 'Fatou B.', 'training' => 'Cuisinier professionnel', 'before' => 'Sans emploi', 'after' => 'Cuisinière dans un restaurant à la Riviera', 'quote' => 'Le stage m’a ouvert la porte. J’ai été embauchée à la fin.', 'emoji' => '👩🏾‍🍳', 'image' => 'cuisiniere2'],
            ['name' => 'Koffi A.', 'training' => 'Traiteur & événementiel', 'before' => 'Aide-cuisinier', 'after' => 'A ouvert son service traiteur', 'quote' => 'J’ai fait 12 mariages la première année.', 'emoji' => '🎉', 'image' => 'garba2'],
            ['name' => 'Rose N.', 'training' => 'Cuisine ivoirienne', 'before' => 'Mère au foyer', 'after' => 'Son maquis à Bingerville', 'quote' => 'Mon garba et mon kédjénou ont maintenant leurs habitués.', 'emoji' => '🍲', 'image' => 'kedjenou'],
        ];
    }

    /**
     * @return list<array{label: string, category: string, image: string, video: bool}>
     */
    public function gallery(): array
    {
        return [
            ['label' => 'Cours de sauce graine : le pilon', 'category' => 'Cours', 'image' => 'sauce-graine1', 'video' => false],
            ['label' => 'En cuisine pédagogique', 'category' => 'Atelier', 'image' => 'cuisiniere2', 'video' => false],
            ['label' => 'Attiéké poisson du jour', 'category' => 'Plats', 'image' => 'garba2', 'video' => false],
            ['label' => 'Montage d’un gâteau', 'category' => 'Cours', 'image' => 'gateau', 'video' => true],
            ['label' => 'Tables dressées pour un mariage', 'category' => 'Traiteur', 'image' => 'banniere-traiteur', 'video' => false],
            ['label' => 'Kédjénou en marmite', 'category' => 'Plats', 'image' => 'kedjenou-marmite', 'video' => false],
            ['label' => 'Les rôtissoires de l’atelier', 'category' => 'Atelier', 'image' => 'cuisiniere', 'video' => false],
            ['label' => 'Poulet braisé et attiéké', 'category' => 'Plats', 'image' => 'attieke-poulet', 'video' => true],
            ['label' => 'Grillades pour un baptême', 'category' => 'Traiteur', 'image' => 'banniere-menu', 'video' => false],
            ['label' => 'Foutou sauce graine', 'category' => 'Plats', 'image' => 'foutou-graine', 'video' => false],
            ['label' => 'Croissants du matin', 'category' => 'Cours', 'image' => 'croissants', 'video' => false],
            ['label' => 'Alloco bien doré', 'category' => 'Plats', 'image' => 'alloco', 'video' => false],
        ];
    }

    /**
     * Home page banner slides.
     *
     * @return list<array{image: string, eyebrow: string, title: string, highlight: string, text: string, cta: string, cta_page: string, secondary: string, secondary_page: string}>
     */
    public function banners(): array
    {
        return [
            ['image' => 'banniere-formation', 'eyebrow' => 'École de cuisine · Cocody, Abidjan', 'title' => 'Apprenez la cuisine', 'highlight' => 'qui fait vivre', 'text' => 'Formations pratiques en cuisine ivoirienne, pâtisserie et traiteur, encadrées par des chefs. Petits groupes, attestation à la fin.', 'cta' => '🎓 Réserver ma place', 'cta_page' => 'inscription', 'secondary' => 'Voir les formations', 'secondary_page' => 'formations'],
            ['image' => 'banniere-menu', 'eyebrow' => 'Menu du jour · livraison Cocody & Riviera', 'title' => 'Nos plats chauds,', 'highlight' => 'commandés sur WhatsApp', 'text' => 'Attiéké poisson, kédjénou, garba, grillades : choisissez en deux clics, votre commande arrive toute prête chez nous.', 'cta' => '🍲 Commander maintenant', 'cta_page' => 'menu', 'secondary' => 'Zones de livraison', 'secondary_page' => 'menu'],
            ['image' => 'banniere-traiteur', 'eyebrow' => 'Traiteur & événements', 'title' => 'Mariages, baptêmes,', 'highlight' => 'séminaires', 'text' => 'De 20 à 300 invités, nos chefs cuisinent, livrent et dressent. Devis gratuit en moins de 24 h.', 'cta' => '🎉 Demander un devis', 'cta_page' => 'traiteur', 'secondary' => 'Voir les formules', 'secondary_page' => 'traiteur'],
        ];
    }

    /**
     * Photo credits: Wikimedia Commons pictures need attribution; Unsplash ones do not but are listed for honesty.
     *
     * @return list<array{images: string, author: string, licence: string, source: string}>
     */
    public function photoCredits(): array
    {
        return [
            ['images' => 'Attiéké et poulet braisé', 'author' => 'Prillytee', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Attieke_and_chicken.jpg'],
            ['images' => 'Alloco', 'author' => 'Krista', 'licence' => 'CC BY 2.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Aloko.jpg'],
            ['images' => 'Brochettes de poisson', 'author' => 'Fabricehouessou', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Brochettes_de_poissons_et_l%C3%A9gumes.jpg'],
            ['images' => 'Cuisine ivoirienne', 'author' => 'Louis Massuel', 'licence' => 'CC BY 3.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Cuisine_of_Ivory_Coast_(158425691).jpg'],
            ['images' => 'Cuisinières en cuisine professionnelle', 'author' => 'Aristidek5maya', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Cuisini%C3%A8re_ivoirieen.jpg'],
            ['images' => 'Foutou sauce graine', 'author' => 'Afrofoodie', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Cuisine_Ivoirienne_Foutou_sauce_graine.jpg'],
            ['images' => 'Garba', 'author' => 'Modjou', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Un_plat_de_garba.jpg'],
            ['images' => 'Attiéké poisson', 'author' => 'Jburgos', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Traditional_Garba.jpg'],
            ['images' => 'Jus de bissap, gingembre et bouye', 'author' => 'Kalamuh 045', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Jus_de_bouye,_gingembre_et_bissap_01.jpg'],
            ['images' => 'Kédjénou en marmite', 'author' => 'Cyriac Gbogou', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Kedjenou_de_poulet_dans_une_marmite.jpg'],
            ['images' => 'Kédjénou de poulet', 'author' => 'Liliane.logbo', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Kedjenou_de_Poulet.jpg'],
            ['images' => 'Placali sauce kopè', 'author' => 'Marckandy', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Placali_-_Sauce_C%C3%B4p%C3%AA.jpg'],
            ['images' => 'Sauce graine au pilon', 'author' => 'Joy.blessing08', 'licence' => 'CC BY-SA 4.0', 'source' => 'https://commons.wikimedia.org/wiki/File:Les_coulisses_de_la_sauce_graine_01.jpg'],
            ['images' => 'Bannières, pâtisseries, salle, cuisine équipée', 'author' => 'Photographes Unsplash', 'licence' => 'Licence Unsplash', 'source' => 'https://unsplash.com/license'],
        ];
    }

    /**
     * Page banners (photo shown in the page header), by page slug.
     *
     * @var array<string, string>
     */
    public const PAGE_PHOTOS = [
        'formations' => 'cuisiniere2', 'menu' => 'garba2', 'traiteur' => 'banniere-traiteur', 'calendrier' => 'cuisiniere',
        'atelier' => 'cuisine-equipee', 'reussites' => 'kedjenou', 'galerie' => 'sauce-graine1', 'avis' => 'foutou-graine',
        'inscription' => 'poelee', 'contact' => 'cuisine-ci', 'faq' => 'attieke-poulet', 'mentions-legales' => 'pain',
    ];

    public function photo(string $name): string
    {
        return asset('images/'.$name.'.jpg');
    }

    /**
     * @return list<array{name: string, role: string, text: string, rating: int, date: string}>
     */
    public function reviews(): array
    {
        return [
            ['name' => 'Aminata K.', 'role' => 'Ancienne élève, pâtisserie', 'rating' => 5, 'date' => 'Octobre 2026', 'text' => 'J’ai appris à faire mes gâteaux et aujourd’hui je vends à Angré. Les formateurs sont patients.'],
            ['name' => 'Serge D.', 'role' => 'Client traiteur', 'rating' => 5, 'date' => 'Septembre 2026', 'text' => 'Repas commandé pour le baptême de mon fils : tout le monde a demandé le contact.'],
            ['name' => 'Fatou B.', 'role' => 'Cuisinière professionnelle', 'rating' => 5, 'date' => 'Septembre 2026', 'text' => 'La formation de 6 mois m’a ouvert les portes d’un restaurant à la Riviera.'],
            ['name' => 'Jean-Marc O.', 'role' => 'Client menu', 'rating' => 4, 'date' => 'Août 2026', 'text' => 'Le kédjénou est excellent. Livraison un peu longue un vendredi soir, mais c’était chaud.'],
            ['name' => 'Awa S.', 'role' => 'Atelier du samedi', 'rating' => 5, 'date' => 'Août 2026', 'text' => 'Offert par mon mari, j’ai adoré. On repart avec la recette et le ventre plein !'],
            ['name' => 'Ibrahim C.', 'role' => 'Ancien élève, cuisine ivoirienne', 'rating' => 5, 'date' => 'Juillet 2026', 'text' => 'Groupe petit, on pratique vraiment. Je recommande.'],
        ];
    }

    /**
     * @return array<string, list<array{q: string, a: string}>>
     */
    public function faq(): array
    {
        return [
            'Formations' => [
                ['q' => 'Faut-il un diplôme pour s’inscrire ?', 'a' => 'Non. Les formations débutant sont ouvertes à tous, dès 16 ans.'],
                ['q' => 'Combien d’élèves par groupe ?', 'a' => '12 au maximum, pour que chacun pratique à son poste.'],
                ['q' => 'Les ingrédients sont-ils fournis ?', 'a' => 'Oui, tous les ingrédients des séances pratiques sont compris dans le prix.'],
                ['q' => 'Reçoit-on une attestation ?', 'a' => 'Oui, une attestation de fin de formation est remise après l’évaluation pratique.'],
            ],
            'Paiement' => [
                ['q' => 'Peut-on payer en plusieurs fois ?', 'a' => 'Oui, de 2 à 6 versements selon la formation, par Wave, Orange Money, MTN MoMo, Moov ou en espèces.'],
                ['q' => 'Faut-il verser un acompte ?', 'a' => 'Un premier versement réserve votre place ; il reste valable sur une session suivante en cas d’empêchement.'],
            ],
            'Commandes & livraison' => [
                ['q' => 'Livrez-vous les commandes du menu ?', 'a' => 'Oui, à Cocody, Riviera, Angré et environs. Frais selon la commune.'],
                ['q' => 'Jusqu’à quelle heure peut-on commander ?', 'a' => 'Jusqu’à 11h pour le déjeuner et 17h pour le dîner. Gâteaux : 48 h à l’avance.'],
            ],
        ];
    }

    /**
     * Manager area figures for one sample day.
     *
     * @return array{today: int, change: int, orders: int, signups: int, cash_in: array<string, int>, week: list<array{day: string, amount: int}>, recent: list<array{time: string, client: string, label: string, amount: int, method: string, status: string}>, best_sellers: list<array{name: string, sold: int}>}
     */
    public function dashboard(): array
    {
        return [
            'today' => 186500, 'change' => 12, 'orders' => 23, 'signups' => 4,
            'cash_in' => ['Wave' => 78000, 'Orange Money' => 46500, 'MTN MoMo' => 21000, 'Espèces' => 41000],
            'week' => [
                ['day' => 'Ven', 'amount' => 92000], ['day' => 'Sam', 'amount' => 131000], ['day' => 'Dim', 'amount' => 64000],
                ['day' => 'Lun', 'amount' => 118000], ['day' => 'Mar', 'amount' => 104000], ['day' => 'Mer', 'amount' => 166500], ['day' => 'Jeu', 'amount' => 186500],
            ],
            'recent' => [
                ['time' => '13:42', 'client' => 'Serge D.', 'label' => '2 × Kédjénou, 2 × Bissap', 'amount' => 10000, 'method' => 'Wave', 'status' => 'Livrée'],
                ['time' => '13:10', 'client' => 'Awa S.', 'label' => 'Inscription Pâtisserie (1/3)', 'amount' => 40000, 'method' => 'Orange Money', 'status' => 'Payée'],
                ['time' => '12:55', 'client' => 'Comptoir', 'label' => '3 × Garba complet', 'amount' => 4500, 'method' => 'Espèces', 'status' => 'Payée'],
                ['time' => '12:31', 'client' => 'Jean-Marc O.', 'label' => 'Poulet braisé entier', 'amount' => 7000, 'method' => 'MTN MoMo', 'status' => 'En livraison'],
                ['time' => '11:48', 'client' => 'Société BTP Angré', 'label' => '15 plateaux déjeuner', 'amount' => 60000, 'method' => 'Wave', 'status' => 'En préparation'],
            ],
            'best_sellers' => [
                ['name' => 'Attiéké poisson braisé', 'sold' => 64], ['name' => 'Garba complet', 'sold' => 51],
                ['name' => 'Kédjénou de poulet', 'sold' => 38], ['name' => 'Bissap maison 1 L', 'sold' => 33],
            ],
        ];
    }

    /**
     * @return list<array{name: string, category: string, unit: string, quantity: float, minimum: float, cost: int}>
     */
    public function stock(): array
    {
        return [
            ['name' => 'Attiéké', 'category' => 'Féculents', 'unit' => 'kg', 'quantity' => 18, 'minimum' => 10, 'cost' => 600],
            ['name' => 'Riz parfumé', 'category' => 'Féculents', 'unit' => 'kg', 'quantity' => 25, 'minimum' => 15, 'cost' => 750],
            ['name' => 'Farine T55', 'category' => 'Pâtisserie', 'unit' => 'kg', 'quantity' => 3, 'minimum' => 10, 'cost' => 900],
            ['name' => 'Beurre', 'category' => 'Pâtisserie', 'unit' => 'kg', 'quantity' => 4, 'minimum' => 3, 'cost' => 6500],
            ['name' => 'Huile rouge', 'category' => 'Huiles', 'unit' => 'L', 'quantity' => 2, 'minimum' => 5, 'cost' => 1800],
            ['name' => 'Huile végétale', 'category' => 'Huiles', 'unit' => 'L', 'quantity' => 14, 'minimum' => 8, 'cost' => 1500],
            ['name' => 'Poulet', 'category' => 'Viandes & poissons', 'unit' => 'pièce', 'quantity' => 9, 'minimum' => 6, 'cost' => 3500],
            ['name' => 'Carpe', 'category' => 'Viandes & poissons', 'unit' => 'kg', 'quantity' => 5, 'minimum' => 6, 'cost' => 2800],
            ['name' => 'Graine de palme', 'category' => 'Légumes & condiments', 'unit' => 'kg', 'quantity' => 12, 'minimum' => 5, 'cost' => 700],
            ['name' => 'Fleurs de bissap', 'category' => 'Boissons', 'unit' => 'kg', 'quantity' => 6, 'minimum' => 2, 'cost' => 2500],
        ];
    }

    /**
     * @return list<array{name: string, phone: string, type: string, detail: string, paid: int, total: int, last: string}>
     */
    public function clients(): array
    {
        return [
            ['name' => 'Awa S.', 'phone' => '07 11 22 33 44', 'type' => 'Élève', 'detail' => 'Pâtisserie · session du 11 nov.', 'paid' => 40000, 'total' => 120000, 'last' => 'Aujourd’hui'],
            ['name' => 'Ibrahim C.', 'phone' => '05 22 33 44 55', 'type' => 'Élève', 'detail' => 'Cuisinier pro · janvier', 'paid' => 175000, 'total' => 350000, 'last' => 'Hier'],
            ['name' => 'Grace L.', 'phone' => '01 33 44 55 66', 'type' => 'Élève', 'detail' => 'Cuisine ivoirienne · 3 nov.', 'paid' => 75000, 'total' => 75000, 'last' => '28 oct.'],
            ['name' => 'Serge D.', 'phone' => '07 44 55 66 77', 'type' => 'Client', 'detail' => '14 commandes · traiteur baptême', 'paid' => 0, 'total' => 0, 'last' => 'Aujourd’hui'],
            ['name' => 'Société BTP Angré', 'phone' => '27 22 00 00 00', 'type' => 'Entreprise', 'detail' => 'Plateaux déjeuner hebdo', 'paid' => 180000, 'total' => 240000, 'last' => 'Aujourd’hui'],
            ['name' => 'Jean-Marc O.', 'phone' => '05 66 77 88 99', 'type' => 'Client', 'detail' => '6 commandes', 'paid' => 0, 'total' => 0, 'last' => 'Aujourd’hui'],
        ];
    }

    public function url(string $page = ''): string
    {
        return route('page', $page === '' ? [] : ['page' => $page]);
    }

    public function trainingUrl(string $slug): string
    {
        return route('training', $slug);
    }

    public function whatsappLink(string $text): string
    {
        return 'https://wa.me/'.$this->business()['whatsapp'].'?text='.rawurlencode($text);
    }

    public function money(int|float $amount): string
    {
        return number_format($amount, 0, ',', ' ').' FCFA';
    }
}
